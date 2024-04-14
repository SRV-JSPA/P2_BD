document.addEventListener("DOMContentLoaded", function () {
    formatoFecha();
  });

function formatoFecha (){
    const input = document.getElementById('fecha');
  
    input.addEventListener('change', () => {
      const valor = input.value;
      console.log(valor);
    })
  }