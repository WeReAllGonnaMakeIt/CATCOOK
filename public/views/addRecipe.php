<!DOCTYPE html>
<html lang="en">
<head>
    <!-- fontawsome -->
    <script src="https://kit.fontawesome.com/53918a8daa.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add</title>
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
        <form action="addRecipe" method="POST" enctype="multipart/form-data">
            <div class="message">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo @$message;
                    }
                }
                ?>
            </div>
            <section class="recipe-hero">
                <input type="file" id="recipe-image" name="recipe_image" accept="image/*" class="recipe-image-input" required>
                <article class="recipe-info">
                    <h2><input type="text" id="recipe-title" name="recipe_title" placeholder="Recipe title" required></h2>
                    <p>
                        <input type="text" id="recipe-description" name="recipe_description" placeholder="Recipe description" required>
                    </p>
                    <div class="recipe-icons">
                        <div class="recipe-icon-and-description">
                            <i class="fa-solid fa-clock"></i>
                            <h5>prep time:</h5>
                            <input type="text" id="prep-time" name="prep_time" placeholder="Prep time" required>
                        </div>
                        <div class="recipe-icon-and-description">
                            <i class="fa-solid fa-stopwatch"></i>
                            <h5>cook time:</h5>
                            <input type="text" id="cook-time" name="cook_time" placeholder="Cook time" required>
                        </div>
                        <div class="recipe-icon-and-description">
                            <i class="fa-solid fa-users"></i>
                            <h5>servings:</h5>
                            <input type="text" id="servings" name="servings" placeholder="Servings" required>
                        </div>
                    </div>
                </article>
            </section>
            <section class="recipe-content">
                <article class="instructions">
                    <h4>instructions</h4>
                    <ul class="instruction-list" id="instruction-list">
                        <li>
                            <input type="text" name="instruction[]" placeholder="Instruction 1" required>
                        </li>
                    </ul>
                    <button type="button" id="add-instruction-btn"><i class="fa-solid fa-plus"></i></button>
                </article>
                <article class="ingredients">
                    <h4>ingredients</h4>
                    <ul class="ingredient-list" id="ingredient-list">
                        <li>
                            <input type="text" name="ingredient[]" placeholder="Ingredient 1" required>
                        </li>
                    </ul>
                    <button type="button" id="add-ingredient-btn"><i class="fa-solid fa-plus"></i></button>
                </article>
            </section>
            <button class="add-button" type="submit">Add!</button>
        </form>
    </div>
</main>
<script src="public/js/script.js"></script>
</body>
</html>