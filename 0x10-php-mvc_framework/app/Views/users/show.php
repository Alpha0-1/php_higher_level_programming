<?php
/**
 * User Show View
 * 
 * This view displays detailed information about a specific user.
 * It demonstrates how to show individual record details with
 * related data and action buttons.
 * 
 * Variables available in this view:
 * - $user: User data array/object
 * - $posts: Array of posts by this user (optional)
 * - $error: Error message if user not found
 * 
 * @package MVC_Framework
 * @subpackage Views
 */

// Check if user exists
if (!isset($user) || empty($user)) {
    $error = $error ?? 'User not found';
}

$posts = $posts ?? [];
?>

<div class="container">
    <?php if (isset($error)): ?>
        <!-- Error State -->
        <div class="error-state">
            <h1>User Not Found</h1>
            <p><?= htmlspecialchars($error) ?></p>
            <a href="/users" class="btn btn-primary">Back to Users</a>
        </div>
    <?php else: ?>
        <!-- User Profile -->
        <div class="profile-header">
            <div class="profile-actions">
                <a href="/users" class="btn btn-secondary">
                    <i class="icon-back"></i> Back to Users
                </a>
                <a href="/users/<?= $user['id'] ?>/edit" class="btn btn-warning">
                    <i class="icon-edit"></i> Edit User
                </a>
                <button onclick="deleteUser(<?= $user['id'] ?>)" class="btn btn-danger">
                    <i class="icon-trash"></i> Delete User
                </button>
            </div>
        </div>

        <div class="profile-content">
            <!-- User Information Card -->
            <div class="user-card">
                <div class="user-avatar">
                    <?php if (!empty($user['avatar'])): ?>
                        <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="User Avatar">
                    <?php else: ?>
                        <div class="avatar-placeholder">
                            <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="user-info">
                    <h1><?= htmlspecialchars($user['name'] ?? 'Unknown User') ?></h1>
                    <?php if (!empty($user['username'])): ?>
                        <p class="username">@<?= htmlspecialchars($user['username']) ?></p>
                    <?php endif; ?>
                    
                    <div class="user-status">
                        <span class="status-badge <?= ($user['active'] ?? true) ? 'status-active' : 'status-inactive' ?>">
                            <?= ($user['active'] ?? true) ? 'Active' : 'Inactive' ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- User Details Grid -->
            <div class="details-grid">
                <div class="detail-section">
                    <h3>Contact Information</h3>
                    <div class="detail-item">
                        <label>Email:</label>
                        <span><?= htmlspecialchars($user['email'] ?? 'Not provided') ?></span>
                    </div>
                    <?php if (!empty($user['phone'])): ?>
                        <div class="detail-item">
                            <label>Phone:</label>
                            <span><?= htmlspecialchars($user['phone']) ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($user['website'])): ?>
                        <div class="detail-item">
                            <label>Website:</label>
                            <span><a href="<?= htmlspecialchars($user['website']) ?>" target="_blank"><?= htmlspecialchars($user['website']) ?></a></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="detail-section">
                    <h3>Profile Information</h3>
                    <?php if (!empty($user['bio'])): ?>
                        <div class="detail-item">
                            <label>Bio:</label>
                            <span><?= nl2br(htmlspecialchars($user['bio'])) ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($user['location'])): ?>
                        <div class="detail-item">
                            <label>Location:</label>
                            <span><?= htmlspecialchars($user['location']) ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($user['company'])): ?>
                        <div class="detail-item">
                            <label>Company:</label>
                            <span><?= htmlspecialchars($user['company']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="detail-section">
                    <h3>Account Information</h3>
                    <div class="detail-item">
                        <label>User ID:</label>
                        <span><?= htmlspecialchars($user['id']) ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Created:</label>
                        <span>
                            <?php 
                            if (!empty($user['created_at'])) {
                                echo date('F j, Y \a\t g:i A', strtotime($user['created_at']));
                            } else {
                                echo 'Not available';
                            }
                            ?>
                        </span>
                    </div>
                    <div class="detail-item">
                        <label>Last Updated:</label>
                        <span>
                            <?php 
                            if (!empty($user['updated_at'])) {
                                echo date('F j, Y \a\t g:i A', strtotime($user['updated_at']));
                            } else {
                                echo 'Not available';
                            }
                            ?>
                        </span>
                    </div>
                    <?php if (!empty($user['last_login'])): ?>
                        <div class="detail-item">
                            <label>Last Login:</label>
                            <span><?= date('F j, Y \a\t g:i A', strtotime($user['last_login'])) ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="detail-section">
                    <h3>Statistics</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value"><?= count($posts) ?></div>
                            <div class="stat-label">Posts</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?= $user['followers_count'] ?? 0 ?></div>
                            <div class="stat-label">Followers</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?= $user['following_count'] ?? 0 ?></div>
                            <div class="stat-label">Following</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Posts Section -->
            <?php if (!empty($posts)): ?>
                <div class="posts-section">
                    <h3>Recent Posts</h3>
                    <div class="posts-grid">
                        <?php foreach (array_slice($posts, 0, 6) as $post): ?>
                            <div class="post-card">
                                <h4><?= htmlspecialchars($post['title'] ?? 'Untitled Post') ?></h4>
                                <p><?= htmlspecialchars(substr($post['content'] ?? '', 0, 100)) ?><?= strlen($post['content'] ?? '') > 100 ? '...' : '' ?></p>
                                <div class="post-meta">
                                    <span class="post-date">
                                        <?= date('M j, Y', strtotime($post['created_at'] ?? 'now')) ?>
                                    </span>
                                    <a href="/posts/<?= $post['id'] ?? 0 ?>" class="btn btn-sm btn-primary">View</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if (count($posts) > 6): ?>
                        <div class="text-center">
                            <a href="/users/<?= $user['id'] ?>/posts" class="btn btn-secondary">View All Posts</a>
                        </div>
