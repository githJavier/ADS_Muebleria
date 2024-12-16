let selectedProducts = [];

// Mostrar u ocultar el modal
function toggleModal() {
    const modal = document.getElementById('productModal');
    const productListBody = document.getElementById('product-list-body');

    if (productListBody.children.length === 0 && selectedProducts.length === 0) {
        productListBody.innerHTML = '<tr><td colspan="4" class="text-center">Lista Vacía.</td></tr>';
    } else {
        updateProductList();
    }
    modal.classList.toggle('hidden');
}

// Actualizar la cantidad de productos
function updateQuantity(event, id, stock) {
    const inputField = document.getElementById('quantity-' + id);
    let currentQuantity = parseInt(inputField.value, 10) || 1;

    if (event.target.classList.contains('increase') && currentQuantity < stock) {
        inputField.value = currentQuantity + 1;
    } else if (event.target.classList.contains('decrease') && currentQuantity > 1) {
        inputField.value = currentQuantity - 1;
    }
}

// Agregar productos seleccionados a la lista
function addProductToList(event, id, code, name, price) {
    event.preventDefault();
    const quantity = parseInt(document.getElementById('quantity-' + id).value, 10) || 1;

    if (quantity <= 0) {
        alert('Cantidad no válida.');
        return;
    }

    const existingProduct = selectedProducts.find(product => product.id === id);
    if (existingProduct) {
        alert('Este producto ya fue agregado.');
        return;
    }

    selectedProducts.push({ id, code, name, price, quantity });
    alert(`${name} ha sido agregado a la lista.`);
    updateProductList();
}

// Actualizar la lista visual de productos seleccionados
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

// Descartar la lista de productos seleccionados
function discardList() {
    selectedProducts = [];
    updateProductList();
    toggleModal();
}

// Generar proforma al enviar el formulario
document.getElementById('proformaForm').addEventListener('submit', function (event) {
    if (selectedProducts.length === 0) {
        event.preventDefault();
        alert('No hay productos seleccionados.');
        return;
    }

    const selectedProductsInput = document.getElementById('selectedProductsInput');
    selectedProductsInput.value = JSON.stringify(selectedProducts);
});
