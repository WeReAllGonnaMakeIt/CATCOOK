<!DOCTYPE html>
<html lang="en">
<head>
    <!-- fontawsome -->
    <script src="https://kit.fontawesome.com/53918a8daa.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <script type="text/javascript" src="./public/js/search.js" defer></script>
</head>
<body>
    <header>
        <nav class="nav">
            <div class="nav-center">
                <div class="nav-borgir">
                    <a href="main" class="nav-logo">
                    <img src="public/assets/svg/logo.svg"/>
                    </a>
                    <button class="nav-btn">
                    <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
                <div class="nav-links">
                        <form class = "search-form">
                            <input class="nav-search-input" type = "text" placeholder="search for recipe">
                            <button class="nav-search-button" type = "submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    <a href="addRecipe" class="nav-link"> ADD RECIPE </a>
                    <a href="logout" class="nav-button"> LOGOUT </a>
                </div>
            </div>
        </nav>
    </header>
    <main class="page">
          <section class="recipes-list">
              <?php foreach ($recipes as $recipe): ?>
                  <a href="recipe?recipe_id=<?=$recipe->getId();?>" class="recipe">
                      <img src="public/uploads/<?=$recipe->getImage();?>" class="img recipe-img"/>
                      <h5><?=$recipe->getTitle();?></h5>
                  </a>
            <?php endforeach;?>
          </section>

    </main>

    <script src="public/js/script.js"></script>

</body>
<template id="recipe-template">
    <a href="" class="recipe">
        <img src="" class="img recipe-img"/>
        <h5 class="recipe-title">title</h5>
    </a>
</template>
</html>

