const botonesModal = document.querySelectorAll(".btn-modal");
const modales = document.querySelectorAll(".modal");
const cerrarBtns = document.querySelectorAll(".cerrar");
botonesModal.forEach(btn => {
    btn.addEventListener("click", () => {
        const id = btn.getAttribute("data-modal");
        document.getElementById(id).classList.add("activa");
    });
});
cerrarBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        btn.closest(".modal").classList.remove("activa");
    });
});
window.addEventListener("click", (e) => {
    modales.forEach(modal => {
        if(e.target === modal){
            modal.classList.remove("activa");
        }
    });
});