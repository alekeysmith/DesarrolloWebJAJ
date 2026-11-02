// ---------- Estado ----------
let recetaActual = null;      // id de la receta abierta en el modal
let controladorModal = null;  // AbortController de la petición del modal

// ---------- Utilidades ----------
function mostrarMensaje(texto, tipo) {
    const msg = document.getElementById("mensaje");
    msg.textContent = texto;
    msg.className = tipo || "";
}

// ---------- Pregunta 4: catálogo con fetch() ----------
async function pregunta4() {
    const contenedor = document.getElementById("contenido");
    contenedor.innerHTML = "<p>Cargando catálogo...</p>";
    try {
        const response = await fetch("catalogo.php");
        if (!response.ok) {
            throw new Error("Error HTTP: " + response.status);
        }
        contenedor.innerHTML = await response.text();
    } catch (error) {
        contenedor.innerHTML = "<p class='error'>No se pudo cargar el catálogo: " + error.message + "</p>";
    }
}

// ---------- Modal: detalle de la receta ----------
async function abrirmodal(id) {
    // Si había una petición anterior en curso, se cancela (evita respuestas cruzadas)
    if (controladorModal) controladorModal.abort();
    controladorModal = new AbortController();

    recetaActual = id;
    const contenedor = document.getElementById("contenido-modal");
    contenedor.innerHTML = "<p>Cargando...</p>";
    document.querySelector(".modal").style.display = "flex";

    try {
        const response = await fetch("datos-receta.php?id=" + encodeURIComponent(id), {
            signal: controladorModal.signal
        });
        if (!response.ok) {
            throw new Error("Error HTTP: " + response.status);
        }
        contenedor.innerHTML = await response.text();
    } catch (error) {
        if (error.name === "AbortError") return; // cancelada a propósito
        contenedor.innerHTML = "<p class='error'>No se pudo cargar la receta: " + error.message + "</p>";
    }
}

function cerrarmodal() {
    if (controladorModal) controladorModal.abort();
    recetaActual = null;
    document.querySelector(".modal").style.display = "none";
}

// ---------- Eliminar: fetch DELETE + recarga automática del catálogo ----------
async function eliminarReceta() {
    if (recetaActual === null) return;
    if (!confirm("¿Seguro que desea eliminar esta receta?")) return;

    const boton = document.getElementById("btnEliminar");
    boton.disabled = true;
    try {
        const response = await fetch("eliminar.php?id=" + encodeURIComponent(recetaActual), {
            method: "DELETE"
        });
        const resultado = await response.json();
        if (!response.ok || !resultado.exito) {
            throw new Error(resultado.mensaje || "Error HTTP: " + response.status);
        }

        cerrarmodal();               // 1) cierra el modal
        await pregunta4();           // 2) recarga el catálogo con otra llamada fetch
        mostrarMensaje("Receta eliminada correctamente", "ok");
    } catch (error) {
        mostrarMensaje("No se pudo eliminar: " + error.message, "error");
    } finally {
        boton.disabled = false;      // la interfaz siempre se restaura
    }
}
