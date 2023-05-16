const searchForm = document.querySelector('.search-form');
const recipeContainer = document.querySelector('.recipes-list');

searchForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const searchInput = searchForm.querySelector('.nav-search-input');
    const searchData = { search: searchInput.value };

    fetch('/search', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(searchData),
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (recipes) {
            recipeContainer.innerHTML = '';
            loadRecipes(recipes);
        });
});

function loadRecipes(recipes) {
    recipeContainer.innerHTML = "";

    recipes.forEach(recipe => {
        createRecipe(recipe);
    });
}

function createRecipe(recipe) {
    const template = document.querySelector("#recipe-template");

    const clone = template.content.cloneNode(true);
    const a = clone.querySelector("a");
    a.href = `recipe?recipe_id=${recipe.rec_id}`;
    const image = clone.querySelector(".recipe-img");
    image.src = `public/uploads/${recipe.img_name}`;
    const title = clone.querySelector("h5");
    title.innerHTML = recipe.rec_title;

    recipeContainer.appendChild(clone);
}