<?php

/**
 * Route Configuration File
 * 
 * This file defines all the routes for the MVC application.
 * Routes map URLs to specific controller methods, enabling
 * clean, SEO-friendly URLs and proper MVC separation.
 * 
 * Route Pattern: [HTTP_METHOD, URL_PATTERN, CONTROLLER@METHOD]
 * 
 * Examples:
 * - ['GET', '/', 'HomeController@index'] - Homepage
 * - ['GET', '/users/{id}', 'UserController@show'] - User details
 * - ['POST', '/users', 'UserController@store'] - Create user
 * 
 * @package Config
 * @author Your Name
 * @version 1.0
 */

// Get the router instance
$router = $this;

/**
 * Home Routes
 * Basic routes for the main website pages
 */
$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');
$router->post('/contact', 'HomeController@contact');

/**
 * User Routes (RESTful)
 * Demonstrates full CRUD operations for users
 * 
 * GET    /users          - List all users
 * GET    /users/{id}     - Show specific user
 * GET    /users/create   - Show create form
 * POST   /users          - Store new user
 * GET    /users/{id}/edit - Show edit form
 * PUT    /users/{id}     - Update user
 * DELETE /users/{id}     - Delete user
 */
$router->get('/users', 'UserController@index');
$router->get('/users/create', 'UserController@create');
$router->post('/users', 'UserController@store');
$router->get('/users/{id}', 'UserController@show');
$router->get('/users/{id}/edit', 'UserController@edit');
$router->put('/users/{id}', 'UserController@update');
$router->delete('/users/{id}', 'UserController@destroy');

/**
 * Post Routes (RESTful)
 * Blog post management routes
 */
$router->get('/posts', 'PostController@index');
$router->get('/posts/create', 'PostController@create');
$router->post('/posts', 'PostController@store');
$router->get('/posts/{id}', 'PostController@show');
$router->get('/posts/{id}/edit', 'PostController@edit');
$router->put('/posts/{id}', 'PostController@update');
$router->delete('/posts/{id}', 'PostController@destroy');

/**
 * API Routes
 * RESTful API endpoints for AJAX requests
 */
$router->group('/api', function() use ($router) {
    // User API
    $router->get('/users', 'Api\UserController@index');
    $router->post('/users', 'Api\UserController@store');
    $router->get('/users/{id}', 'Api\UserController@show');
    $router->put('/users/{id}', 'Api\UserController@update');
    $router->delete('/users/{id}', 'Api\UserController@destroy');
    
    // Post API
    $router->get('/posts', 'Api\PostController@index');
    $router->post('/posts', 'Api\PostController@store');
    $router->get('/posts/{id}', 'Api\PostController@show');
    $router->put('/posts/{id}', 'Api\PostController@update');
    $router->delete('/posts/{id}', 'Api\PostController@destroy');
});

/**
 * Authentication Routes
 * User authentication and session management
 */
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->post('/logout', 'AuthController@logout');

/**
 * Admin Routes
 * Administrative interface routes
 */
$router->group('/admin', function() use ($router) {
    $router->get('/', 'AdminController@dashboard');
    $router->get('/users', 'AdminController@users');
    $router->get('/posts', 'AdminController@posts');
    $router->get('/settings', 'AdminController@settings');
});

/**
 * Route Middleware Examples
 * These routes demonstrate middleware usage for authentication,
 * authorization, and other cross-cutting concerns
 */

// Protected routes requiring authentication
$router->group(['middleware' => 'auth'], function() use ($router) {
    $router->get('/dashboard', 'DashboardController@index');
    $router->get('/profile', 'ProfileController@show');
    $router->put('/profile', 'ProfileController@update');
});

// Admin-only routes
$router->group(['middleware' => ['auth', 'admin']], function() use ($router) {
    $router->get('/admin/users', 'AdminController@users');
    $router->delete('/admin/users/{id}', 'AdminController@deleteUser');
});

/**
 * Error Handling Routes
 * Custom error pages for different HTTP status codes
 */
$router->get('/404', 'ErrorController@notFound');
$router->get('/500', 'ErrorController@serverError');
$router->get('/403', 'ErrorController@forbidden');

/**
 * Fallback Route
 * Catches all unmatched routes and displays 404 page
 */
$router->fallback('ErrorController@notFound');

/**
 * Example of route with multiple parameters
 * URL: /users/123/posts/456
 */
$router->get('/users/{userId}/posts/{postId}', 'PostController@showUserPost');

/**
 * Example of route with optional parameters
 * URL: /search or /search/users
 */
$router->get('/search/{type?}', 'SearchController@index');

/**
 * Example of route with constraints
 * Only matches if id is numeric
 */
$router->get('/users/{id}', 'UserController@show')->where('id', '[0-9]+');

/**
 * Example of named routes for easy URL generation
 */
$router->get('/users/{id}', 'UserController@show')->name('user.show');
$router->get('/posts/{id}', 'PostController@show')->name('post.show');

/**
 * Resource routes - shorthand for full CRUD operations
 * This single line creates all the RESTful routes for a resource
 */
// $router->resource('users', 'UserController');
// $router->resource('posts', 'PostController');

/**
 * Route caching configuration
 * In production, routes can be cached for better performance
 */
if (getenv('APP_ENV') === 'production') {
    $router->cache(true);
}

// Return the configured router
return $router;
