document.addEventListener("DOMContentLoaded", function() {
    // Mensaje de bienvenida en consola
    console.log("Plataforma PapeleriaJR cargada correctamente.");

    // Botón de alerta en compras
    let alertButton = document.getElementById("alertaCompra");
    if (alertButton) {
        alertButton.addEventListener("click", function() {
            alert("¡Compra realizada con éxito!");
        });
    }

    // Actualizar cantidad en carrito
    let cantidadInputs = document.querySelectorAll(".cantidad");
    cantidadInputs.forEach(input => {
        input.addEventListener("change", function() {
            let precio = parseFloat(this.getAttribute("data-precio"));
            let cantidad = parseInt(this.value);
            let total = precio * cantidad;
            let totalElement = document.getElementById("total-" + this.dataset.id);
            totalElement.innerText = "$" + total.toFixed(2);
        });
    });
});
