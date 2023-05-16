<?php
require_once 'Repository.php';
require_once __DIR__ . '/../models/Recipe.php';

class RecipeRepository extends Repository
{
    public function getRecipes(int $userId): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT r.rec_id, r.rec_title, r.rec_description, i.img_name, r.rec_prep_time, r.rec_cook_time, r.rec_servings, r.usr_id
        FROM public.recipes AS r
        LEFT JOIN public.images AS i ON r.rec_id = i.rec_id
        WHERE r.usr_id = :userId
    ');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $recipes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $recipeId = $row['rec_id']; // Pobierz identyfikator przepisu

            $stmt2 = $this->database->connect()->prepare('
            SELECT ing_text FROM public.ingredients WHERE rec_id = :id ORDER BY ing_number ASC
        ');
            $stmt2->bindParam(':id', $recipeId, PDO::PARAM_INT);
            $stmt2->execute();

            $ingredients = [];
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $ingredients[] = $row2['ing_text'];
            }

            $stmt2 = $this->database->connect()->prepare('
            SELECT ins_text FROM public.instructions WHERE rec_id = :id ORDER BY ins_number ASC
        ');
            $stmt2->bindParam(':id', $recipeId, PDO::PARAM_INT);
            $stmt2->execute();

            $instructions = [];
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $instructions[] = $row2['ins_text'];
            }

            $recipes[] = new Recipe(
                $recipeId, // Dodaj identyfikator przepisu do konstruktora
                $row['rec_title'],
                $row['rec_description'],
                $row['img_name'],
                $row['rec_prep_time'],
                $row['rec_cook_time'],
                $row['rec_servings'],
                $instructions,
                $ingredients,
                $row['usr_id']
            );
        }

        return $recipes;
    }

    public function getRecipeById(int $recipeId): ?Recipe
    {
        $stmt = $this->database->connect()->prepare('
            SELECT r.rec_id, r.rec_title, r.rec_description, i.img_name, r.rec_prep_time, r.rec_cook_time, r.rec_servings, r.usr_id
            FROM public.recipes AS r
            LEFT JOIN public.images AS i ON r.rec_id = i.rec_id
            WHERE r.rec_id = :recipeId
        ');
        $stmt->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        $recipeId = $row['rec_id'];
        $stmt2 = $this->database->connect()->prepare('
            SELECT ing_text FROM public.ingredients WHERE rec_id = :id ORDER BY ing_number ASC
        ');
        $stmt2->bindParam(':id', $recipeId, PDO::PARAM_INT);
        $stmt2->execute();

        $ingredients = [];
        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $ingredients[] = $row2['ing_text'];
        }

        $stmt2 = $this->database->connect()->prepare('
            SELECT ins_text FROM public.instructions WHERE rec_id = :id ORDER BY ins_number ASC
        ');
        $stmt2->bindParam(':id', $recipeId, PDO::PARAM_INT);
        $stmt2->execute();

        $instructions = [];
        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $instructions[] = $row2['ins_text'];
        }

        return new Recipe(
            $recipeId,
            $row['rec_title'],
            $row['rec_description'],
            $row['img_name'],
            $row['rec_prep_time'],
            $row['rec_cook_time'],
            $row['rec_servings'],
            $instructions,
            $ingredients,
            $row['usr_id']
        );
    }

    public function addRecipe(Recipe $recipe): void
    {
        $date = new DateTime();
        $connection = $this->database->connect();
        $connection->beginTransaction();

        try {
            $stmt = $connection->prepare('
            INSERT INTO public.recipes (usr_id, rec_title, rec_description, rec_prep_time, rec_cook_time, rec_servings) 
            VALUES (?, ?, ?, ?, ?, ?)
        ');

            $stmt->execute([
                $recipe->getUserId(),
                $recipe->getTitle(),
                $recipe->getDescription(),
                $recipe->getPrepTime(),
                $recipe->getCookTime(),
                $recipe->getServings(),
            ]);

            $stmt->closeCursor();

            $recId = $connection->lastInsertId(); // using the same connection

            // img
            $image = $recipe->getImage();
            if ($image) {
                $stmt = $connection->prepare('
                INSERT INTO public.images (rec_id, img_name)
                VALUES (?, ?)
            ');

                $stmt->execute([
                    $recId,
                    $image,
                ]);
            }

            // ing
            $ingredients = $recipe->getIngredients();
            foreach ($ingredients as $index => $ingredient) {
                $stmt = $connection->prepare('
                INSERT INTO public.ingredients (rec_id, ing_number, ing_text)
                VALUES (?, ?, ?)
            ');

                $stmt->execute([
                    $recId,
                    $index + 1, // num
                    $ingredient,
                ]);
            }

            // ins
            $instructions = $recipe->getInstructions();
            foreach ($instructions as $index => $instruction) {
                $stmt = $connection->prepare('
                INSERT INTO public.instructions (rec_id, ins_number, ins_text)
                VALUES (?, ?, ?)
            ');

                $stmt->execute([
                    $recId,
                    $index + 1, // num
                    $instruction,
                ]);
            }

            $connection->commit();
        } catch (PDOException $e) {
            $connection->rollBack();
            throw $e;
        }
    }

    public function removeRecipe(int $recipeId): void
    {
        $stmt = $this->database->connect()->prepare('
        DELETE FROM public.recipes WHERE rec_id = :recipeId
    ');
        $stmt->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
        $stmt->execute();
    }

//search V
    public function getRecipeByTitle(string $searchString, int $userId): array
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
        SELECT r.rec_id, r.rec_title, r.rec_description, i.img_name, r.rec_prep_time, r.rec_cook_time, r.rec_servings, r.usr_id
        FROM public.recipes AS r
        LEFT JOIN public.images AS i ON r.rec_id = i.rec_id
        WHERE LOWER(r.rec_title) LIKE :search
        AND r.usr_id = :userId
    ');

        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}