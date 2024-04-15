//Agregar evento para el DOM
document.addEventListener("DOMContentLoaded", function () {
  //Llamado de todas las funciones
  botonMesa();
  mostrarAlertaExito();
  activarBotonEditarPersonal();
  activarBotonEliminarPersonal();
  mostrarOcultarCampo();
});

function botonMesa() {
  //Seleccionar botones
  const botonesRojo = document.querySelectorAll(".boton-rojo");
  const botonesVerde = document.querySelectorAll(".boton-verde");
  botonesRojo.forEach((boton) => {
    boton.addEventListener("click", function () {
      const seccion = boton.closest(".mesas-seccion");

      //Si no contiene la clase mesas-seccion-rojo agregarla
      if (!seccion.classList.contains("mesas-seccion-rojo")) {
        seccion.classList.add("mesas-seccion-rojo");
      }
    });
  });

  botonesVerde.forEach((botonVerde) => {
    //Seleccionar boton verde
    botonVerde.addEventListener("click", function () {
      const seccion = botonVerde.closest(".mesas-seccion");

      //Si tiene la clase mesas-seccion-rojo eliminarla y agregar la clase mesas-seccion
      if (seccion.classList.contains("mesas-seccion-rojo")) {
        seccion.classList.remove("mesas-seccion-rojo");
        seccion.classList.add("mesas-seccion");
      }
    });
  });
}

function mostrarAlertaExito() {
  const alertaExito = document.querySelector(".alerta.exito");
  if (alertaExito) {
    alertaExito.style.display = "block"; // Mostrar la alerta

    // Eliminar la alerta despues de 3 segundos
    setTimeout(function () {
      alertaExito.style.display = "none";
    }, 3000);
  }
}

function activarBotonEditarPersonal() {
  //Seleccionar botones
  const botonesEditarPersonal = document.querySelectorAll(".personal-editar");

  botonesEditarPersonal.forEach((boton) => {
    boton.addEventListener("click", function () {
      // Obtener el id del personal desde el botón
      const idPersonal = boton.dataset.id;

      if (idPersonal) {
        // Redireccionar a editar-personal.php con el id del personal
        window.location.href = `editar-personal.php?id=${idPersonal}`;
      } else {
        console.error("No se encontró el id del personal");
      }
    });
  });
}

function activarBotonEliminarPersonal() {
  //Seleccionar botones
  const botonesEliminarPersonal = document.querySelectorAll(".personal-borrar");

  botonesEliminarPersonal.forEach((boton) => {
    boton.addEventListener("click", function () {
      // Obtener el id del personal desde el botón
      const idPersonal = boton.dataset.id;

      if (idPersonal) {
        // Redireccionar a editar-personal.php con el id del personal
        window.location.href = `borrar-personal.php?id=${idPersonal}`;
      } else {
        console.error("No se encontró el id del personal");
      }
    });
  });
}

function mostrarOcultarCampo() {
  const rol = document.getElementById("rol");

  if (rol) {
    rol.addEventListener("change", () => {
      const valor = rol.value;
      let campoMesero = document.querySelector(".campoMesero");

      if (valor === "Mesero") {
        if (campoMesero) {
          campoMesero.classList.remove("campoMesero");
          campoMesero.classList.add("campoMeseroVista");
        }
      }
    });
  }
}


// Obtener todos los checkboxes
const checkboxes = document.querySelectorAll('.check');

// Agregar un evento de clic a cada checkbox
checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('click', ocultarContenedorTemporalmente);
});

// Función para ocultar el contenedor temporalmente al hacer clic en el checkbox
function ocultarContenedorTemporalmente(event) {
    const contenedor = event.target.parentNode;
    if (event.target.checked) {
        contenedor.style.display = 'none';
        // Esperar 5 segundos 
        setTimeout(() => {
            contenedor.remove();
        }, 5000);
    }
}
