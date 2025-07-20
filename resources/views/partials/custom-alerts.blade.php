<!-- Custom Alert Modal -->
<div class="modal fade" id="customAlertModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: rgba(0, 0, 0, 0.9) !important; border: none; border-radius: 15px;">
            <div class="modal-header" id="alertModalHeader" style="background: rgba(0, 0, 0, 0.95) !important; border-bottom: 1px solid rgba(255,255,255,0.1) !important; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title text-theme-1" id="alertModalTitle">
                    <i class="fas fa-info-circle me-2"></i>Alert
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-theme-1">
                <div class="text-center mb-3">
                    <i class="fas fa-question-circle text-theme-1" id="alertModalIcon" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center mb-0 text-theme-1" id="alertModalMessage">Are you sure you want to proceed?</p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1) !important; border-radius: 0 0 15px 15px;">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="alertModalCancel" style="border-radius: 10px;">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-theme" id="alertModalConfirm" style="border-radius: 10px; background: linear-gradient(135deg, var(--main-color) 0%, #005a66 100%) !important; border: none !important;">
                    <i class="fas fa-check me-2"></i>Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: rgba(0, 0, 0, 0.9) !important; border: none; border-radius: 15px;">
            <div class="modal-header" style="background: rgba(0, 168, 107, 0.2) !important; border-bottom: 1px solid rgba(0, 168, 107, 0.3) !important; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title text-theme-1">
                    <i class="fas fa-check-circle me-2"></i>Success
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-theme-1">
                <div class="text-center mb-3">
                    <i class="fas fa-check-circle" style="font-size: 3rem; color: var(--accent-green);"></i>
                </div>
                <p class="text-center mb-0 text-theme-1" id="successModalMessage">Operation completed successfully!</p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1) !important; border-radius: 0 0 15px 15px;">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" style="border-radius: 10px; background: linear-gradient(135deg, var(--accent-green) 0%, #00c853 100%) !important; border: none !important;">
                    <i class="fas fa-check me-2"></i>OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: rgba(0, 0, 0, 0.9) !important; border: none; border-radius: 15px;">
            <div class="modal-header" style="background: rgba(249, 73, 67, 0.2) !important; border-bottom: 1px solid rgba(249, 73, 67, 0.3) !important; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title text-theme-1">
                    <i class="fas fa-exclamation-triangle me-2"></i>Error
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-theme-1">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: var(--accent-red);"></i>
                </div>
                <p class="text-center mb-0 text-theme-1" id="errorModalMessage">An error occurred. Please try again.</p>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="contactSupport()" style="border-radius: 10px;">
                        <i class="fas fa-headset me-2"></i>Contact Support
                    </button>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1) !important; border-radius: 0 0 15px 15px;">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="border-radius: 10px; background: linear-gradient(135deg, var(--accent-red) 0%, #e63946 100%) !important; border: none !important;">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Warning Modal -->
<div class="modal fade" id="warningModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: rgba(0, 0, 0, 0.9) !important; border: none; border-radius: 15px;">
            <div class="modal-header" style="background: rgba(252, 164, 136, 0.2) !important; border-bottom: 1px solid rgba(252, 164, 136, 0.3) !important; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title text-theme-1">
                    <i class="fas fa-exclamation-triangle me-2"></i>Warning
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-theme-1">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: var(--accent-orange);"></i>
                </div>
                <p class="text-center mb-0 text-theme-1" id="warningModalMessage">Please review your action before proceeding.</p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1) !important; border-radius: 0 0 15px 15px;">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal" style="border-radius: 10px; background: linear-gradient(135deg, var(--accent-orange) 0%, #ff8c42 100%) !important; border: none !important;">
                    <i class="fas fa-check me-2"></i>OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Error Modal -->
<div class="modal fade" id="paymentErrorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: rgba(0, 0, 0, 0.9) !important; border: none; border-radius: 15px;">
            <div class="modal-header" style="background: rgba(249, 73, 67, 0.2) !important; border-bottom: 1px solid rgba(249, 73, 67, 0.3) !important; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title text-theme-1">
                    <i class="fas fa-credit-card me-2"></i>Payment Error
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-theme-1">
                <div class="text-center mb-3">
                    <i class="fas fa-times-circle" style="font-size: 3rem; color: var(--accent-red);"></i>
                </div>
                <p class="text-center mb-0 text-theme-1" id="paymentErrorModalMessage">Your payment could not be processed. Please try again.</p>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="contactSupport()" style="border-radius: 10px;">
                        <i class="fas fa-headset me-2"></i>Contact Support
                    </button>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1) !important; border-radius: 0 0 15px 15px;">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="border-radius: 10px; background: linear-gradient(135deg, var(--accent-red) 0%, #e63946 100%) !important; border: none !important;">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
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
            header.style.background = 'rgba(252, 164, 136, 0.2) !important';
            header.style.borderBottom = '1px solid rgba(252, 164, 136, 0.3) !important';
            titleEl.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + title;
            icon.style.color = 'var(--accent-orange)';
            confirmBtn.style.background = 'linear-gradient(135deg, var(--accent-orange) 0%, #ff8c42 100%) !important';
            confirmBtn.style.border = 'none !important';
            break;
        case 'danger':
            header.style.background = 'rgba(249, 73, 67, 0.2) !important';
            header.style.borderBottom = '1px solid rgba(249, 73, 67, 0.3) !important';
            titleEl.innerHTML = '<i class="fas fa-times-circle me-2"></i>' + title;
            icon.style.color = 'var(--accent-red)';
            confirmBtn.style.background = 'linear-gradient(135deg, var(--accent-red) 0%, #e63946 100%) !important';
            confirmBtn.style.border = 'none !important';
            break;
        case 'success':
            header.style.background = 'rgba(0, 168, 107, 0.2) !important';
            header.style.borderBottom = '1px solid rgba(0, 168, 107, 0.3) !important';
            titleEl.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + title;
            icon.style.color = 'var(--accent-green)';
            confirmBtn.style.background = 'linear-gradient(135deg, var(--accent-green) 0%, #00c853 100%) !important';
            confirmBtn.style.border = 'none !important';
            break;
        default:
            header.style.background = 'rgba(0, 73, 83, 0.2) !important';
            header.style.borderBottom = '1px solid rgba(0, 73, 83, 0.3) !important';
            titleEl.innerHTML = '<i class="fas fa-info-circle me-2"></i>' + title;
            icon.style.color = 'var(--main-color)';
            confirmBtn.style.background = 'linear-gradient(135deg, var(--main-color) 0%, #005a66 100%) !important';
            confirmBtn.style.border = 'none !important';
    }
    
    messageEl.textContent = message;
    
    // Set up confirm callback
    if (confirmCallback) {
        confirmBtn.onclick = function() {
            confirmCallback();
            bootstrap.Modal.getInstance(modal).hide();
        };
    } else {
        confirmBtn.onclick = function() {
            bootstrap.Modal.getInstance(modal).hide();
        };
    }
    
    // Show modal
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
};

// Show success modal
window.showSuccessModal = function(message) {
    document.getElementById('successModalMessage').textContent = message;
    const modal = new bootstrap.Modal(document.getElementById('successModal'));
    modal.show();
};

// Show error modal
window.showErrorModal = function(message) {
    document.getElementById('errorModalMessage').textContent = message;
    const modal = new bootstrap.Modal(document.getElementById('errorModal'));
    modal.show();
};

// Show warning modal
window.showWarningModal = function(message) {
    document.getElementById('warningModalMessage').textContent = message;
    const modal = new bootstrap.Modal(document.getElementById('warningModal'));
    modal.show();
};

// Show payment error modal
window.showPaymentErrorModal = function(message) {
    document.getElementById('paymentErrorModalMessage').textContent = message;
    const modal = new bootstrap.Modal(document.getElementById('paymentErrorModal'));
    modal.show();
};

// Contact support function
window.contactSupport = function() {
    // You can customize this to open a contact form or redirect to support page
    window.open('mailto:support@bubblemart.com?subject=Payment%20Issue%20Support', '_blank');
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
</script> 