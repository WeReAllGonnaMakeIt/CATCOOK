<!DOCTYPE html>
<html lang="en">
<head>
    <!-- fontawsome -->
    <script src="https://kit.fontawesome.com/53918a8daa.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">

</head>
<body>
    <header>
        <nav class="nav">
            <div class="nav-center">
                <div class="nav-borgir">
                    <a href="main" class="nav-logo"><img src="public/assets/svg/logo.svg"/></a>
                    <button class="nav-btn"><i class="fa-solid fa-bars"></i></button>
                </div>
                <div class="nav-links">
                    <a href="addRecipe" class="nav-link"> ADD RECIPE </a>
                    <a href="logout" class="nav-button"> LOGOUT </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="page">
        <div class="recipe-page">
            <section class="recipe-hero">
                <img src="public/uploads/<?=$recipe->getImage();?>" class="img recipe-hero-img"/>
                <article class="recipe-info">
                    <h2><?php echo $recipe->getTitle(); ?></h2>
                    <p>
                        <?php echo $recipe->getDescription(); ?>
                    </p>
                    <div class="recipe-icons">
                        <div class="recipe-icon-and-description">
                            <i class="fa-solid fa-clock"></i>
                            <h5>prep time:</h5>
                            <p><?php echo $recipe->getPrepTime();?></p>
                        </div>
                        <div class="recipe-icon-and-description">
                            <i class="fa-solid fa-stopwatch"></i>
                            <h5>cook time:</h5>
                            <p><?php echo $recipe->getCookTime(); ?></p>
                        </div>
                        <div class="recipe-icon-and-description">
                            <i class="fa-solid fa-users"></i>
                            <h5>servings:</h5>
                            <p><?php echo $recipe->getServings(); ?></p>
                        </div>
                    </div>
                </article>
            </section>
            <!-- content -->
            <section class="recipe-content">
                <article class="instructions">
                    <h4>instructions</h4>
                    <!-- single instruction -->
                    <?php
                    $instructions = $recipe->getInstructions();
                    foreach ($instructions as $index => $instruction) {
                        echo '<div class="single-instruction">';
                        echo '<header>';
                        echo '<p>step ' . ($index + 1) . '</p>';
                        echo '</header>';
                        echo '<p>' . $instruction . '</p>';
                        echo '</div>';
                    }
                    ?>
                </article>
                <article class="ingredients">
                    <h4>ingredients</h4>
                    <?php
                    $ingredients = $recipe->getIngredients();
                    foreach ($ingredients as $ingredient) {
                        echo '<p class="single-ingredient">' . $ingredient . '</p>';
                    }
                    ?>
                </article>
            </section>
            <form action="removeRecipe" method="post">
                <input type="hidden" name="recipe_id" value="<?php echo $recipe->getId(); ?>">
                <button class="remove-button" type="submit">Remove?</button>
            </form>
        </div>
      </main>

    <script src="public/js/script.js"></script>

</body>
</html>

