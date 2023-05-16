<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Recipe.php';
require_once __DIR__ . '/../repository/RecipeRepository.php';

class RecipeController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';
    private $messages = [];
    private $recipeRepository;

    public function __construct()
    {
        parent::__construct();
        $this->recipeRepository = new RecipeRepository();
    }

    public function main()
    {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $recipes = $this->recipeRepository->getRecipes($userId);
            $this->render('main', ['recipes' => $recipes]);
        } else {
            return $this->render('login', ['messages' => ['nice try!']]);
        }
    }

    public function addRecipe()
    {
        if (isset($_SESSION['user_id'])) {
            if ($this->isPost() && is_uploaded_file($_FILES['recipe_image']['tmp_name']) && $this->validate($_FILES['recipe_image'])) {

                $extension = pathinfo($_FILES['recipe_image']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid('', true) . '.' . $extension;

                move_uploaded_file(
                    $_FILES['recipe_image']['tmp_name'],
                    dirname(__DIR__) . self::UPLOAD_DIRECTORY . $fileName
                );

                $title = $_POST['recipe_title'];
                $description = $_POST['recipe_description'];
                $image = $fileName;
                $prepTime = $_POST['prep_time'];
                $cookTime = $_POST['cook_time'];
                $servings = $_POST['servings'];
                $instructions = $_POST['instruction'] ?? [];
                $ingredients = $_POST['ingredient'] ?? [];

                $userId = $_SESSION['user_id'];

                $recipe = new Recipe(null, $title, $description, $image, $prepTime, $cookTime, $servings, $instructions, $ingredients, $userId);
                $this->recipeRepository->addRecipe($recipe);

                header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/main');
            }

            $this->render('addRecipe', ['messages' => $this->messages]);
        } else {
            return $this->render('login', ['messages' => ['nice try!']]);
        }
    }

    public function recipe()
    {
        if (isset($_SESSION['user_id'])) {
            if (isset($_GET['recipe_id'])) {
                $recipeId = $_GET['recipe_id'];
                $recipe = $this->recipeRepository->getRecipeById($recipeId);
                $this->render('recipe', ['recipe' => $recipe]);
            } else {
                echo "Recipe ID not provided.";
            }
        } else {
            return $this->render('login', ['messages' => ['nice try!']]);
        }
    }

    public function removeRecipe()
    {
        if ($this->isPost() && isset($_POST['recipe_id'])) {
            $recipeId = $_POST['recipe_id'];
            $this->recipeRepository->removeRecipe($recipeId);
            header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/main');
        }
    }

    //search V
    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $userId = $_SESSION['user_id'];

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->recipeRepository->getRecipeByTitle($decoded['search'], $userId));
        }
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'File is too large!';
            return false;
        }
        if (!isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->messages[] = 'File type is not supported!';
            return false;
        }
        return true;
    }
}