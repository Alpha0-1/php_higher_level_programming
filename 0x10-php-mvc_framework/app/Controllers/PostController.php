<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Post;
use App\Models\User;
use Core\Request;
use Core\Response;
use Core\Session;
use Core\Validator;

/**
 * PostController - Handles blog post operations
 * 
 * This controller demonstrates advanced CRUD operations for blog posts,
 * including relationships with users, file uploads, and content management.
 * It showcases how to handle complex data relationships in an MVC framework.
 * 
 * @package App\Controllers
 * @author Your Name
 */
class PostController extends Controller
{
    /**
     * @var Post The Post model instance
     */
    private $postModel;

    /**
     * @var User The User model instance
     */
    private $userModel;

    /**
     * Constructor - Initialize the models
     */
    public function __construct()
    {
        $this->postModel = new Post();
        $this->userModel = new User();
    }

    /**
     * Display a listing of posts
     * 
     * This method demonstrates how to retrieve posts with their associated
     * user data and implement pagination with search functionality.
     * 
     * @param Request $request The HTTP request object
     * @return Response The HTTP response
     */
    public function index(Request $request)
    {
        try {
            // Get pagination and filter parameters
            $page = $request->get('page', 1);
            $limit = 12;
            $offset = ($page - 1) * $limit;
            $category = $request->get('category', '');
            $author = $request->get('author', '');

            // Build filter conditions
            $filters = [];
            if (!empty($category)) {
                $filters['category'] = $category;
            }
            if (!empty($author)) {
                $filters['author_id'] = $author;
            }

            // Retrieve posts with relationships
            $posts = $this->postModel->getWithAuthor($limit, $offset, $filters);
            $totalPosts = $this->postModel->count($filters);
            $totalPages = ceil($totalPosts / $limit);

            // Get categories and authors for filter dropdowns
            $categories = $this->postModel->getCategories();
            $authors = $this->userModel->getAuthors();

            // Prepare data for the view
            $data = [
                'posts' => $posts,
                'categories' => $categories,
                'authors' => $authors,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'selectedCategory' => $category,
                'selectedAuthor' => $author,
                'title' => 'All Posts'
            ];

            return $this->view('posts/index', $data);

        } catch (Exception $e) {
            Session::flash('error', 'Unable to retrieve posts: ' . $e->getMessage());
            return $this->redirect('/');
        }
    }

    /**
     * Display a specific post
     * 
     * This method shows how to display a single post with its full content,
     * author information, and related posts.
     * 
     * @param Request $request The HTTP request object
     * @param int $id The post ID from the route
     * @return Response The HTTP response
     */
    public function show(Request $request, $id)
    {
        try {
            // Validate the ID parameter
            if (!is_numeric($id) || $id <= 0) {
                Session::flash('error', 'Invalid post ID provided');
                return $this->redirect('/posts');
            }

            // Find the post with author information
            $post = $this->postModel->findWithAuthor($id);

            if (!$post) {
                Session::flash('error', 'Post not found');
                return $this->redirect('/posts');
            }

            // Increment view count
            $this->postModel->incrementViews($id);

            // Get related posts
            $relatedPosts = $this->postModel->getRelated($id, $post['category'], 3);

            // Prepare data for the view
            $data = [
                'post' => $post,
                'relatedPosts' => $relatedPosts,
                'title' => $post['title']
            ];

            return $this->view('posts/show', $data);

        } catch (Exception $e) {
            Session::flash('error', 'Error retrieving post: ' . $e->getMessage());
            return $this->redirect('/posts');
        }
    }

    /**
     * Show the form for creating a new post
     * 
     * This method demonstrates how to display a form with dynamic content
     * such as category options and rich text editor support.
     * 
     * @param Request $request The HTTP request object
     * @return Response The HTTP response
     */
    public function create(Request $request)
    {
        // Check if user is authenticated (in a real app, this would be middleware)
        if (!Session::has('user_id')) {
            Session::flash('error', 'You must be logged in to create a post');
            return $this->redirect('/login');
        }

        // Get categories for the dropdown
        $categories = $this->postModel->getCategories();

        $data = [
            'categories' => $categories,
            'title' => 'Create New Post',
            'errors' => Session::get('errors', []),
            'old' => Session::get('old', [])
        ];

        // Clear old session data
        Session::forget('errors');
        Session::forget('old');

        return $this->view('posts/create', $data);
    }

    /**
     * Store a newly created post
     * 
     * This method demonstrates complex form validation, file upload handling,
     * and content processing for blog posts.
     * 
     * @param Request $request The HTTP request object
     * @return Response The HTTP response
     */
    public function store(Request $request)
    {
        try {
            // Check authentication
            if (!Session::has('user_id')) {
                Session::flash('error', 'You must be logged in to create a post');
                return $this->redirect('/login');
            }

            // Define validation rules
            $rules = [
                'title' => 'required|min:5|max:200',
                'content' => 'required|min:50',
                'category' => 'required|max:50',
                'excerpt' => 'max:300',
                'featured_image' => 'file|image|max:2048', // 2MB max
                'status' => 'in:draft,published,scheduled',
                'tags' => 'max:500'
            ];

            // Validate the request data
            $validator = new Validator();
            $validation = $validator->validate($request->all(), $rules);

            if (!$validation['isValid']) {
                Session::flash('errors', $validation['errors']);
                Session::flash('old', $request->all());
                return $this->redirect('/posts/create');
            }

            // Handle file upload
            $featuredImage = null;
            if ($request->hasFile('featured_image')) {
                $featuredImage = $this->handleImageUpload($request->file('featured_image'));
                if (!$featuredImage) {
                    Session::flash('error', 'Failed to upload featured image');
                    Session::flash('old', $request->all());
                    return $this->redirect('/posts/create');
                }
            }

            // Generate slug from title
            $slug = $this->generateSlug($request->input('title'));

            // Ensure slug is unique
            $originalSlug = $slug;
            $counter = 1;
            while ($this->postModel->slugExists($slug)) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Prepare post data for storage
            $postData = [
                'title' => trim($request->input('title')),
                'slug' => $slug,
                'content' => $request->input('content'),
                'excerpt' => trim($request->input('excerpt')) ?: $this->generateExcerpt($request->input('content')),
                'category' => trim($request->input('category')),
                'tags' => $this->processTags($request->input('tags', '')),
                'featured_image' => $featuredImage,
                'status' => $request->input('status', 'draft'),
                'author_id' => Session::get('user_id'),
                'views' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Handle scheduled posts
            if ($postData['status'] === 'scheduled') {
                $publishDate = $request->input('publish_date');
                if ($publishDate && strtotime($publishDate) > time()) {
                    $postData['scheduled_at'] = date('Y-m-d H:i:s', strtotime($publishDate));
                } else {
                    $postData['status'] = 'draft';
                }
            }

            // Create the post
            $postId = $this->postModel->create($postData);

            if ($postId) {
                $message = $postData['status'] === 'published' ? 'Post published successfully!' : 'Post saved as draft successfully!';
                Session::flash('success', $message);
                return $this->redirect('/posts/' . $postId);
            } else {
                Session::flash('error', 'Failed to create post');
                return $this->redirect('/posts/create');
            }

        } catch (Exception $e) {
            Session::flash('error', 'Error creating post: ' . $e->getMessage());
            Session::flash('old', $request->all());
            return $this->redirect('/posts/create');
        }
    }

    /**
     * Show the form for editing a post
     * 
     * This method demonstrates how to check ownership and populate
     * forms with existing complex data.
     * 
     * @param Request $request The HTTP request object
     * @param int $id The post ID from the route
     * @return Response The HTTP response
     */
    public function edit(Request $request, $id)
    {
        try {
            // Check authentication
            if (!Session::has('user_id')) {
                Session::flash('error', 'You must be logged in to edit posts');
                return $this->redirect('/login');
            }

            // Validate the ID parameter
            if (!is_numeric($id) || $id <= 0) {
                Session::flash('error', 'Invalid post ID provided');
                return $this->redirect('/posts');
            }

            // Find the post
            $post = $this->postModel->find($id);

            if (!$post) {
                Session::flash('error', 'Post not found');
                return $this->redirect('/posts');
            }

            // Check ownership (in a real app, this might be more complex with roles)
            if ($post['author_id'] !== Session::get('user_id')) {
                Session::flash('error', 'You can only edit your own posts');
                return $this->redirect('/posts');
            }

            // Get categories for the dropdown
            $categories = $this->postModel->getCategories();

            // Prepare data for the view
            $data = [
                'post' => $post,
                'categories' => $categories,
                'title' => 'Edit Post: ' . $post['title'],
                'errors' => Session::get('errors', []),
                'old' => Session::get('old', [])
            ];

            // Clear old session data
            Session::forget('errors');
            Session::forget('old');

            return $this->view('posts/edit', $data);

        } catch (Exception $e) {
            Session::flash('error', 'Error retrieving post: ' . $e->getMessage());
            return $this->redirect('/posts');
        }
    }

    /**
     * Update an existing post
     * 
     * This method demonstrates updating complex records with file handling
     * and maintaining data integrity.
     * 
     * @param Request $request The HTTP request object
     * @param int $id The post ID from the route
     * @return Response The HTTP response
     */
    public function update(Request $request, $id)
    {
        try {
            // Check authentication
            if (!Session::has('user_id')) {
                Session::flash('error', 'You must be logged in to edit posts');
                return $this->redirect('/login');
            }

            // Validate the ID parameter
            if (!is_numeric($id) || $id <= 0) {
                Session::flash('error', 'Invalid post ID provided');
                return $this->redirect('/posts');
            }

            // Check if post exists and user owns it
            $existingPost = $this->postModel->find($id);
            if (!$existingPost) {
                Session::flash('error', 'Post not found');
                return $this->redirect('/posts');
            }

            if ($existingPost['author_id'] !== Session::get('user_id')) {
                Session::flash('error', 'You can only edit your own posts');
                return $this->redirect('/posts');
            }

            // Define validation rules
            $rules = [
                'title' => 'required|min:5|max:200',
                'content' => 'required|min:50',
                'category' => 'required|max:50',
                'excerpt' => 'max:300',
                'featured_image' => 'file|image|max:2048',
                'status' => 'in:draft,published,scheduled',
                'tags' => 'max:500'
            ];

            // Validate the request data
            $validator = new Validator();
            $validation = $validator->validate($request->all(), $rules);

            if (!$validation['isValid']) {
                Session::flash('errors', $validation['errors']);
                Session::flash('old', $request->all());
                return $this->redirect('/posts/' . $id . '/edit');
            }

            // Handle file upload if new image provided
            $featuredImage = $existingPost['featured_image'];
            if ($request->hasFile('featured_image')) {
                $newImage = $this->handleImageUpload($request->file('featured_image'));
                if ($newImage) {
                    // Delete old image if it exists
                    if ($featuredImage && file_exists(PUBLIC_PATH . '/uploads/' . $featuredImage)) {
                        unlink(PUBLIC_PATH . '/uploads/' . $featuredImage);
                    }
                    $featuredImage = $newImage;
                }
            }

            // Generate new slug if title changed
            $slug = $existingPost['slug'];
            if ($request->input('title') !== $existingPost['title']) {
                $newSlug = $this->generateSlug($request->input('title'));
                
                // Ensure slug is unique (excluding current post)
                $originalSlug = $newSlug;
                $counter = 1;
                while ($this->postModel->slugExists($newSlug, $id)) {
                    $newSlug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $slug = $newSlug;
            }

            // Prepare post data for update
            $postData = [
                'title' => trim($request->input('title')),
                'slug' => $slug,
                'content' => $request->input('content'),
                'excerpt' => trim($request->input('excerpt')) ?: $this->generateExcerpt($request->input('content')),
                'category' => trim($request->input('category')),
                'tags' => $this->processTags($request->input('tags', '')),
                'featured_image' => $featuredImage,
                'status' => $request->input('status', 'draft'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Handle scheduled posts
            if ($postData['status'] === 'scheduled') {
                $publishDate = $request->input('publish_date');
                if ($publishDate && strtotime($publishDate) > time()) {
                    $postData['scheduled_at'] = date('Y-m-d H:i:s', strtotime($publishDate));
                } else {
                    $postData['status'] = 'draft';
                    $postData['scheduled_at'] = null;
                }
            } else {
                $postData['scheduled_at'] = null;
            }

            // Update the post
            $updated = $this->postModel->update($id, $postData);

            if ($updated) {
                $message = $postData['status'] === 'published' ? 'Post updated and published!' : 'Post updated successfully!';
                Session::flash('success', $message);
                return $this->redirect('/posts/' . $id);
            } else {
                Session::flash('error', 'Failed to update post');
                return $this->redirect('/posts/' . $id . '/edit');
            }

        } catch (Exception $e) {
            Session::flash('error', 'Error updating post: ' . $e->getMessage());
            Session::flash('old', $request->all());
            return $this->redirect('/posts/' . $id . '/edit');
        }
    }

    /**
     * Delete a post
     * 
     * This method demonstrates safe deletion with file cleanup
     * and proper authorization checks.
     * 
     * @param Request $request The HTTP request object
     * @param int $id The post ID from the route
     * @return Response The HTTP response
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Check authentication
            if (!Session::has('user_id')) {
                Session::flash('error', 'You must be logged in to delete posts');
                return $this->redirect('/login');
            }

            // Validate the ID parameter
            if (!is_numeric($id) || $id <= 0) {
                Session::flash('error', 'Invalid post ID provided');
                return $this->redirect('/posts');
            }

            // Check if post exists and user owns it
            $post = $this->postModel->find($id);
            if (!$post) {
                Session::flash('error', 'Post not found');
                return $this->redirect('/posts');
            }

            if ($post['author_id'] !== Session::get('user_id')) {
                Session::flash('error', 'You can only delete your own posts');
                return $this->redirect('/posts');
            }

            // Delete associated files
            if ($post['featured_image'] && file_exists(PUBLIC_PATH . '/uploads/' . $post['featured_image'])) {
                unlink(PUBLIC_PATH . '/uploads/' . $post['featured_image']);
            }

            // Delete the post
            $deleted = $this->postModel->delete($id);

            if ($deleted) {
                Session::flash('success', 'Post deleted successfully!');
            } else {
                Session::flash('error', 'Failed to delete post');
            }

            return $this->redirect('/posts');

        } catch (Exception $e) {
            Session::flash('error', 'Error deleting post: ' . $e->getMessage());
            return $this->redirect('/posts');
        }
    }

    /**
     * Handle image upload for featured images
     * 
     * This method demonstrates file upload handling with validation
     * and proper file naming conventions.
     * 
     * @param array $file The uploaded file data
     * @return string|null The filename or null on failure
     */
    private function handleImageUpload($file)
    {
        try {
            // Create uploads directory if it doesn't exist
            $uploadDir = PUBLIC_PATH . '/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $destination = $uploadDir . $filename;

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $filename;
            }

            return null;

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Generate URL-friendly slug from title
     * 
     * @param string $title The post title
     * @return string The generated slug
     */
    private function generateSlug($title)
    {
        // Convert to lowercase
        $slug = strtolower($title);
        
        // Replace spaces and special characters with hyphens
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        
        // Remove leading/trailing hyphens
        $slug = trim($slug, '-');
        
        // Limit length
        $slug = substr($slug, 0, 100);
        
        return $slug;
    }

    /**
     * Generate excerpt from content
     * 
     * @param string $content The post content
     * @return string The generated excerpt
     */
    private function generateExcerpt($content)
    {
        // Strip HTML tags
        $text = strip_tags($content);
        
        // Limit to 150 characters
        if (strlen($text) > 150) {
            $text = substr($text, 0, 147) . '...';
        }
        
        return $text;
    }

    /**
     * Process tags string into array
     * 
     * @param string $tags Comma-separated tags
     * @return string JSON encoded tags array
     */
    private function processTags($tags)
    {
        if (empty($tags)) {
            return json_encode([]);
        }

        // Split by comma and clean up
        $tagArray = array_map('trim', explode(',', $tags));
        $tagArray = array_filter($tagArray); // Remove empty values
        $tagArray = array_unique($tagArray); // Remove duplicates
        
        return json_encode(array_values($tagArray));
    }
}
