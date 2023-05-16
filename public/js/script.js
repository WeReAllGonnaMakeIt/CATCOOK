const getElement = (selector) => {
    const element = document.querySelector(selector);

    if (element) return element;
    throw Error(
        `Please double check your class names, there is no ${selector} class`
    );
};

const links = getElement('.nav-links');
const navBtnDOM = getElement('.nav-btn');

navBtnDOM.addEventListener('click', () => {
    links.classList.toggle('show-links');
});

document.addEventListener("DOMContentLoaded", function () {
    var addInstructionButton = document.getElementById("add-instruction-btn");
    var addIngredientButton = document.getElementById("add-ingredient-btn");
    var instructionList = document.getElementById("instruction-list");
    var ingredientList = document.getElementById("ingredient-list");

    var instructionCount = 1;
    var ingredientCount = 1;

    addInstructionButton.addEventListener("click", function () {
        var newInstructionInput = document.createElement("input");
        newInstructionInput.setAttribute("type", "text");
        newInstructionInput.setAttribute("name", "instruction[]");
        newInstructionInput.setAttribute("placeholder", "Instruction " + (instructionCount + 1));

        var newInstructionItem = document.createElement("li");
        newInstructionItem.appendChild(newInstructionInput);
        instructionList.appendChild(newInstructionItem);

        instructionCount++;
    });

    addIngredientButton.addEventListener("click", function () {
        var newIngredientInput = document.createElement("input");
        newIngredientInput.setAttribute("type", "text");
        newIngredientInput.setAttribute("name", "ingredient[]");
        newIngredientInput.setAttribute("placeholder", "Ingredient " + (ingredientCount + 1));

        var newIngredientItem = document.createElement("li");
        newIngredientItem.appendChild(newIngredientInput);
        ingredientList.appendChild(newIngredientItem);

        ingredientCount++;
    });
});