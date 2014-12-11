<?php

// Init
include($_SERVER['DOCUMENT_ROOT'] . '/app/core/initialize.php');

// Main Sections
Router::add('/', '/app/controllers/home.php');

// Users
Router::add('/profile', '/app/controllers/users/profile.php');
Router::add('/login', '/app/controllers/users/login.php');
Router::add('/logout', '/app/controllers/users/logout.php');
// Router::add('/users/register', '/app/controllers/users/register/form.php');
// Router::add('/users/register/process_form/', '/app/controllers/users/register/process_form.php');

//Toppings
Router::add('/toppings/add', '/app/controllers/toppings/add.php');
Router::add('/toppings/remove', '/app/controllers/toppings/remove.php');


//Suggestions
Router::add('/build', '/app/controllers/build_suggestion.php');
Router::add('/suggestions', '/app/controllers/suggestions.php');

//Order History
Router::add('/orders/add', '/app/controllers/orders/add.php');
Router::add('/orders/down', '/app/controllers/orders/down.php');

// Issue Route
Router::route();