document.addEventListener("DOMContentLoaded", function () {
    const navButtons = document.querySelectorAll(".nav-button");
    const highlight = document.getElementById("nav-content-highlight");
    const navToggle = document.getElementById("nav-toggle");
    const mainContent = document.getElementById("main-content");

    highlight.style.opacity = "0";
    let activeButton = null;

    // Obtener el nombre del botón activo desde la meta etiqueta
    const activeNav = document.querySelector("meta[name='active-nav']").content.trim();

    function actualizarResaltado(button) {
        highlight.style.opacity = "1";
        const index = Array.from(navButtons).indexOf(button);
        const topPosition = index * 54 + 16;
        highlight.style.top = `${topPosition}px`;
        button.style.color = "var(--navbar-dark-primary)";
        button.setAttribute("aria-current", "page"); // Mejora accesibilidad
        activeButton = button;
    }

    // Buscar el botón que coincide con activeNav
    navButtons.forEach((button) => {
        const buttonText = button.getAttribute("data-nav").trim();
        if (buttonText === activeNav) {
            actualizarResaltado(button);
        }

        button.addEventListener("focus", () => actualizarResaltado(button));

        button.addEventListener("blur", () => {
            highlight.style.opacity = "0";
            button.style.color = "";
            button.removeAttribute("aria-current");
        });
    });

    // Ajustar contenido cuando cambia el menú
    navToggle.addEventListener("change", () => {
        ajustarContenido();
        if (activeButton) {
            actualizarResaltado(activeButton);
        } else {
            highlight.style.opacity = "0";
        }

        // Guardar el estado del toggle en sessionStorage
        sessionStorage.setItem("sidebarVisible", navToggle.checked);
    });

    function ajustarContenido() {
        mainContent.style.transition = "margin-left 0.3s ease";
        mainContent.style.marginLeft = navToggle.checked ? "66px" : "240px";
    }

    // Comprobar el estado guardado en sessionStorage y ajustar el estado del sidebar
    const sidebarVisible = sessionStorage.getItem("sidebarVisible");
    if (sidebarVisible !== null) {
        navToggle.checked = JSON.parse(sidebarVisible);
    }

    // Ajustar la interfaz con el estado guardado
    ajustarContenido();
});
