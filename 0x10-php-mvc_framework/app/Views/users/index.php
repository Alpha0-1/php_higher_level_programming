<?php
/**
 * Users Index View
 * 
 * This view displays a list of all users with pagination, search functionality,
 * and CRUD action buttons. It demonstrates how to display tabular data in 
 * a user-friendly format.
 * 
 * Variables available in this view:
 * - $users: Array of user objects/arrays
 * - $pagination: Pagination data (current_page, total_pages, etc.)
 * - $search: Current search query
 * - $total_users: Total number of users
 * 
 * @package MVC_Framework
 * @subpackage Views
 */

// Set default values for variables
$users = $users ?? [];
$pagination = $pagination ?? ['current_page' => 1, 'total_pages' => 1, 'per_page' => 10];
$search = $search ?? '';
$total_users = $total_users ?? count($users);
?>

<div class="container">
    <div class="page-header">
        <h1>Users Management</h1>
        <p class="lead">Manage all users in your application</p>
    </div>

    <!-- Search and Filter Section -->
    <div class="search-section">
        <form method="GET" action="/users" class="search-form">
            <div class="search-group">
                <input 
                    type="text" 
                    name="search" 
                    value="<?= htmlspecialchars($search) ?>" 
                    placeholder="Search users by name or email..."
                    class="search-input"
                >
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if (!empty($search)): ?>
                    <a href="/users" class="btn btn-secondary">Clear</a>
                <?php endif; ?>
            </div>
        </form>
        
        <div class="actions">
            <a href="/users/create" class="btn btn-success">
                <i class="icon-plus"></i> Add New User
            </a>
        </div>
    </div>

    <!-- Results Summary -->
    <div class="results-summary">
        <p>
            Showing <?= count($users) ?> of <?= $total_users ?> users
            <?php if (!empty($search)): ?>
                for "<strong><?= htmlspecialchars($search) ?></strong>"
            <?php endif; ?>
        </p>
    </div>

    <!-- Users Table -->
    <?php if (!empty($users)): ?>
    <div class="table-responsive">
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id'] ?? 'N/A') ?></td>
                    <td>
                        <div class="user-info">
                            <strong><?= htmlspecialchars($user['name'] ?? 'Unknown') ?></strong>
                            <?php if (!empty($user['username'])): ?>
                                <br><small class="text-muted">@<?= htmlspecialchars($user['username']) ?></small>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td><?= htmlspecialchars($user['email'] ?? 'No email') ?></td>
                    <td>
                        <?php 
                        $created_at = $user['created_at'] ?? null;
                        if ($created_at) {
                            echo date('M j, Y', strtotime($created_at));
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </td>
                    <td>
                        <span class="status-badge <?= ($user['active'] ?? true) ? 'status-active' : 'status-inactive' ?>">
                            <?= ($user['active'] ?? true) ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="/users/<?= $user['id'] ?? 0 ?>" class="btn btn-sm btn-info" title="View User">
                                <i class="icon-eye"></i>
                            </a>
                            <a href="/users/<?= $user['id'] ?? 0 ?>/edit" class="btn btn-sm btn-warning" title="Edit User">
                                <i class="icon-edit"></i>
                            </a>
                            <button 
                                onclick="deleteUser(<?= $user['id'] ?? 0 ?>)" 
                                class="btn btn-sm btn-danger" 
                                title="Delete User"
                            >
                                <i class="icon-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($pagination['total_pages'] > 1): ?>
    <div class="pagination-wrapper">
        <nav class="pagination">
            <?php if ($pagination['current_page'] > 1): ?>
                <a href="/users?page=<?= $pagination['current_page'] - 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>" class="btn btn-pagination">
                    &laquo; Previous
                </a>
            <?php endif; ?>

            <?php 
            $start = max(1, $pagination['current_page'] - 2);
            $end = min($pagination['total_pages'], $pagination['current_page'] + 2);
            
            for ($i = $start; $i <= $end; $i++): 
            ?>
                <a 
                    href="/users?page=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>" 
                    class="btn btn-pagination <?= $i == $pagination['current_page'] ? 'active' : '' ?>"
                >
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                <a href="/users?page=<?= $pagination['current_page'] + 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>" class="btn btn-pagination">
                    Next &raquo;
                </a>
            <?php endif; ?>
        </nav>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <!-- Empty State -->
    <div class="empty-state">
        <h3>No Users Found</h3>
        <?php if (!empty($search)): ?>
            <p>No users match your search criteria.</p>
            <a href="/users" class="btn btn-primary">View All Users</a>
        <?php else: ?>
            <p>There are no users in the system yet.</p>
            <a href="/users/create" class="btn btn-success">Add First User</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Confirm Delete</h3>
        <p>Are you sure you want to delete this user? This action cannot be undone.</p>
        <div class="modal-actions">
            <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
            <button onclick="confirmDelete()" class="btn btn-danger">Delete</button>
        </div>
    </div>
</div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.page-header {
    margin-bottom: 30px;
}

.page-header h1 {
    color: #2d3748;
    margin-bottom: 10px;
}

.lead {
    color: #4a5568;
    font-size: 1.1em;
}

.search-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 15px;
}

.search-form {
    flex: 1;
    max-width: 500px;
}

.search-group {
    display: flex;
    gap: 10px;
}

.search-input {
    flex: 1;
    padding: 10px;
    border: 1px solid #d1d5db;
    border-radius: 5px;
    font-size: 14px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
}

.btn-primary { background: #3b82f6; color: white; }
.btn-secondary { background: #6b7280; color: white; }
.btn-success { background: #10b981; color: white; }
.btn-info { background: #06b6d4; color: white; }
.btn-warning { background: #f59e0b; color: white; }
.btn-danger { background: #ef4444; color: white; }

.btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.btn-sm {
    padding: 5px 10px;
    font-size: 12px;
}

.results-summary {
    margin-bottom: 20px;
    color: #6b7280;
}

.table-responsive {
    overflow-x: auto;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
}

.users-table th,
.users-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.users-table th {
    background: #f9fafb;
    font-weight: 600;
    color: #374151;
}

.users-table tr:hover {
    background: #f9fafb;
}

.user-info strong {
    color: #1f2937;
}

.text-muted {
    color: #6b7280;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.status-active {
    background: #dcfce7;
    color: #166534;
}

.status-inactive {
    background: #fee2e2;
    color: #991b1b;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.pagination-wrapper {
    margin-top: 30px;
    text-align: center;
}

.pagination {
    display: inline-flex;
    gap: 5px;
}

.btn-pagination {
    padding: 8px 12px;
    background: white;
    border: 1px solid #d1d5db;
    color: #374151;
}

.btn-pagination:hover {
    background: #f3f4f6;
}

.btn-pagination.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #f9fafb;
    border-radius: 8px;
}

.empty-state h3 {
    color: #374151;
    margin-bottom: 10px;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 20px;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
}

.modal-content {
    background: white;
    margin: 15% auto;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 400px;
}

.modal-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    margin-top: 20px;
}

/* Icons (using Unicode symbols for simplicity) */
.icon-plus::before { content: "➕"; }
.icon-eye::before { content: "👁"; }
.icon-edit::before { content: "✏️"; }
.icon-trash::before { content: "🗑"; }
</style>

<script>
let userToDelete = null;

function deleteUser(userId) {
    userToDelete = userId;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('deleteModal').style.display = 'none';
    userToDelete = null;
}

function confirmDelete() {
    if (userToDelete) {
        // Send DELETE request to server
        fetch(`/users/${userToDelete}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting user: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting user. Please try again.');
        });
    }
    closeModal();
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        closeModal();
    }
}
</script>
