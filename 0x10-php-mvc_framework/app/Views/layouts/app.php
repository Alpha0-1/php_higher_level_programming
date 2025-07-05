<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $metaDescription ?? 'A modern PHP MVC framework application'; ?>">
    <meta name="keywords" content="<?php echo $metaKeywords ?? 'php, mvc, framework, web development'; ?>">
    <meta name="author" content="<?php echo $metaAuthor ?? 'Your Name'; ?>">
    
    <title><?php echo $title ?? 'PHP MVC Framework'; ?></title>
    
    <!-- CSS Framework - Bootstrap for responsive design -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="/css/app.css" rel="stylesheet">
    
    <!-- Additional CSS files can be added here -->
    <?php if (isset($additionalCss)): ?>
        <?php foreach ($additionalCss as $css): ?>
            <link href="<?php echo $css; ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Brand/Logo -->
            <a class="navbar-brand" href="/">
                <i class="fas fa-code"></i>
                <?php echo $appName ?? 'PHP MVC'; ?>
            </a>
            
            <!-- Mobile menu toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'home' ? 'active' : ''; ?>" href="/">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'posts' ? 'active' : ''; ?>" href="/posts">
                            <i class="fas fa-newspaper"></i> Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'users' ? 'active' : ''; ?>" href="/users">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'about' ? 'active' : ''; ?>" href="/about">
                            <i class="fas fa-info-circle"></i> About
                        </a>
                    </li>
                </ul>
                
                <!-- User Authentication Links -->
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Logged in user menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i>
                                <?php echo $_SESSION['user_name'] ?? 'User'; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/profile">
                                    <i class="fas fa-user-edit"></i> Profile
                                </a></li>
                                <li><a class="dropdown-item" href="/posts/create">
                                    <i class="fas fa-plus"></i> New Post
                                </a></li>
                                <li><a class="dropdown-item" href="/my-posts">
                                    <i class="fas fa-file-alt"></i> My Posts
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Guest user links -->
                        <li class="nav-item">
                            <a class="nav-link" href="/login">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['flash_messages'])): ?>
        <div class="container mt-3">
            <?php foreach ($_SESSION['flash_messages'] as $type => $messages): ?>
                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-<?php echo $type === 'error' ? 'danger' : $type; ?> alert-dismissible fade show" role="alert">
                        <?php if ($type === 'success'): ?>
                            <i class="fas fa-check-circle"></i>
                        <?php elseif ($type === 'error'): ?>
                            <i class="fas fa-exclamation-triangle"></i>
                        <?php elseif ($type === 'warning'): ?>
                            <i class="fas fa-exclamation-circle"></i>
                        <?php else: ?>
                            <i class="fas fa-info-circle"></i>
                        <?php endif; ?>
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['flash_messages']); ?>
    <?php endif; ?>

    <!-- Breadcrumb Navigation -->
    <?php if (isset($breadcrumbs) && !empty($breadcrumbs)): ?>
        <div class="container mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
                        <?php if ($index === count($breadcrumbs) - 1): ?>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php echo htmlspecialchars($breadcrumb['title']); ?>
                            </li>
                        <?php else: ?>
                            <li class="breadcrumb-item">
                                <a href="<?php echo $breadcrumb['url']; ?>">
                                    <?php echo htmlspecialchars($breadcrumb['title']); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
        </div>
    <?php endif; ?>

    <!-- Main Content Area -->
    <main class="container my-4">
        <?php if (isset($showPageHeader) && $showPageHeader !== false): ?>
            <div class="row">
                <div class="col-12">
                    <div class="page-header mb-4">
                        <h1 class="page-title">
                            <?php if (isset($pageIcon)): ?>
                                <i class="<?php echo $pageIcon; ?>"></i>
                            <?php endif; ?>
                            <?php echo $title ?? 'Page Title'; ?>
                        </h1>
                        <?php if (isset($pageDescription)): ?>
                            <p class="page-description text-muted">
                                <?php echo htmlspecialchars($pageDescription); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Content from individual views will be inserted here -->
        <?php include $viewFile; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <h5>
                        <i class="fas fa-code"></i>
                        <?php echo $appName ?? 'PHP MVC Framework'; ?>
                    </h5>
                    <p class="text-muted">
                        A modern, educational PHP MVC framework demonstrating best practices
                        in web development, clean architecture, and secure coding.
                    </p>
                </div>
                <div class="col-md-3">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-white-50">Home</a></li>
                        <li><a href="/posts" class="text-white-50">Posts</a></li>
                        <li><a href="/users" class="text-white-50">Users</a></li>
                        <li><a href="/about" class="text-white-50">About</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Resources</h6>
                    <ul class="list-unstyled">
                        <li><a href="/docs" class="text-white-50">Documentation</a></li>
                        <li><a href="/api" class="text-white-50">API</a></li>
                        <li><a href="/contact" class="text-white-50">Contact</a></li>
                        <li><a href="/privacy" class="text-white-50">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">
                        &copy; <?php echo date('Y'); ?> <?php echo $appName ?? 'PHP MVC Framework'; ?>. 
                        All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">
                        Built with <i class="fas fa-heart text-danger"></i> using PHP MVC
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Loading Spinner (hidden by default) -->
    <div id="loading-spinner" class="d-none">
        <div class="spinner-overlay">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (if needed) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script src="/js/app.js"></script>
    
    <!-- Additional JavaScript files can be added here -->
    <?php if (isset($additionalJs)): ?>
        <?php foreach ($additionalJs as $js): ?>
            <script src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Inline JavaScript for dynamic functionality -->
    <script>
        // Global JavaScript functions and event handlers
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide flash messages after 5 seconds
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Confirm deletion dialogs
            document.querySelectorAll('.delete-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            });

            // Show loading spinner for form submissions
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function() {
                    var spinner = document.getElementById('loading-spinner');
                    if (spinner) {
                        spinner.classList.remove('d-none');
                    }
                });
            });

            // Back to top button functionality
            var backToTopBtn = document.getElementById('back-to-top');
            if (backToTopBtn) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 300) {
                        backToTopBtn.style.display = 'block';
                    } else {
                        backToTopBtn.style.display = 'none';
                    }
                });

                backToTopBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
        });

        // Global AJAX error handler
        window.addEventListener('unhandledrejection', function(event) {
            console.error('Unhandled promise rejection:', event.reason);
        });

        // Utility functions
        function showNotification(message, type = 'info') {
            var alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-' + type + ' alert-dismissible fade show';
            alertDiv.innerHTML = '<i class="fas fa-info-circle"></i> ' + message + 
                                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            
            var container = document.querySelector('.container');
            if (container) {
                container.insertBefore(alertDiv, container.firstChild);
                
                // Auto-hide after 3 seconds
                setTimeout(function() {
                    var bsAlert = new bootstrap.Alert(alertDiv);
                    bsAlert.close();
                }, 3000);
            }
        }

        function formatDate(dateString) {
            var date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    </script>

    <!-- Back to Top Button -->
    <a href="#" id="back-to-top" class="btn btn-primary btn-sm position-fixed bottom-0 end-0 m-3" style="display: none;">
        <i class="fas fa-arrow-up"></i>
    </a>
</body>
</html>
