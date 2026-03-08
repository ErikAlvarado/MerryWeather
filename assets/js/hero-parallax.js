const hero = document.querySelector(".hero");

window.addEventListener("scroll", () => {

    let scroll = window.scrollY;

    hero.style.backgroundPosition = "center " + (scroll * 0.001) + "px";

});