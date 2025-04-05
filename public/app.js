document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll(".producto-check");
    const inputProductos = document.getElementById("productos");

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            const cantidadInput = this.parentElement.querySelector(".producto-cantidad");
            cantidadInput.disabled = !this.checked;
        });
    });

    document.querySelector("form").addEventListener("submit", function(e) {
        let productosSeleccionados = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const id = checkbox.getAttribute("data-id");
                const precio = parseFloat(checkbox.getAttribute("data-precio"));
                const cantidad = parseInt(checkbox.parentElement.querySelector(".producto-cantidad").value);
                productosSeleccionados.push({ id, precio, cantidad });
            }
        });

        inputProductos.value = JSON.stringify(productosSeleccionados);
    });
});
