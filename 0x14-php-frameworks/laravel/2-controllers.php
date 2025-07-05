<?php
/**
 * Laravel Controllers Example
 * 
 * Demonstrates creating and using controllers in Laravel,
 * including resource controllers and dependency injection.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Basic controller example
class UserController extends Controller
{
    /**
     * Show user profile
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "Showing user profile for ID: {$id}";
    }
    
    /**
     * Store a new user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
        ]);
        
        // Store the user...
        return "User created successfully!";
    }
}

// Resource controller example
// Route::resource('users', 'UserController');
// This single line creates routes for:
// GET /users          - index
// GET /users/create   - create
// POST /users         - store
// GET /users/{id}     - show
// GET /users/{id}/edit - edit
// PUT/PATCH /users/{id} - update
// DELETE /users/{id}  - destroy

echo "Controller examples. Create controllers using Artisan:\n";
echo "$ php artisan make:controller UserController\n";
echo "$ php artisan make:controller PhotoController --resource\n";
?>
