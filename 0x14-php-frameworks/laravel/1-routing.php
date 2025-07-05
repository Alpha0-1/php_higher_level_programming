<?php
/**
 * Laravel Routing Example
 * 
 * Demonstrates basic routing in Laravel including route parameters,
 * named routes, and route groups.
 */

use Illuminate\Support\Facades\Route;

// Basic GET route
Route::get('/', function () {
    return 'Welcome to our homepage!';
});

// Route with parameters
Route::get('/user/{id}', function ($id) {
    return "User Profile - ID: {$id}";
});

// Named route example
Route::get('/dashboard', function () {
    return 'Dashboard Page';
})->name('dashboard');

// Route group with middleware and prefix
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/users', function () {
        return 'Admin Users Page';
    });
    
    Route::get('/settings', function () {
        return 'Admin Settings Page';
    });
});

// Controller route example
// Route::get('/products', 'ProductController@index');

echo "Laravel routing examples. These would typically be in routes/web.php.\n";
echo "Access routes like:\n";
echo "- / \n- /user/123 \n- /dashboard \n- /admin/users (requires auth)\n";
?>
