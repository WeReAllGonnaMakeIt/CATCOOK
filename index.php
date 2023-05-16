<?php

require 'Router.php';

session_start();

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::post('', 'DefaultController');
Router::post('login', 'SecurityController');
Router::post('removeRecipe', 'RecipeController');
Router::post('addRecipe', 'RecipeController');
Router::post('logout', 'SecurityController');
Router::post('register', 'SecurityController');

Router::get('main', 'RecipeController');
Router::get('recipe', 'RecipeController');
Router::get('search', 'RecipeController');

Router::run($path);

