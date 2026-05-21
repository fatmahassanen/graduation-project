/**
 * Admin Dashboard Safety Layer
 * Prevents duplicate submissions, accidental deletions, and data loss
 */

// Prevent duplicate form submissions
document.addEventListener('DOMContentLoaded', function() {
    // Handle all forms with submit buttons
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        // Skip delete forms (they have their own handler)
        if (form.querySelector('input[name="_method"][value="DELETE"]')) {
            handleDeleteForm(form);
            return;
        }
        
        form.addEventListener('submit', function(e) {
            const submitButton = form.querySelector('button[type="submit"]');
            
            if (submitButton && !submitButton.disabled) {
                // Disable the button
                submitButton.disabled = true;
                
                // Store original content
                const originalHTML = submitButton.innerHTML;
                
                // Change button to loading state
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
                submitButton.classList.add('opacity-75', 'cursor-not-allowed');
                
                // Re-enable after 5 seconds as fallback (in case of network issues)
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalHTML;
                    submitButton.classList.remove('opacity-75', 'cursor-not-allowed');
                }, 5000);
            }
        });
    });
});

// Handle delete forms with custom modal
function handleDeleteForm(form) {
    // Remove inline onsubmit attribute
    form.removeAttribute('onsubmit');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Try to get item name from the form's context
        let itemName = 'this item';
        const formAction = form.action;
        
        if (formAction.includes('events')) itemName = 'this event';
        else if (formAction.includes('news')) itemName = 'this news article';
        else if (formAction.includes('departments')) itemName = 'this department';
        else if (formAction.includes('gallery')) itemName = 'this gallery item';
        else if (formAction.includes('trainings')) itemName = 'this training';
        else if (formAction.includes('activities')) itemName = 'this activity';
        else if (formAction.includes('competitions')) itemName = 'this competition';
        else if (formAction.includes('graduates')) itemName = 'this graduate achievement';
        else if (formAction.includes('protocols')) itemName = 'this protocol';
        else if (formAction.includes('deans')) itemName = 'this dean';
        else if (formAction.includes('tuition-fees')) itemName = 'this tuition fee';
        
        showConfirmModal(
            'Confirm Deletion',
            `Are you sure you want to delete ${itemName}? This action cannot be undone.`,
            'Delete',
            'bg-red-600 hover:bg-red-700',
            () => {
                // Disable the submit button
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                }
                
                // Mark form as safe to submit (bypass unsaved changes warning)
                formChanged = false;
                
                // Submit the form
                form.submit();
            }
        );
        
        return false;
    });
}

// Global confirmation modal
function showConfirmModal(title, message, confirmText, confirmClass, onConfirm) {
    // Remove existing modal if any
    const existingModal = document.getElementById('confirmModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Create modal HTML
    const modalHTML = `
        <div id="confirmModal" class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6 transform transition-all animate-fade-in">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">${title}</h3>
                        <button onclick="closeConfirmModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <p class="text-gray-600 mb-6">${message}</p>
                    <div class="flex justify-end gap-3">
                        <button onclick="closeConfirmModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                            Cancel
                        </button>
                        <button id="confirmActionBtn" class="px-4 py-2 text-white rounded-lg transition-colors font-medium ${confirmClass}">
                            ${confirmText}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Handle confirm button (only once)
    let confirmed = false;
    document.getElementById('confirmActionBtn').addEventListener('click', function() {
        if (!confirmed) {
            confirmed = true;
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
            closeConfirmModal();
            if (onConfirm) onConfirm();
        }
    });
    
    // Close on escape key
    const escapeHandler = function(e) {
        if (e.key === 'Escape') {
            closeConfirmModal();
            document.removeEventListener('keydown', escapeHandler);
        }
    };
    document.addEventListener('keydown', escapeHandler);
    
    // Close on backdrop click
    document.getElementById('confirmModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeConfirmModal();
        }
    });
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    if (modal) {
        modal.remove();
    }
}

// Confirm before leaving page with unsaved changes
let formChanged = false;

document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        // Skip delete forms
        if (form.querySelector('input[name="_method"][value="DELETE"]')) {
            return;
        }
        
        // Track form changes
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('change', () => {
                formChanged = true;
            });
            
            // Also track typing in text fields
            if (input.type === 'text' || input.tagName === 'TEXTAREA') {
                input.addEventListener('input', () => {
                    formChanged = true;
                });
            }
        });
        
        // Reset on submit
        form.addEventListener('submit', () => {
            formChanged = false;
        });
    });
    
    // Warn before leaving
    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
            return e.returnValue;
        }
    });
});

// Helper function for update confirmations (optional, can be used for extra safety)
function confirmUpdate(form, itemName = 'these changes') {
    showConfirmModal(
        'Confirm Update',
        `Are you sure you want to save ${itemName}?`,
        'Save Changes',
        'bg-blue-600 hover:bg-blue-700',
        () => {
            formChanged = false; // Reset to prevent beforeunload warning
            form.submit();
        }
    );
}

// Add simple fade-in animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    .animate-fade-in {
        animation: fadeIn 0.2s ease-out;
    }
`;
document.head.appendChild(style);
