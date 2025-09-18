// Validaciones del formulario de registro
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.querySelector('form[action*="processRegister"]');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;
            const email = document.querySelector('input[name="email"]').value;
            
            // Validar campos vacíos
            if (!email.trim() || !password || !confirmPassword) {
                e.preventDefault();
                showAlert('Todos los campos son requeridos', 'danger');
                return;
            }
            
            // Validar formato de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                showAlert('Por favor ingresa un email válido', 'danger');
                return;
            }
            
            // Validar que las contraseñas coincidan
            if (password !== confirmPassword) {
                e.preventDefault();
                showAlert('Las contraseñas no coinciden', 'danger');
                return;
            }
            
            // Validar longitud de contraseña
            if (password.length < 6) {
                e.preventDefault();
                showAlert('La contraseña debe tener al menos 6 caracteres', 'danger');
                return;
            }
        });
        
        // Validación en tiempo real para contraseñas
        const passwordInput = document.querySelector('input[name="password"]');
        const confirmPasswordInput = document.querySelector('input[name="confirm_password"]');
        
        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', function() {
                if (passwordInput.value !== this.value && this.value !== '') {
                    this.setCustomValidity('Las contraseñas no coinciden');
                    this.style.borderColor = '#dc3545';
                } else {
                    this.setCustomValidity('');
                    this.style.borderColor = '';
                }
            });
        }
    }
});

function showAlert(message, type) {
    // Remover alertas existentes
    const existingAlerts = document.querySelectorAll('.alert:not([class*="mt-3"])');
    existingAlerts.forEach(alert => alert.remove());
    
    // Crear nueva alerta
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    // Insertar después del botón de submit
    const submitButton = document.querySelector('button[type="submit"]');
    submitButton.parentNode.insertBefore(alertDiv, submitButton.nextSibling);
    
    // Remover después de 5 segundos
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
