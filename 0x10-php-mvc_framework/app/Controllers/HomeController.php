<?php
/**
 * HomeController
 * Handles home page requests and general site pages
 */
class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        // Get recent posts for home page
        $postModel = new Post();
        $recentPosts = $postModel->getPublished();
        
        // Limit to 6 most recent posts
        $recentPosts = array_slice($recentPosts, 0, 6);
        
        // Get user statistics
        $userModel = new User();
        $totalUsers = count($userModel->all());
        $totalPosts = count($postModel->all());
        
        $data = [
            'title' => 'Welcome to PHP MVC Framework',
            'recent_posts' => $recentPosts,
            'total_users' => $totalUsers,
            'total_posts' => $totalPosts
        ];
        
        $this->view('home/index', $data);
    }
    
    /**
     * Display the about page
     */
    public function about()
    {
        $data = [
            'title' => 'About Us',
            'content' => 'This is a sample PHP MVC framework built for educational purposes. 
                         It demonstrates the Model-View-Controller pattern and includes 
                         features like routing, database management, and user authentication.'
        ];
        
        $this->view('home/about', $data);
    }
    
    /**
     * Display the contact page
     */
    public function contact()
    {
        $data = [
            'title' => 'Contact Us',
            'email' => 'info@phpmvc.com',
            'phone' => '+1 (555) 123-4567',
            'address' => '123 Framework Street, PHP City, PC 12345'
        ];
        
        $this->view('home/contact', $data);
    }
}
