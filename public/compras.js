document.addEventListener("DOMContentLoaded", () => {
    const carrito = [];
    const carritoContainer = document.createElement("div");
    carritoContainer.classList.add("carrito-container");
    document.body.appendChild(carritoContainer);

    function actualizarCarrito() {
        carritoContainer.innerHTML = "<h3>🛒 Carrito de Compras</h3>";
        let total = 0;

        if (carrito.length === 0) {
            carritoContainer.innerHTML += "<p>Tu carrito está vacío.</p>";
        } else {
            carrito.forEach((producto, index) => {
                carritoContainer.innerHTML += `
                    <p>
                        ${producto.nombre} - 💲${producto.precio.toFixed(2)} COP 
                        <button class="btn eliminar" data-index="${index}">❌</button>
                    </p>
                `;
                total += producto.precio;
            });

            carritoContainer.innerHTML += `<h4>Total: 💲${total.toFixed(2)} COP</h4>`;
            carritoContainer.innerHTML += `<button id="comprar">🛒 Finalizar Compra</button>`;
        }
    }

    document.querySelectorAll(".agregar-carrito").forEach(boton => {
        boton.addEventListener("click", (e) => {
            const id = e.target.dataset.id;
            const nombre = e.target.dataset.nombre;
            const precio = parseFloat(e.target.dataset.precio);

            carrito.push({ id, nombre, precio });
            actualizarCarrito();
        });
    });

    carritoContainer.addEventListener("click", (e) => {
        if (e.target.classList.contains("eliminar")) {
            const index = e.target.dataset.index;
            carrito.splice(index, 1);
            actualizarCarrito();
        }
    });

    document.body.addEventListener("click", (e) => {
        if (e.target.id === "comprar") {
            fetch("../controllers/procesar_compra.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "carrito=" + JSON.stringify(carrito),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("✅ Compra realizada con éxito");
                    location.reload();
                } else {
                    alert("❌ Error al procesar la compra");
                }
            });
        }
    });

    actualizarCarrito();
});
