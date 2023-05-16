<?php

class Recipe
{
    private $id;
    private $title;
    private $description;
    private $image;
    private $prepTime;
    private $cookTime;
    private $servings;
    private $instructions;
    private $ingredients;
    private $userId;

    public function __construct($id, $title, $description, $image, $prepTime, $cookTime, $servings, $instructions, $ingredients, $userId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->prepTime = $prepTime;
        $this->cookTime = $cookTime;
        $this->servings = $servings;
        $this->instructions = $instructions;
        $this->ingredients = $ingredients;
        $this->userId = $userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getPrepTime(): string
    {
        return $this->prepTime;
    }

    public function setPrepTime(string $prepTime): void
    {
        $this->prepTime = $prepTime;
    }

    public function getCookTime(): string
    {
        return $this->cookTime;
    }

    public function setCookTime(string $cookTime): void
    {
        $this->cookTime = $cookTime;
    }

    public function getServings(): string
    {
        return $this->servings;
    }

    public function setServings(string $servings): void
    {
        $this->servings = $servings;
    }

    public function getInstructions(): array
    {
        return $this->instructions;
    }

    public function setInstructions(array $instructions): void
    {
        $this->instructions = $instructions;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function getId(): int
    {
        return $this->id;
    }
}