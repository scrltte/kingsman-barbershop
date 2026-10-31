document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('appointmentForm');
    
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            
            try {
                const response = await fetch('/appointment/create', {
                    method: 'POST',
                    body: formData
                });
                
                if (response.ok) {
                    showToast('Запись успешно создана! Мы ждем вас.');
                    form.reset();
                } else {
                    showToast('Произошла ошибка при создании записи.', 'danger');
                }
            } catch (err) {
                console.error(err);
                showToast('Сетевая ошибка.', 'danger');
            }
        });
    }
});

// Функция для динамического показа Bootstrap Toast уведомлений
function showToast(message, type = 'success') {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        container.style.zIndex = '11';
        document.body.appendChild(container);
    }

    const toastId = 'toast_' + Date.now();
    const bgClass = type === 'success' ? 'bg-dark text-white border-gold' : 'bg-danger text-white';
    
    const toastHtml = `
        <div id="${toastId}" class="toast show ${bgClass}" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-dark text-gold border-secondary">
                <strong class="me-auto">Kingsman</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', toastHtml);
    
    const toastElement = document.getElementById(toastId);
    const bsToast = new bootstrap.Toast(toastElement, { delay: 4000 });
    
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}