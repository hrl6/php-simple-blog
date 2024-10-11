document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const close = document.getElementById('close');
    const logoImg = document.getElementById('logo-img');
    const welcome = document.getElementById('wc')
    const action = document.getElementById('header-form');
    const navUl = document.querySelector('nav ul');

    hamburger.addEventListener('click', () => {
        navUl.classList.toggle('active');
        logoImg.classList.toggle('hide');
        close.classList.toggle('active');
        welcome.classList.toggle('hide');
        action.classList.toggle('flexend');
        hamburger.classList.toggle('hide');
    });

    close.addEventListener('click', () => {
        navUl.classList.remove('active');
        logoImg.classList.remove('hide');
        close.classList.remove('active');
        welcome.classList.remove('hide');
        action.classList.remove('flexend');
        hamburger.classList.remove('hide');
    });
});