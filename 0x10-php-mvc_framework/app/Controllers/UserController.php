<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use Core\Request;
use Core\Response;
use Core\Session;
use Core\Validator;

/**
 * UserController - Handles user-related operations
 * 
 * This controller demonstrates CRUD operations for users in an MVC framework.
 * It showcases how to handle HTTP requests, validate data, interact with models,
 * and render views with proper error handling.
 * 
 * @package App\Controllers
 * @author Your Name
 */
class UserController extends Controller
{
    /**
     * @var User The User model instance
     */
    private $userModel;

    /**
     * Constructor - Initialize the User model
     */
    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Display a listing of users
     * 
     * This method demonstrates how to retrieve data from a model
     * and pass it to a view for display.
     * 
     * @param Request $request The HTTP request object
     * @return Response The HTTP response
     */
    public function index(Request $request)
    {
        try {
            // Get pagination parameters from request
            $page = $request->get('page', 1);
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Retrieve users with pagination
            $users = $this->userModel->paginate($limit, $offset);
            $totalUsers = $this->userModel->count();
            $totalPages = ceil($totalUsers / $limit);

            // Prepare data for the view
            $data = [
                'users' => $users,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'title' => 'All Users'
            ];

            // Render the view with data
            return $this->view('users/index', $data);

        } catch (Exception $e) {
            // Handle errors gracefully
            Session::flash('error', 'Unable to retrieve users: ' . $e->getMessage());
            return $this->redirect('/');
        }
    }

    /**
     * Display a specific user
     * 
     * This method shows how to handle route parameters and display
     * a single resource with error handling for not found cases.
     * 
     * @param Request $request The HTTP request object
     * @param int $id The user ID from the route
     * @return Response The HTTP response
     */
    public function show(Request $request, $id)
    {
        try {
            // Validate the ID parameter
            if (!is_numeric($id) || $id <= 0) {
                Session::flash('error', 'Invalid user ID provided');
                return $this->redirect('/users');
            }

            // Find the user by ID
            $user = $this->userModel->find($id);

            if (!$user) {
                Session::flash('error', 'User not found');
                return $this->redirect('/users');
            }

            // Prepare data for the view
            $data = [
                'user' => $user,
                'title' => 'User: ' . $user['name']
            ];

            return $this->view('users/show', $data);

        } catch (Exception $e) {
            Session::flash('error', 'Error retrieving user: ' . $e->getMessage());
            return $this->redirect('/users');
        }
    }

    /**
     * Show the form for creating a new user
     * 
     * This method demonstrates how to display a form view
     * with any validation errors from previous attempts.
     * 
     * @param Request $request The HTTP request object
     * @return Response The HTTP response
     */
    public function create(Request $request)
    {
        $data = [
            'title' => 'Create New User',
            'errors' => Session::get('errors', []),
            'old' => Session::get('old', [])
        ];

        // Clear old session data
        Session::forget('errors');
        Session::forget('old');

        return $this->view('users/create', $data);
    }

    /**
     * Store a newly created user
     * 
     * This method demonstrates form validation, data processing,
     * and redirecting with success/error messages.
     * 
     * @param Request $request The HTTP request object
     * @return Response The HTTP response
     */
    public function store(Request $request)
    {
        try {
            // Define validation rules
            $rules = [
                'name' => 'required|min:2|max:50',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'age' => 'numeric|min:18|max:120'
            ];

            // Validate the request data
            $validator = new Validator();
            $validation = $validator->validate($request->all(), $rules);

            if (!$validation['isValid']) {
                // Store validation errors and old input in session
                Session::flash('errors', $validation['errors']);
                Session::flash('old', $request->all());
                return $this->redirect('/users/create');
            }

            // Prepare user data for storage
            $userData = [
                'name' => trim($request->input('name')),
                'email' => strtolower(trim($request->input('email'))),
                'password' => password_hash($request->input('password'), PASSWORD_DEFAULT),
                'age' => (int)$request->input('age'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Create the user
            $userId = $this->userModel->create($userData);

            if ($userId) {
                Session::flash('success', 'User created successfully!');
                return $this->redirect('/users/' . $userId);
            } else {
                Session::flash('error', 'Failed to create user');
                return $this->redirect('/users/create');
            }

        } catch (Exception $e) {
            Session::flash('error', 'Error creating user: ' . $e->getMessage());
            Session::flash('old', $request->all());
            return $this->redirect('/users/create');
        }
    }

    /**
     * Show the form for editing a user
     * 
     * This method demonstrates how to populate a form with existing data
     * for editing purposes.
     * 
     * @param Request $request The HTTP request object
     * @param int $id The user ID from the route
     * @return Response The HTTP response
     */
    public function edit(Request $request, $id)
    {
        try {
            // Validate the ID parameter
            if (!is_numeric($id) || $id <= 0) {
                Session::flash('error', 'Invalid user ID provided');
                return $this->redirect('/users');
            }

            // Find the user by ID
            $user = $this->userModel->find($id);

            if (!$user) {
                Session::flash('error', 'User not found');
                return $this->redirect('/users');
            }

            // Prepare data for the view
            $data = [
                'user' => $user,
                'title' => 'Edit User: ' . $user['name'],
                'errors' => Session::get('errors', []),
                'old' => Session::get('old', [])
            ];

            // Clear old session data
            Session::forget('errors');
            Session::forget('old');

            return $this->view('users/edit', $data);

        } catch (Exception $e) {
            Session::flash('error', 'Error retrieving user: ' . $e->getMessage());
            return $this->redirect('/users');
        }
    }

    /**
     * Update an existing user
     * 
     * This method demonstrates updating existing records with validation
     * and handling unique constraints.
     * 
     * @param Request $request The HTTP request object
     * @param int $id The user ID from the route
     * @return Response The HTTP response
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate the ID parameter
            if (!is_numeric($id) || $id <= 0) {
                Session::flash('error', 'Invalid user ID provided');
                return $this->redirect('/users');
            }

            // Check if user exists
            $existingUser = $this->userModel->find($id);
            if (!$existingUser) {
                Session::flash('error', 'User not found');
                return $this->redirect('/users');
            }

            // Define validation rules (email unique except for current user)
            $rules = [
                'name' => 'required|min:2|max:50',
                'email' => 'required|email|unique:users,email,' . $id,
                'age' => 'numeric|min:18|max:120'
            ];

            // Add password validation only if password is provided
            if ($request->input('password')) {
                $rules['password'] = 'min:8|confirmed';
            }

            // Validate the request data
            $validator = new Validator();
            $validation = $validator->validate($request->all(), $rules);

            if (!$validation['isValid']) {
                Session::flash('errors', $validation['errors']);
                Session::flash('old', $request->all());
                return $this->redirect('/users/' . $id . '/edit');
            }

            // Prepare user data for update
            $userData = [
                'name' => trim($request->input('name')),
                'email' => strtolower(trim($request->input('email'))),
                'age' => (int)$request->input('age'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Update password only if provided
            if ($request->input('password')) {
                $userData['password'] = password_hash($request->input('password'), PASSWORD_DEFAULT);
            }

            // Update the user
            $updated = $this->userModel->update($id, $userData);

            if ($updated) {
                Session::flash('success', 'User updated successfully!');
                return $this->redirect('/users/' . $id);
            } else {
                Session::flash('error', 'Failed to update user');
                return $this->redirect('/users/' . $id . '/edit');
            }

        } catch (Exception $e) {
            Session::flash('error', 'Error updating user: ' . $e->getMessage());
            Session::flash('old', $request->all());
            return $this->redirect('/users/' . $id . '/edit');
        }
    }

    /**
     * Delete a user
     * 
     * This method demonstrates safe deletion with confirmation
     * and proper error handling.
     * 
     * @param Request $request The HTTP request object
     * @param int $id The user ID from the route
     * @return Response The HTTP response
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Validate the ID parameter
            if (!is_numeric($id) || $id <= 0) {
                Session::flash('error', 'Invalid user ID provided');
                return $this->redirect('/users');
            }

            // Check if user exists
            $user = $this->userModel->find($id);
            if (!$user) {
                Session::flash('error', 'User not found');
                return $this->redirect('/users');
            }

            // Delete the user
            $deleted = $this->userModel->delete($id);

            if ($deleted) {
                Session::flash('success', 'User deleted successfully!');
            } else {
                Session::flash('error', 'Failed to delete user');
            }

            return $this->redirect('/users');

        } catch (Exception $e) {
            Session::flash('error', 'Error deleting user: ' . $e->getMessage());
            return $this->redirect('/users');
        }
    }

    /**
     * Search users by name or email
     * 
     * This method demonstrates implementing search functionality
     * with proper sanitization and pagination.
     * 
     * @param Request $request The HTTP request object
     * @return Response The HTTP response
     */
    public function search(Request $request)
    {
        try {
            $query = trim($request->get('q', ''));
            
            if (empty($query)) {
                return $this->redirect('/users');
            }

            // Search users
            $users = $this->userModel->search($query);

            $data = [
                'users' => $users,
                'query' => $query,
                'title' => 'Search Results for: ' . $query
            ];

            return $this->view('users/index', $data);

        } catch (Exception $e) {
            Session::flash('error', 'Error searching users: ' . $e->getMessage());
            return $this->redirect('/users');
        }
    }
}
