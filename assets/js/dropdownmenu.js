const dropdownmenu = document.getElementById('dropdownmenu');
const navMenu = document.getElementById('nav-menu');

dropdownmenu.addEventListener('click', () => {
    navMenu.classList.toggle('active');
    
    dropdownmenu.classList.toggle('is-active');
});