<?php
/**
 * Home Index View
 * 
 * This is the main homepage view that displays a welcome message and 
 * demonstrates basic view rendering in our MVC framework.
 * 
 * Variables available in this view:
 * - $title: Page title passed from controller
 * - $message: Welcome message from controller
 * - $users: Array of users for demonstration
 * 
 * @package MVC_Framework
 * @subpackage Views
 */

// Ensure variables are set with default values
$title = $title ?? 'Welcome to MVC Framework';
$message = $message ?? 'Hello, World!';
$users = $users ?? [];
?>

<div class="container">
    <div class="hero-section">
        <h1 class="hero-title"><?= htmlspecialchars($title) ?></h1>
        <p class="hero-message"><?= htmlspecialchars($message) ?></p>
    </div>

    <div class="features-section">
        <h2>Framework Features</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>MVC Architecture</h3>
                <p>Clean separation of concerns with Model-View-Controller pattern</p>
            </div>
            <div class="feature-card">
                <h3>Routing System</h3>
                <p>Flexible URL routing with parameter support</p>
            </div>
            <div class="feature-card">
                <h3>Database Integration</h3>
                <p>PDO-based database abstraction layer</p>
            </div>
            <div class="feature-card">
                <h3>Security Features</h3>
                <p>Built-in validation and CSRF protection</p>
            </div>
        </div>
    </div>

    <?php if (!empty($users)): ?>
    <div class="users-preview">
        <h2>Recent Users</h2>
        <div class="users-list">
            <?php foreach (array_slice($users, 0, 3) as $user): ?>
            <div class="user-card">
                <h4><?= htmlspecialchars($user['name'] ?? 'Unknown User') ?></h4>
                <p><?= htmlspecialchars($user['email'] ?? 'No email') ?></p>
                <a href="/users/<?= $user['id'] ?? 0 ?>" class="btn btn-primary">View Profile</a>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center">
            <a href="/users" class="btn btn-secondary">View All Users</a>
        </div>
    </div>
    <?php endif; ?>

    <div class="getting-started">
        <h2>Getting Started</h2>
        <p>This MVC framework provides a solid foundation for building web applications. Here's how to get started:</p>
        <ol>
            <li><strong>Controllers:</strong> Handle HTTP requests and business logic</li>
            <li><strong>Models:</strong> Manage data and database interactions</li>
            <li><strong>Views:</strong> Present data to users with HTML templates</li>
            <li><strong>Routes:</strong> Map URLs to controller actions</li>
        </ol>
        
        <div class="code-example">
            <h3>Example Route</h3>
            <pre><code>// In config/routes.php
$router->get('/', 'HomeController@index');
$router->get('/users', 'UserController@index');</code></pre>
        </div>
    </div>
</div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.hero-section {
    text-align: center;
    margin-bottom: 50px;
    padding: 40px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
}

.hero-title {
    font-size: 3em;
    margin-bottom: 20px;
    font-weight: bold;
}

.hero-message {
    font-size: 1.2em;
    opacity: 0.9;
}

.features-section {
    margin-bottom: 50px;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.feature-card {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    transition: transform 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
}

.users-preview {
    margin-bottom: 50px;
}

.users-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin: 30px 0;
}

.user-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn:hover {
    opacity: 0.8;
}

.getting-started {
    background: #f8f9fa;
    padding: 40px;
    border-radius: 10px;
}

.code-example {
    background: #2d3748;
    color: #e2e8f0;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
}

.code-example pre {
    margin: 0;
    font-family: 'Courier New', monospace;
}

.text-center {
    text-align: center;
}

h1, h2, h3 {
    color: #2d3748;
}

ol {
    padding-left: 20px;
}

li {
    margin-bottom: 10px;
}
</style>
