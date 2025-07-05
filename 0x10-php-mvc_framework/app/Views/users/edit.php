<?php
/**
 * User Edit Form View
 * 
 * This view provides a form for editing existing users in the system.
 * It demonstrates form pre-population, validation display, and secure updates
 * in an MVC architecture. The form is pre-filled with existing user data.
 * 
 * @author Software Engineering Student
 * @version 1.0
 */

// Set page title for the layout
$pageTitle = 'Edit User - ' . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);

// Include any necessary CSS or JS files
$additionalCSS = [
    '/css/forms.css',
    '/css/users.css'
];

$additionalJS = [
    '/js/form-validation.js'
];

// Ensure we have user data
if (!isset($user) || empty($user)) {
    header('Location: /users');
    exit;
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Edit User</h3>
                    <small class="text-muted">ID: <?php echo htmlspecialchars($user['id']); ?></small>
                </div>
                <div class="card-body">
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger">
                            <h5>Please fix the following errors:</h5>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($success) && $success): ?>
                        <div class="alert alert-success">
                            User updated successfully!
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/users/update/<?php echo htmlspecialchars($user['id']); ?>" enctype="multipart/form-data" novalidate>
                        <!-- CSRF Token for security -->
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                        
                        <!-- HTTP Method Override for PUT request -->
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group mb-3">
                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control <?php echo isset($errors['first_name']) ? 'is-invalid' : ''; ?>" 
                                id="first_name" 
                                name="first_name" 
                                value="<?php echo htmlspecialchars($old['first_name'] ?? $user['first_name']); ?>"
                                required
                                maxlength="50"
                                placeholder="Enter first name"
                            >
                            <?php if (isset($errors['first_name'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo htmlspecialchars($errors['first_name']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control <?php echo isset($errors['last_name']) ? 'is-invalid' : ''; ?>" 
                                id="last_name" 
                                name="last_name" 
                                value="<?php echo htmlspecialchars($old['last_name'] ?? $user['last_name']); ?>"
                                required
                                maxlength="50"
                                placeholder="Enter last name"
                            >
                            <?php if (isset($errors['last_name'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo htmlspecialchars($errors['last_name']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input 
                                type="email" 
                                class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                                id="email" 
                                name="email" 
                                value="<?php echo htmlspecialchars($old['email'] ?? $user['email']); ?>"
                                required
                                maxlength="100"
                                placeholder="Enter email address"
                            >
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo htmlspecialchars($errors['email']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input 
                                type="password" 
                                class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" 
                                id="password" 
                                name="password" 
                                minlength="6"
                                placeholder="Leave blank to keep current password"
                            >
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo htmlspecialchars($errors['password']); ?>
                                </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">Leave blank to keep current password</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input 
                                type="password" 
                                class="form-control <?php echo isset($errors['password_confirmation']) ? 'is-invalid' : ''; ?>" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                minlength="6"
                                placeholder="Confirm new password"
                            >
                            <?php if (isset($errors['password_confirmation'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo htmlspecialchars($errors['password_confirmation']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select 
                                class="form-select <?php echo isset($errors['role']) ? 'is-invalid' : ''; ?>" 
                                id="role" 
                                name="role" 
                                required
                            >
                                <option value="">Select a role</option>
                                <?php 
                                $currentRole = $old['role'] ?? $user['role'];
                                $roles = ['user', 'admin', 'moderator'];
                                ?>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo htmlspecialchars($role); ?>" <?php echo ($currentRole === $role) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars(ucfirst($role)); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['role'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo htmlspecialchars($errors['role']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea 
                                class="form-control <?php echo isset($errors['bio']) ? 'is-invalid' : ''; ?>" 
                                id="bio" 
                                name="bio" 
                                rows="4"
                                maxlength="500"
                                placeholder="Tell us about yourself (optional)"
                            ><?php echo htmlspecialchars($old['bio'] ?? $user['bio'] ?? ''); ?></textarea>
                            <?php if (isset($errors['bio'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo htmlspecialchars($errors['bio']); ?>
                                </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">Maximum 500 characters</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Account Status</label>
                            <select 
                                class="form-select <?php echo isset($errors['status']) ? 'is-invalid' : ''; ?>" 
                                id="status" 
                                name="status"
                            >
                                <?php 
                                $currentStatus = $old['status'] ?? $user['status'] ?? 'active';
                                $statuses = ['active', 'inactive', 'suspended'];
                                ?>
                                <?php foreach ($statuses as $status): ?>
                                    <option value="<?php echo htmlspecialchars($status); ?>" <?php echo ($currentStatus === $status) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars(ucfirst($status)); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['status'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo htmlspecialchars($errors['status']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- User metadata display -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Created At</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        value="<?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($user['created_at']))); ?>" 
                                        readonly
                                    >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Last Updated</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        value="<?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($user['updated_at']))); ?>" 
                                        readonly
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <div>
                                <a href="/users" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Users
                                </a>
                                <a href="/users/show/<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-info">
                                    <i class="fas fa-eye"></i> View User
                                </a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo htmlspecialchars($user['id']); ?>)">
                                    <i class="fas fa-trash"></i> Delete User
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Client-side form validation and functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    
    // Real-time password confirmation validation
    function validatePasswordConfirmation() {
        if (password.value && passwordConfirmation.value && password.value !== passwordConfirmation.value) {
            passwordConfirmation.setCustomValidity('Passwords do not match');
        } else {
            passwordConfirmation.setCustomValidity('');
        }
    }
    
    password.addEventListener('input', validatePasswordConfirmation);
    passwordConfirmation.addEventListener('input', validatePasswordConfirmation);
    
    // Form submission handling
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});

// Delete confirmation function
function confirmDelete(userId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/users/delete/${userId}`;
    
    // Show modal using Bootstrap
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
