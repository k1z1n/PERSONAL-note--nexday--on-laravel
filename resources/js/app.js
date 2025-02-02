import './bootstrap';
import 'flowbite';
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";


document.addEventListener("DOMContentLoaded", function () {

});

document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    // Убираем класс `no-animation` после загрузки
    setTimeout(() => {
        mobileMenu.classList.remove('no-animation');
    }, 100); // Задержка, чтобы избежать показа анимации при загрузке

    const toggleMenu = () => {
        const isVisible = mobileMenu.classList.contains('menu-visible');
        const targetHeight = mobileMenu.scrollHeight + 'px';

        if (isVisible) {
            mobileMenu.style.setProperty('--target-height', targetHeight);
            mobileMenu.classList.remove('menu-visible');
            mobileMenu.classList.add('menu-hidden');
        } else {
            mobileMenu.style.setProperty('--target-height', targetHeight);
            mobileMenu.classList.remove('menu-hidden');
            mobileMenu.classList.add('menu-visible');
        }
    };

    const closeMenuOnScroll = () => {
        if (mobileMenu.classList.contains('menu-visible')) {
            mobileMenu.classList.remove('menu-visible');
            mobileMenu.classList.add('menu-hidden');
        }
    };

    const closeMenuOnClickOutside = (event) => {
        if (!menuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
            if (mobileMenu.classList.contains('menu-visible')) {
                mobileMenu.classList.remove('menu-visible');
                mobileMenu.classList.add('menu-hidden');
            }
        }
    };

    menuToggle.addEventListener('click', toggleMenu);
    window.addEventListener('scroll', closeMenuOnScroll);
    document.addEventListener('click', closeMenuOnClickOutside);
});
window.addEventListener('hide-notification', event => {
    setTimeout(() => {
        const notification = document.getElementById('notification');
        if (notification) {
            notification.style.opacity = '0'; // Плавное исчезновение
            setTimeout(() => {
                notification.remove(); // Удаляем уведомление из DOM
                Livewire.dispatch('clearNotification'); // Отправляем событие для сброса состояния
            }, 300); // Удаление после завершения анимации
        }
    }, event.detail.timeout || 4000);
});


