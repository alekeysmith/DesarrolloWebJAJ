/* ============================================================
   app.js - Pagina personal con AJAX (Fetch API + async/await)
   Tema 5 - SIS256
   ------------------------------------------------------------
   Flujo (como en la diapositiva "AJAX: concepto y funcionamiento"):
   Usuario hace clic -> JavaScript crea la peticion -> fetch la envia
   (asincrona) -> el servidor responde -> JavaScript actualiza SOLO
   el DOM necesario. La pagina nunca se recarga.
   ============================================================ */

/* ---------- Configuracion: una entrada por seccion ---------- */
const SECCIONES = {
  yo:       { titulo: "HOLA SOY JOAN ALEXANDER ESTUDIANTE DE SIS256", alCargar: cargarCertificaciones },
  familia:  { titulo: "MI FAMILIA",                                   alCargar: cargarFamilia },
  amigos:   { titulo: "MIS AMIGOS",                                   alCargar: cargarAmigos },
  ciudad:   { titulo: "DONDE VIVO ACTUALMENTE",                       alCargar: cargarDatosSucre },
  hobbies:  { titulo: "COSAS QUE ME GUSTA HACER EN MI TIEMPO LIBRE",  alCargar: cargarHobbies },
  contacto: { titulo: "ME AGRADARÍA ESCUCHARTE Y SABER MÁS DE TÍ",    alCargar: activarFormularios },
};

const contenido = document.querySelector("#contenido");
const tituloH1 = document.querySelector("#titulo");
const temaLink = document.querySelector("#tema");

// Cache simple en memoria: una seccion ya pedida no se vuelve a pedir
const cache = new Map();

// Para cancelar la peticion anterior si el usuario hace clic rapido
let controlador = null;

/* ============================================================
   1. CARGAR UNA SECCION  (fetch GET -> texto/HTML)
   ============================================================ */
async function cargarSeccion(nombre) {
  if (!SECCIONES[nombre]) nombre = "yo";
  marcarActivo(nombre);

  if (controlador) controlador.abort();
  controlador = new AbortController();
  const { signal } = controlador;

  try {
    // Pedimos el HTML y cambiamos los colores del tema a la vez
    const [html] = await Promise.all([
      obtenerHTML(nombre, signal),
      cambiarTema(nombre),
    ]);
    if (signal.aborted) return;

    // Solo se actualiza esta parte; header y menu no se tocan
    contenido.innerHTML = html;
    tituloH1.textContent = SECCIONES[nombre].titulo;
    document.title = SECCIONES[nombre].titulo;

    // Codigo extra de cada seccion (llenar tablas, activar formularios...)
    await SECCIONES[nombre].alCargar();
  } catch (err) {
    if (err.name === "AbortError") return; // el usuario cambio de seccion
    mostrarError(
      err instanceof TypeError
        ? "No se pudo conectar. Abre la pagina con un servidor local (Live Server o XAMPP), no con doble clic."
        : "No se pudo cargar la seccion: " + err.message
    );
  }
}

async function obtenerHTML(nombre, signal) {
  if (cache.has(nombre)) return cache.get(nombre);

  // Estado: cargando
  contenido.innerHTML = '<p class="estado">Cargando...</p>';

  const resp = await fetch(`secciones/${nombre}.html`, { signal });
  // fetch NO rechaza con 404/500: siempre hay que verificar response.ok
  if (!resp.ok) throw new Error(`Error HTTP ${resp.status}`);

  const html = await resp.text();
  cache.set(nombre, html);
  return html;
}

/* Cada pagina de la tarea 3 tenia sus propios colores (CSS).
   Cambiamos el <link id="tema"> y esperamos a que cargue, para que no parpadee. */
function cambiarTema(nombre) {
  const href = `css/${nombre}.css`;
  if (temaLink.getAttribute("href") === href) return Promise.resolve();

  return new Promise((resolve) => {
    temaLink.onload = temaLink.onerror = () => resolve();
    temaLink.setAttribute("href", href);
    setTimeout(resolve, 1500); // por si acaso
  });
}

/* ============================================================
   2. DATOS DESDE JSON  (fetch GET -> response.json())
   ============================================================ */
async function pedirJSON(url) {
  const resp = await fetch(url);
  if (!resp.ok) throw new Error(`Error HTTP ${resp.status} al pedir ${url}`);
  return resp.json();
}

// Crea <td>/<th>/<div> con textContent (NO innerHTML) para evitar XSS
function crear(etiqueta, texto, clase) {
  const el = document.createElement(etiqueta);
  el.textContent = texto;
  if (clase) el.className = clase;
  return el;
}

function errorEnTabla(tbody, columnas, mensaje) {
  const fila = document.createElement("tr");
  const td = crear("td", mensaje, "error");
  td.colSpan = columnas;
  fila.append(td);
  tbody.replaceChildren(fila);
}

/* ---- Seccion YO: certificaciones ---- */
async function cargarCertificaciones() {
  const tbody = document.querySelector("#tabla-certs");
  if (!tbody) return;
  try {
    const certificaciones = await pedirJSON("datos/certificaciones.json");
    tbody.replaceChildren();
    for (const c of certificaciones) {
      const fila = document.createElement("tr");
      fila.append(crear("td", c.nombre), crear("td", c.institucion), crear("td", c.anio));
      tbody.append(fila);
    }
  } catch (err) {
    console.error(err);
    errorEnTabla(tbody, 3, "No se pudieron cargar las certificaciones");
  }
}

/* ---- Seccion FAMILIA: tabla hecha con divs (grid) ---- */
async function cargarFamilia() {
  const tabla = document.querySelector("#tabla-familia");
  if (!tabla) return;
  try {
    const familiares = await pedirJSON("datos/familia.json");
    tabla.querySelectorAll(".celda").forEach((c) => c.remove());
    for (const f of familiares) {
      tabla.append(
        crear("div", f.familiar, "celda"),
        crear("div", f.descripcion, "celda"),
        crear("div", f.edad, "celda")
      );
    }
  } catch (err) {
    console.error(err);
    tabla.append(crear("div", "No se pudieron cargar los familiares", "error"));
  }
}

/* ---- Seccion AMIGOS ---- */
async function cargarAmigos() {
  const tbody = document.querySelector("#tabla-amigos");
  if (!tbody) return;
  try {
    const amigos = await pedirJSON("datos/amigos.json");
    tbody.replaceChildren();
    for (const a of amigos) {
      const fila = document.createElement("tr");
      fila.append(crear("td", a.nombre), crear("td", a.descripcion), crear("td", a.anio));
      tbody.append(fila);
    }
  } catch (err) {
    console.error(err);
    errorEnTabla(tbody, 3, "No se pudieron cargar los amigos");
  }
}

/* ---- Seccion CIUDAD: lista de datos curiosos ---- */
async function cargarDatosSucre() {
  const lista = document.querySelector("#datos-sucre");
  if (!lista) return;
  try {
    const datos = await pedirJSON("datos/sucre-datos.json");
    lista.replaceChildren(...datos.map((d) => crear("li", d)));
  } catch (err) {
    console.error(err);
    lista.replaceChildren(crear("li", "No se pudieron cargar los datos", "error"));
  }
}

/* ---- Seccion HOBBIES: tabla con imagenes ---- */
async function cargarHobbies() {
  const tbody = document.querySelector("#tabla-hobbies");
  if (!tbody) return;
  try {
    const hobbies = await pedirJSON("datos/hobbies.json");
    tbody.replaceChildren();
    for (const h of hobbies) {
      const fila = document.createElement("tr");
      const tdImg = document.createElement("td");
      const img = document.createElement("img");
      img.src = h.imagen;
      img.alt = h.alt;
      tdImg.append(img);
      fila.append(crear("td", h.hobby), crear("td", h.descripcion), crear("td", h.frecuencia), tdImg);
      tbody.append(fila);
    }
  } catch (err) {
    console.error(err);
    errorEnTabla(tbody, 4, "No se pudieron cargar los hobbies");
  }
}

/* ============================================================
   3. FORMULARIOS  (fetch POST + JSON)
   ============================================================ */
function activarFormularios() {
  activarFormulario("#formMensaje", "#estadoMensaje", "mensaje");
  activarFormulario("#formConexion", "#estadoConexion", "conexion");
}

function activarFormulario(selForm, selEstado, tipo) {
  const form = document.querySelector(selForm);
  const estado = document.querySelector(selEstado);
  if (!form || !estado) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault(); // no recargar la pagina

    const btn = form.querySelector("button[type=submit]");
    const textoOriginal = btn.textContent;
    const datos = { ...Object.fromEntries(new FormData(form)), tipo };

    // Estado: enviando (boton desactivado, sin mensajes viejos)
    btn.disabled = true;
    btn.textContent = "Enviando...";
    estado.className = "";
    estado.textContent = "";

    try {
      const resp = await fetch("api/contacto.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(datos),
      });
      const resultado = await resp.json();

      if (!resp.ok || !resultado.exito) {
        throw new Error(resultado.error || `Error HTTP ${resp.status}`);
      }

      estado.className = "msg-ok";
      estado.textContent = "Enviado correctamente. Gracias!";
      form.reset();
    } catch (err) {
      estado.className = "msg-error";
      estado.textContent =
        err instanceof TypeError || err instanceof SyntaxError
          ? "No se pudo enviar (el servidor PHP no responde)."
          : err.message;
    } finally {
      // Siempre se restaura la interfaz
      btn.disabled = false;
      btn.textContent = textoOriginal;
    }
  });
}

/* ============================================================
   UTILIDADES
   ============================================================ */
function mostrarError(texto) {
  const p = document.createElement("p");
  p.className = "error";
  p.textContent = texto;
  contenido.replaceChildren(p);
}

function marcarActivo(nombre) {
  document.querySelectorAll("#menu a").forEach((a) => {
    a.classList.toggle("activo", a.dataset.seccion === nombre);
  });
}

function seccionDesdeURL() {
  return location.hash.slice(1) || "yo";
}

/* ============================================================
   ARRANQUE
   Los enlaces cambian el #hash; asi funcionan Atras/Adelante.
   ============================================================ */
window.addEventListener("hashchange", () => cargarSeccion(seccionDesdeURL()));
cargarSeccion(seccionDesdeURL());
