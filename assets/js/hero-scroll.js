const hero = document.getElementById("hero");

window.addEventListener("scroll", () => {
    const scroll = window.scrollY;
    const fadeLimit = window.innerHeight;

    let opacity = 1 - scroll / fadeLimit;

    if (opacity < 0) opacity = 0;

    hero.style.opacity = opacity;
});

  function openModal(id) {
    document.getElementById('modal').style.display = 'block';
    document.querySelectorAll('.modal-text').forEach(el => el.style.display = 'none');
    document.getElementById(id).style.display = 'block';
  }

  function closeModal() {
    document.getElementById('modal').style.display = 'none';
  }

  // Cerrar modal al hacer clic fuera
  window.onclick = function(event) {
    const modal = document.getElementById('modal');
    if (event.target === modal) {
      closeModal();
    }
  }
