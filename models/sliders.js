
  let index = 0;
  const slides = document.querySelector(".slides");
  const totalSlides = slides.children.length;

  function showSlide(i) {
    index = i;

    // Si llega al final, vuelve al inicio
    if (index >= totalSlides) index = 0;
    if (index < 0) index = totalSlides - 1;

    slides.style.transform = `translateX(${-index * 100}%)`;
  }

  function nextSlide() {
    showSlide(index + 1);
  }

  function prevSlide() {
    showSlide(index - 1);
  }

  // AUTO SLIDE (cada 4 segundos)
  setInterval(() => {
    nextSlide();
  }, 4000);
