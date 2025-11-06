    // Abrir modal de reservas
    document.getElementById("reservationBtn").addEventListener("click", function() {
        document.getElementById("reservationModal").style.display = "block";
    });

    // Abrir modal de menú
    document.getElementById("menuBtn").addEventListener("click", function() {
        document.getElementById("menuModal").style.display = "block";
    });

    // Cerrar modales al dar clic en la X
    document.querySelectorAll(".close-modal").forEach(function(element) {
        element.addEventListener("click", function() {
            this.closest(".modal").style.display = "none";
        });
    });

    // Cerrar modales al hacer clic fuera del contenido
    window.addEventListener("click", function(e) {
        if (e.target.classList.contains("modal")) {
            e.target.style.display = "none";
        }
    });
