<?php

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

// Database
require __DIR__ . '/app/Database.php';

// Session
if (session_id() == '') {
    session_start();
}

// Functions
require __DIR__ . '/app/functions.php';

// Routes
$router = new \Bramus\Router\Router();
$router->setNamespace('App\Controllers');

$router->get('/', 'TaskController@getTasks');
$router->get('/login', 'UserController@loginPage');
$router->get('/logout', 'UserController@logout');
$router->post('/add-task', 'TaskController@addTask');
$router->post('/update-task', 'TaskController@updateTask');
$router->post('/login', 'UserController@login');

$router->run();

