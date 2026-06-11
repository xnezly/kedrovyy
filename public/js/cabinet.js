/**
 * Личный кабинет — чистый JavaScript (без Bootstrap)
 */

document.addEventListener('DOMContentLoaded', function () {
    initAlerts();
    initModals();
    initConfirmCancel();
    initTooltips();
    initTableInteractions();
});

// ===== УВЕДОМЛЕНИЯ =====
function initAlerts() {
    document.querySelectorAll('.dashboard-alert').forEach(alert => {
        const closeBtn = alert.querySelector('.dashboard-alert__close');

        const close = () => {
            alert.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => alert.remove(), 300);
        };

        if (closeBtn) {
            closeBtn.addEventListener('click', close);
        }

        // Автозакрытие через 5 секунд
        setTimeout(close, 5000);
    });
}

// ===== МОДАЛЬНЫЕ ОКНА =====
function initModals() {
    // Открытие модального окна
    document.querySelectorAll('[data-modal-open]').forEach(trigger => {
        trigger.addEventListener('click', function () {
            const modalId = this.dataset.modalOpen;
            const modal = document.getElementById(modalId);
            if (modal) openModal(modal);
        });
    });

    // Закрытие модального окна
    document.querySelectorAll('[data-modal-close]').forEach(closeBtn => {
        closeBtn.addEventListener('click', function () {
            const modal = this.closest('.modal');
            if (modal) closeModal(modal);
        });
    });

    // Закрытие по клику на оверлей
    document.querySelectorAll('.modal__overlay').forEach(overlay => {
        overlay.addEventListener('click', function () {
            const modal = this.closest('.modal');
            if (modal) closeModal(modal);
        });
    });

    // Закрытие по Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal[aria-hidden="false"]').forEach(modal => {
                closeModal(modal);
            });
        }
    });

    // Блокировка скролла при открытом модалке
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('transitionend', function () {
            if (this.getAttribute('aria-hidden') === 'false') {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
    });
}

function openModal(modal) {
    modal.setAttribute('aria-hidden', 'false');
    modal.style.display = 'flex';

    // Фокус на первую кнопку закрытия для доступности
    const closeBtn = modal.querySelector('[data-modal-close]');
    if (closeBtn) closeBtn.focus();
}

function closeModal(modal) {
    modal.setAttribute('aria-hidden', 'true');
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

// ===== ПОДТВЕРЖДЕНИЕ ОТМЕНЫ =====
function initConfirmCancel() {
    document.querySelectorAll('[data-confirm-cancel]').forEach(button => {
        button.addEventListener('click', function () {
            const actionUrl = this.dataset.action;
            const appName = this.dataset.appName || 'это бронирование';

            if (confirm(`Вы действительно хотите отменить "${appName}"?\n\nЭто действие нельзя отменить.`)) {
                // Создаём и отправляем форму
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = actionUrl;

                // CSRF токен
                const csrf = document.querySelector('meta[name="csrf-token"]');
                const fallbackCsrf = document.querySelector('input[name="_token"]');
                const csrfValue = csrf?.content || fallbackCsrf?.value;

                if (csrfValue) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = '_token';
                    input.value = csrfValue;
                    form.appendChild(input);
                } else {
                    console.error('CSRF token not found for cancellation form.');
                    return;
                }

                // Метод DELETE если нужно
                if (this.dataset.method?.toLowerCase() === 'delete') {
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);
                }

                document.body.appendChild(form);
                form.submit();
            }
        });
    });
}

// ===== TOOLTIPS (простая реализация) =====
function initTooltips() {
    document.querySelectorAll('[title]').forEach(el => {
        // Пропускаем элементы внутри модальных окон (там свои тултипы)
        if (el.closest('.modal')) return;

        el.addEventListener('mouseenter', showTooltip);
        el.addEventListener('mouseleave', hideTooltip);
    });
}

let tooltipTimeout;

function showTooltip(e) {
    const el = e.currentTarget;
    const text = el.getAttribute('title');
    if (!text) return;

    // Создаём тултип
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = text;
    tooltip.style.cssText = `
        position: absolute;
        background: #333;
        color: #fff;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        white-space: nowrap;
        z-index: 9999;
        pointer-events: none;
        animation: fadeIn 0.1s ease;
    `;

    document.body.appendChild(tooltip);

    // Позиционирование
    const rect = el.getBoundingClientRect();
    const tooltipRect = tooltip.getBoundingClientRect();

    let top = rect.top - tooltipRect.height - 8;
    let left = rect.left + (rect.width - tooltipRect.width) / 2;

    // Корректировка если вылезает за экран
    if (top < 10) top = rect.bottom + 8;
    if (left < 10) left = 10;
    if (left + tooltipRect.width > window.innerWidth - 10) {
        left = window.innerWidth - tooltipRect.width - 10;
    }

    tooltip.style.top = `${top + window.scrollY}px`;
    tooltip.style.left = `${left + window.scrollX}px`;

    el.dataset.tooltip = 'true';
    el._tooltip = tooltip;
}

function hideTooltip(e) {
    const el = e.currentTarget;
    if (el._tooltip) {
        el._tooltip.remove();
        delete el._tooltip;
    }
}

// ===== ТАБЛИЦА =====
function initTableInteractions() {
    // Подсветка строк
    document.querySelectorAll('.dashboard-table__row').forEach(row => {
        row.addEventListener('mouseenter', () => row.style.cursor = 'pointer');
        row.addEventListener('mouseleave', () => row.style.cursor = 'default');
    });

    // Предотвращение всплытия кликов по ссылкам/кнопкам
    document.querySelectorAll('.dashboard-table__link, .dashboard-actions__btn').forEach(el => {
        el.addEventListener('click', e => e.stopPropagation());
    });
}

// ===== УТИЛИТЫ =====
window.Dashboard = {
    openModal: (id) => {
        const modal = document.getElementById(id);
        if (modal) openModal(modal);
    },
    closeModal: (id) => {
        const modal = document.getElementById(id);
        if (modal) closeModal(modal);
    },
    showNotification: (message, type = 'info', duration = 4000) => {
        const alert = document.createElement('div');
        alert.className = `dashboard-alert dashboard-alert--${type}`;
        alert.innerHTML = `
            <span class="dashboard-alert__text">${message}</span>
            <button class="dashboard-alert__close" aria-label="Закрыть">&times;</button>
        `;
        document.body.appendChild(alert);

        alert.querySelector('.dashboard-alert__close').onclick = () => alert.remove();
        if (duration > 0) setTimeout(() => alert.remove(), duration);
    }
};
