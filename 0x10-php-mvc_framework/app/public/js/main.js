App.showFieldError = function(field, message) {
    field.classList.add('error');
    let errorElement = field.parentNode.querySelector('.error-message');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        field.parentNode.appendChild(errorElement);
    }
    errorElement.textContent = message;
    return false;
};

App.clearFieldError = function(field) {
    field.classList.remove('error');
    const errorElement = field.parentNode.querySelector('.error-message');
    if (errorElement) {
        errorElement.textContent = '';
    }
    return true;
};

/**
 * Email validation helper
 */
App.isValidEmail = function(email) {
    // Simple email regex pattern
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
};

/**
 * Loading State Management
 */
App.showLoading = function(element) {
    // Add loading class to form
    element.classList.add('loading');
    
    // Disable submit button(s)
    const submitButtons = element.querySelectorAll('button[type="submit"], input[type="submit"]');
    submitButtons.forEach(button => {
        button.disabled = true;
        // Store original text in case we need to restore it
        if (!button.dataset.originalText) {
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = 'Please wait...';
        }
    });
};

App.hideLoading = function(element) {
    // Remove loading class
    element.classList.remove('loading');
    
    // Re-enable submit button(s)
    const submitButtons = element.querySelectorAll('button[type="submit"], input[type="submit"]');
    submitButtons.forEach(button => {
        button.disabled = false;
        // Restore original text
        if (button.dataset.originalText) {
            button.innerHTML = button.dataset.originalText;
        }
    });
};

/**
 * Notification Functions
 */
App.handleAjaxResponse = function(data, form) {
    if (data.success) {
        this.showSuccess(data.message || 'Operation completed successfully');
        
        // Trigger custom event for success
        const successEvent = new CustomEvent('formSuccess', { 
            detail: { 
                data: data,
                form: form
            }
        });
        document.dispatchEvent(successEvent);
        
        // Reset form if requested
        if (form.classList.contains('reset-on-success')) {
            form.reset();
        }
        
        // Close modal if inside one
        const modal = form.closest('.modal');
        if (modal && data.close_modal) {
            this.closeModal(modal);
        }
        
        // Redirect if URL provided
        if (data.redirect) {
            window.location.href = data.redirect;
        }
    } else {
        this.showError(data.message || 'An error occurred');
        
        // Display form errors
        if (data.errors && typeof data.errors === 'object') {
            Object.entries(data.errors).forEach(([field, error]) => {
                const input = form.querySelector(`[name="${field}"]`);
                if (input) {
                    this.showFieldError(input, error);
                }
            });
        }
    }
};

App.showSuccess = function(message) {
    this.showNotification(message, 'success');
};

App.showError = function(message) {
    this.showNotification(message, 'error');
};

App.showNotification = function(message, type) {
    // Remove existing notifications
    this.removeNotifications();
    
    // Create notification container
    const container = document.createElement('div');
    container.className = `notification ${type}-notification`;
    container.innerHTML = `
        <div class="notification-content">${message}</div>
        <button class="notification-close">&times;</button>
    `;
    
    // Add to DOM
    document.body.appendChild(container);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        this.removeNotifications();
    }, 5000);
    
    // Close on click
    container.querySelector('.notification-close').addEventListener('click', () => {
        this.removeNotifications();
    });
};

App.removeNotifications = function() {
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach(notification => {
        notification.remove();
    });
};

/**
 * Flash Messages Handling
 */
App.handleFlashMessages = function() {
    const flashMessages = document.querySelectorAll('.flash-message');
    flashMessages.forEach(message => {
        // Show message
        message.style.display = 'block';
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => {
                message.style.display = 'none';
            }, 300);
        }, 5000);
        
        // Close on click
        const closeBtn = message.querySelector('.flash-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                message.style.display = 'none';
            });
        }
    });
};

/**
 * Table Enhancements
 */
App.initializeTables = function() {
    const tables = document.querySelectorAll('table.data-table');
    tables.forEach(table => {
        // Add sorting functionality to headers
        const headers = table.querySelectorAll('thead th');
        headers.forEach(header => {
            if (!header.hasAttribute('data-sort')) return;
            
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => {
                this.sortTable(table, header.cellIndex);
            });
        });
        
        // Add row hover effects
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.classList.add('hover');
            });
            row.addEventListener('mouseleave', () => {
                row.classList.remove('hover');
            });
        });
    });
};

App.sortTable = function(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Determine sort type (number or string)
    const firstCellValue = rows[0]?.querySelector(`td:nth-child(${columnIndex + 1})`)?.textContent.trim();
    const isNumeric = !isNaN(parseFloat(firstCellValue)) && isFinite(firstCellValue);
    
    // Get current sort direction
    const headers = table.querySelectorAll('thead th');
    let currentDirection = headers[columnIndex].getAttribute('data-sort-direction') || 'asc';
    currentDirection = currentDirection === 'asc' ? 1 : -1;
    
    // Sort rows
    rows.sort((a, b) => {
        const cellA = a.querySelector(`td:nth-child(${columnIndex + 1})`)?.textContent.trim() || '';
        const cellB = b.querySelector(`td:nth-child(${columnIndex + 1})`)?.textContent.trim() || '';
        
        let valueA = isNumeric ? parseFloat(cellA) : cellA.toLowerCase();
        let valueB = isNumeric ? parseFloat(cellB) : cellB.toLowerCase();
        
        if (valueA < valueB) return -1 * currentDirection;
        if (valueA > valueB) return 1 * currentDirection;
        return 0;
    });
    
    // Toggle sort direction
    headers.forEach((header, index) => {
        if (index === columnIndex) {
            header.setAttribute('data-sort-direction', currentDirection === 1 ? 'desc' : 'asc');
            header.classList.add('sorted');
            header.classList.toggle('desc', currentDirection === -1);
        } else {
            header.classList.remove('sorted');
            header.removeAttribute('data-sort-direction');
        }
    });
    
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
};

/**
 * History/Navigation Management
 */
App.handlePopState = function(event) {
    // Handle browser back/forward navigation
    const url = window.location.href;
    // You could implement page reloading or content updating here
    console.log('Navigated to:', url);
};

// Start the application when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    App.init();
});
