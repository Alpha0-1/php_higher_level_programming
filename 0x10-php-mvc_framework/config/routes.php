<?php
/**
 * Route Definitions
 * Define all application routes here
 */

// Home routes
$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');

// User routes
$router->get('/users', 'UserController@index');
$router->get('/users/create', 'UserController@create');
$router->post('/users', 'UserController@store');
$router->get('/users/{id}', 'UserController@show');
$router->get('/users/{id}/edit', 'UserController@edit');
$router->put('/users/{id}', 'UserController@update');
$router->delete('/users/{id}', 'UserController@destroy');

// Post routes
$router->get('/posts', 'PostController@index');
$router->get('/posts/create', 'PostController@create');
$router->post('/posts', 'PostController@store');
$router->get('/posts/{id}', 'PostController@show');
$router->get('/posts/{id}/edit', 'PostController@edit');
$router->put('/posts/{id}', 'PostController@update');
$router->delete('/posts/{id}', 'PostController@destroy');

// API routes
$router->get('/api/users', 'UserController@apiIndex');
$router->get('/api/posts', 'PostController@apiIndex');

