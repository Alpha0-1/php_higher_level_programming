<?php
/**
 * User Creation Form View
 * 
 * This view provides a form for creating new users in the system.
 * It demonstrates form handling, validation display, and CSRF protection
 * in an MVC architecture.
 * 
 * @author Software Engineering Student
 * @version 1.0
 */

// Set page title for the layout
$pageTitle = 'Create New User';

// Include any necessary CSS or JS files
$additionalCSS = [
    '/css/forms.css',
    '/css/users.css'
];

$additionalJS = [
    '/js/form-validation.js'
];
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New User</h3>
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
                            User created successfully!
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/users/store" enctype="multipart/form-data" novalidate>
                        <!-- CSRF Token for security -->
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">

                        <div class="form-group mb-3">
                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control <?php echo isset($errors['first_name']) ? 'is-invalid' : ''; ?>" 
                                id="first_name" 
                                name="first_name" 
                                value="<?php echo htmlspecialchars($old['first_name'] ?? ''); ?>"
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
                                value="<?php echo htmlspecialchars($old['last_name'] ?? ''); ?>"
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
                                value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
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
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input 
                                type="password" 
                                class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" 
                                id="password" 
                                name="password" 
                                required
                                minlength="6"
                                placeholder="Enter password (min 6 characters)"
                            >
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo htmlspecialchars($errors['password']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input 
                                type="password" 
                                class="form-control <?php echo isset($errors['password_confirmation']) ? 'is-invalid' : ''; ?>" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required
                                minlength="6"
                                placeholder="Confirm your password"
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
                                <option value="user" <?php echo (isset($old['role']) && $old['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                                <option value="admin" <?php echo (isset($old['role']) && $old['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="moderator" <?php echo (isset($old['role']) && $old['role'] === 'moderator') ? 'selected' : ''; ?>>Moderator</option>
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
                            ><?php echo htmlspecialchars($old['bio'] ?? ''); ?></textarea>
                            <?php if (isset($errors['bio'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo htmlspecialchars($errors['bio']); ?>
                                </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">Maximum 500 characters</small>
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input 
                                    class="form-check-input <?php echo isset($errors['terms']) ? 'is-invalid' : ''; ?>" 
                                    type="checkbox" 
                                    id="terms" 
                                    name="terms" 
                                    value="1"
                                    <?php echo (isset($old['terms']) && $old['terms']) ? 'checked' : ''; ?>
                                    required
                                >
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="/terms" target="_blank">Terms of Service</a> and <a href="/privacy" target="_blank">Privacy Policy</a> <span class="text-danger">*</span>
                                </label>
                                <?php if (isset($errors['terms'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo htmlspecialchars($errors['terms']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <a href="/users" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Users
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Client-side form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    
    // Real-time password confirmation validation
    passwordConfirmation.addEventListener('input', function() {
        if (password.value !== passwordConfirmation.value) {
            passwordConfirmation.setCustomValidity('Passwords do not match');
        } else {
            passwordConfirmation.setCustomValidity('');
        }
    });
    
    // Form submission handling
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>
