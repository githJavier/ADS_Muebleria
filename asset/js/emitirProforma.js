let selectedProducts = [];

// Función para mostrar u ocultar el modal
function toggleModal() {
    const modal = document.getElementById('productModal');
    const productListBody = document.getElementById('product-list-body');
    const productListHeader = document.getElementById('product-list-header');

    // Verificamos si hay productos seleccionados
    if (selectedProducts.length === 0) {
        productListBody.innerHTML = '<tr><td colspan="5" class="text-center">Lista Vacía.</td></tr>';
        productListHeader.innerHTML = '';  // Ocultar encabezado si no hay productos
    } else {
        updateProductList();
        // Mostrar encabezado solo si hay productos
        productListHeader.innerHTML = `
            <tr>
                <th class="p-3">Código</th>
                <th class="p-3">Producto</th>
                <th class="p-3">Precio</th>
                <th class="p-3">Cantidad</th>
            </tr>
        `;
    }

    modal.classList.toggle('hidden');
}

// Función para agregar productos a la lista
function addProductToList(event, id, code, name, price) {
    event.preventDefault();
    const quantity = document.getElementById('quantity-' + id).value;
    if (quantity === 'Agotado') {
        alert('El producto está agotado.');
        return;
    }

    // Verificar si el producto ya está en la lista
    const existingProduct = selectedProducts.find(product => product.id === id);
    if (existingProduct) {
        alert('Este producto ya fue agregado.');
        return;
    }

    // Agregar el producto al array temporal
    selectedProducts.push({ id, code, name, price, quantity });

    alert(`${name} ha sido agregado a la lista.`);
    updateProductList();
}

// Función para actualizar la lista de productos seleccionados
function updateProductList() {
    const productListBody = document.getElementById('product-list-body');
    productListBody.innerHTML = '';

    selectedProducts.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="p-2">${product.code}</td>
            <td class="p-2">${product.name}</td>
            <td class="p-2">${product.price}</td>
            <td class="p-2">${product.quantity}</td>
        `;
        productListBody.appendChild(row);
    });
}

// Función para descartar la lista de productos
function discardList() {
    selectedProducts = [];
    updateProductList();
    toggleModal();
}

// Función para generar la proforma
function generateProforma() {
    if (selectedProducts.length === 0) {
        alert('No hay productos seleccionados.');
        return;
    }

    // Aquí puedes agregar la lógica para generar la proforma (enviar los productos al servidor)
    alert('Proforma generada con éxito.');
}
