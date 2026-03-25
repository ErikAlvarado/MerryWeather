function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;
    
    document.querySelectorAll('.dropdown-content').forEach(content => {
        if (content !== dropdown) {
            content.classList.remove('show');
        }
    });

    dropdown.classList.toggle('show');
}

window.onclick = function(event) {
    if (!event.target.matches('.btn')) {
        document.querySelectorAll('.dropdown-content').forEach(content => {
            content.classList.remove('show');
        });
    }
}