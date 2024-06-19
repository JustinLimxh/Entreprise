document.addEventListener('DOMContentLoaded', () => {
    // Fetch and display products on page load
    fetchProducts();

    // Event listener for the add product form
    document.getElementById('addProductForm').addEventListener('submit', function(event) {
        event.preventDefault();
        addProduct();
    });

    // Event listener for the update product form
    document.getElementById('updateProductForm').addEventListener('submit', function(event) {
        event.preventDefault();
        updateProduct();
    });
});

// Fetch products from the server and display them
function fetchProducts() {
    fetch('process.php')
        .then(response => response.json())
        .then(data => {
            const productList = document.getElementById('productList');
            productList.innerHTML = '';
            data.forEach(product => {
                const imageUrl = `images/${product.image}`;
                productList.innerHTML += `
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img src="${imageUrl}" class="card-img-top" alt="${product.name}">
                            <div class="card-body">
                                <h5 class="card-title">${product.name}</h5>
                                <p class="card-text">${product.description}</p>
                                <p class="card-text"><strong>Price:</strong> $${product.price}</p>
                                <p class="card-text"><strong>Stock:</strong> ${product.stock}</p>
                                <button class="btn btn-primary" onclick="editProduct(${product.id}, '${product.name}', '${product.description}', '${product.image}', ${product.price}, ${product.stock})">Edit</button>
                                <button class="btn btn-danger" onclick="deleteProduct(${product.id})">Delete</button>
                                <button class="btn btn-warning" onclick="deductStock(${product.id})">Deduct Stock</button>
                            </div>
                        </div>
                    </div>
                `;
            });
        })
        .catch(error => console.error('Error fetching products:', error));
}

// Add a new product
function addProduct() {
    const form = document.getElementById('addProductForm');
    const formData = new FormData(form);

    fetch('process.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text())
      .then(data => {
          alert(data);
          form.reset();
          fetchProducts();
      })
      .catch(error => console.error('Error adding product:', error));
}

// Populate the update product modal with existing product data
function editProduct(id, name, description, image, price, stock) {
    document.getElementById('updateProductId').value = id;
    document.getElementById('updateName').value = name;
    document.getElementById('updateDescription').value = description;
    document.getElementById('updatePrice').value = price;
    document.getElementById('updateStock').value = stock;

    // Show the modal
    const updateProductModal = new bootstrap.Modal(document.getElementById('updateProductModal'));
    updateProductModal.show();
}

// Update an existing product
function updateProduct() {
    const form = document.getElementById('updateProductForm');
    const formData = new FormData(form);
    formData.append('update', true);

    fetch('process.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text())
      .then(data => {
          alert(data);
          fetchProducts();
          const updateProductModal = bootstrap.Modal.getInstance(document.getElementById('updateProductModal'));
          updateProductModal.hide();
      })
      .catch(error => console.error('Error updating product:', error));
}

// Delete a product
function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        const formData = new FormData();
        formData.append('delete', true);
        formData.append('productId', id);

        fetch('process.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text())
          .then(data => {
              alert(data);
              fetchProducts();
          })
          .catch(error => console.error('Error deleting product:', error));
    }
}

// Deduct stock from a product
function deductStock(id) {
    const quantity = prompt('Enter the quantity to deduct:');
    if (quantity != null && !isNaN(quantity) && quantity > 0) {
        const formData = new FormData();
        formData.append('deductStock', true);
        formData.append('productId', id);
        formData.append('quantity', quantity);

        fetch('process.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text())
          .then(data => {
              alert(data);
              fetchProducts();
          })
          .catch(error => console.error('Error deducting stock:', error));
    } else {
        alert('Please enter a valid quantity.');
    }
}

// Placeholder function for logout
function logout() {
    // Handle logout logic, e.g., redirect to login page
    alert('Logged out');
    window.location.href = 'login.php'; // Example redirect, modify as needed
}
