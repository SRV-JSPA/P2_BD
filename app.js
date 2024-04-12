document.addEventListener("DOMContentLoaded", function (){
    botonMesa();
    mostrarAlertaExito();
})


function botonMesa (){
    const botonesRojo = document.querySelectorAll(".boton-rojo");
    const botonesVerde = document.querySelectorAll(".boton-verde");
    botonesRojo.forEach(boton => {
        boton.addEventListener("click", function() {
            const seccion = boton.closest(".mesas-seccion");

            if (!seccion.classList.contains("mesas-seccion-rojo")) {
                seccion.classList.add("mesas-seccion-rojo");
            } 
            
        });
    });

    botonesVerde.forEach(botonVerde => {
        botonVerde.addEventListener("click", function() {
            const seccion = botonVerde.closest(".mesas-seccion");

            if (seccion.classList.contains("mesas-seccion-rojo")) {
                seccion.classList.remove("mesas-seccion-rojo");
                seccion.classList.add("mesas-seccion");
            }
        });
    });
}

function mostrarAlertaExito() {
    const alertaExito = document.querySelector('.alerta.exito');
    if (alertaExito) {
        alertaExito.style.display = 'block'; // Mostrar la alerta

        setTimeout(function() {
            alertaExito.style.display = 'none';
        }, 3000);
    }
}

