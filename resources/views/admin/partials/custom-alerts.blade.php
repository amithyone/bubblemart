<!-- Custom Alert Modal -->
<div class="modal fade" id="customAlertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalTitle">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" id="alertModalHeader">
                <h5 class="modal-title" id="alertModalTitle">
                    <i class="fas fa-info-circle me-2"></i>Alert
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-question-circle text-primary" id="alertModalIcon" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center mb-0" id="alertModalMessage">Are you sure you want to proceed?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="alertModalCancel">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="alertModalConfirm">
                    <i class="fas fa-check me-2"></i>Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalTitle">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalTitle">
                    <i class="fas fa-check-circle me-2"></i>Success
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center mb-0" id="successModalMessage">Operation completed successfully!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                    <i class="fas fa-check me-2"></i>OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalTitle">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalTitle">
                    <i class="fas fa-exclamation-triangle me-2"></i>Error
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center mb-0" id="errorModalMessage">An error occurred. Please try again.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Warning Modal -->
<div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModalTitle">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="warningModalTitle">
                    <i class="fas fa-exclamation-triangle me-2"></i>Warning
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center mb-0" id="warningModalMessage">Please review your action before proceeding.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                    <i class="fas fa-check me-2"></i>OK
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Global modal instances
let globalCustomAlertModalInstance = null;
let globalSuccessModalInstance = null;
let globalErrorModalInstance = null;
let globalWarningModalInstance = null;

// Global custom alert functions
window.showCustomAlert = function(title, message, type = 'info', confirmCallback = null) {
    const modal = document.getElementById('customAlertModal');
    const header = document.getElementById('alertModalHeader');
    const titleEl = document.getElementById('alertModalTitle');
    const icon = document.getElementById('alertModalIcon');
    const messageEl = document.getElementById('alertModalMessage');
    const confirmBtn = document.getElementById('alertModalConfirm');
    const cancelBtn = document.getElementById('alertModalCancel');
    
    // Set modal content based on type
    switch(type) {
        case 'warning':
            header.className = 'modal-header bg-warning text-dark';
            titleEl.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + title;
            icon.className = 'fas fa-exclamation-triangle text-warning';
            confirmBtn.className = 'btn btn-warning';
            break;
        case 'danger':
            header.className = 'modal-header bg-danger text-white';
            titleEl.innerHTML = '<i class="fas fa-times-circle me-2"></i>' + title;
            icon.className = 'fas fa-times-circle text-danger';
            confirmBtn.className = 'btn btn-danger';
            break;
        case 'success':
            header.className = 'modal-header bg-success text-white';
            titleEl.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + title;
            icon.className = 'fas fa-check-circle text-success';
            confirmBtn.className = 'btn btn-success';
            break;
        default:
            header.className = 'modal-header bg-primary text-white';
            titleEl.innerHTML = '<i class="fas fa-info-circle me-2"></i>' + title;
            icon.className = 'fas fa-info-circle text-primary';
            confirmBtn.className = 'btn btn-primary';
    }
    
    messageEl.textContent = message;
    
    // Remove existing event listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    
    // Set up confirm callback
    if (confirmCallback) {
        newConfirmBtn.onclick = function() {
            confirmCallback();
            if (globalCustomAlertModalInstance) {
                globalCustomAlertModalInstance.hide();
            }
        };
    } else {
        newConfirmBtn.onclick = function() {
            if (globalCustomAlertModalInstance) {
                globalCustomAlertModalInstance.hide();
            }
        };
    }
    
    // Create or reuse modal instance
    if (!globalCustomAlertModalInstance) {
        globalCustomAlertModalInstance = new bootstrap.Modal(modal, {
            backdrop: 'static',
            keyboard: false
        });
    }
    
    globalCustomAlertModalInstance.show();
};

// Show success modal
window.showSuccessModal = function(message) {
    document.getElementById('successModalMessage').textContent = message;
    
    if (!globalSuccessModalInstance) {
        globalSuccessModalInstance = new bootstrap.Modal(document.getElementById('successModal'), {
            backdrop: 'static',
            keyboard: false
        });
    }
    
    globalSuccessModalInstance.show();
};

// Show error modal
window.showErrorModal = function(message) {
    document.getElementById('errorModalMessage').textContent = message;
    
    if (!globalErrorModalInstance) {
        globalErrorModalInstance = new bootstrap.Modal(document.getElementById('errorModal'), {
            backdrop: 'static',
            keyboard: false
        });
    }
    
    globalErrorModalInstance.show();
};

// Show warning modal
window.showWarningModal = function(message) {
    document.getElementById('warningModalMessage').textContent = message;
    
    if (!globalWarningModalInstance) {
        globalWarningModalInstance = new bootstrap.Modal(document.getElementById('warningModal'), {
            backdrop: 'static',
            keyboard: false
        });
    }
    
    globalWarningModalInstance.show();
};

// Replace browser confirm with custom alert
window.confirm = function(message) {
    return new Promise((resolve) => {
        showCustomAlert('Confirm Action', message, 'warning', () => resolve(true));
        // If user clicks cancel, resolve with false
        document.getElementById('alertModalCancel').onclick = () => resolve(false);
    });
};

// Replace browser alert with custom modal
window.alert = function(message) {
    showCustomAlert('Information', message, 'info');
};

// Handle form submission with custom alerts
document.addEventListener('DOMContentLoaded', function() {
    // Check for success/error messages from server
    @if(session('success'))
        showSuccessModal('{{ session('success') }}');
    @endif
    
    @if(session('error'))
        showErrorModal('{{ session('error') }}');
    @endif
    
    @if(session('warning'))
        showWarningModal('{{ session('warning') }}');
    @endif
    
    @if($errors->any())
        showErrorModal('{{ $errors->first() }}');
    @endif
});

// Cleanup global modal instances when page is unloaded
window.addEventListener('beforeunload', function() {
    if (globalCustomAlertModalInstance) {
        globalCustomAlertModalInstance.dispose();
        globalCustomAlertModalInstance = null;
    }
    if (globalSuccessModalInstance) {
        globalSuccessModalInstance.dispose();
        globalSuccessModalInstance = null;
    }
    if (globalErrorModalInstance) {
        globalErrorModalInstance.dispose();
        globalErrorModalInstance = null;
    }
    if (globalWarningModalInstance) {
        globalWarningModalInstance.dispose();
        globalWarningModalInstance = null;
    }
});
</script> 