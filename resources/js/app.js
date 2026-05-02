import './bootstrap';

import Alpine from 'alpinejs';
import 'flowbite';

window.Alpine = Alpine;

Alpine.start();

const initSubmitLoadingStates = () => {
    document.addEventListener('submit', (event) => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement)) {
            return;
        }
        if ((form.method || 'get').toLowerCase() === 'get' || form.dataset.noLoading === 'true') {
            return;
        }

        const submitter = event.submitter || form.querySelector('button[type="submit"], input[type="submit"]');
        if (!submitter || submitter.dataset.noLoading === 'true' || submitter.disabled) {
            return;
        }

        const loadingText = submitter.dataset.loadingText || 'Dang xu ly...';
        submitter.disabled = true;
        submitter.setAttribute('aria-busy', 'true');
        submitter.classList.add('linear-btn-loading');
        if (submitter instanceof HTMLInputElement) {
            if (!submitter.dataset.originalValue) {
                submitter.dataset.originalValue = submitter.value;
            }
            submitter.value = loadingText;
        } else {
            if (!submitter.dataset.originalText) {
                submitter.dataset.originalText = submitter.innerHTML;
            }
            submitter.innerHTML = `<span>${loadingText}</span>`;
        }
    });
};

const initModalAnimations = () => {
    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-modal-toggle], [data-modal-target]');
        if (!trigger) {
            return;
        }

        const modalId = trigger.getAttribute('data-modal-toggle') || trigger.getAttribute('data-modal-target');
        const modal = modalId ? document.getElementById(modalId) : null;
        if (!modal) {
            return;
        }

        requestAnimationFrame(() => {
            const panel = modal.querySelector('.mx-auto, .relative.max-h-full, .relative.rounded-lg, .linear-modal-card');
            if (!panel) {
                return;
            }
            panel.classList.remove('animate-pop-in');
            void panel.offsetWidth;
            panel.classList.add('animate-pop-in');
        });
    });
};

initSubmitLoadingStates();
initModalAnimations();
