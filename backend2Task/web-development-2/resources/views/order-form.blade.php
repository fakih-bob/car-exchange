<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Order</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 25px;
            color: #343a40;
        }

        .product-group {
            border: 1px solid #dee2e6;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            background: #fdfdfd;
        }

        .remove-btn {
            background-color: #dc3545;
            color: #fff;
        }

        .remove-btn:hover {
            background-color: #c82333;
        }

        .add-btn {
            margin-bottom: 15px;
        }

        .btn-primary,
        .btn-success {
            padding: 10px 24px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card mx-auto" style="max-width: 900px;">
            <h2 class="form-title text-center">🚚 Create New Order</h2>
            <form id="orderForm">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="distance" class="form-label fw-semibold">Distance (km)</label>
                        <input type="number" class="form-control" id="distance" name="distance" required min="0" step="0.1">
                    </div>
                </div>

                <div id="productsContainer">
                    <!-- Product cards will appear here -->
                </div>

                <div class="d-flex gap-3">
                    <button type="button" onclick="addProduct()" class="btn btn-outline-secondary add-btn">
                        ➕ Add Product
                    </button>
                    <button type="submit" class="btn btn-primary">✅ Submit Order</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let productIndex = 0;

        function addProduct() {
            const container = document.getElementById('productsContainer');

            const productGroup = document.createElement('div');
            productGroup.className = 'product-group';
            productGroup.innerHTML = `
                <div class="row mb-2">
                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">📦 Product ${productIndex + 1}</h5>
                        <button type="button" class="btn remove-btn btn-sm" onclick="this.closest('.product-group').remove()">Remove</button>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" name="products[${productIndex}][weight]" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Height (cm)</label>
                        <input type="number" name="products[${productIndex}][height]" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Width (cm)</label>
                        <input type="number" name="products[${productIndex}][width]" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Urgency</label>
                        <select name="products[${productIndex}][urgency]" class="form-select" required>
                            <option value="">Choose...</option>
                            <option value="Standard">Standard</option>
                            <option value="Priority">Priority</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                </div>
            `;
            container.appendChild(productGroup);
            productIndex++;
        }

        document.getElementById('orderForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const json = {
                distance: parseFloat(formData.get('distance')),
                products: []
            };

            for (let i = 0; i < productIndex; i++) {
                const weight = formData.get(`products[${i}][weight]`);
                const height = formData.get(`products[${i}][height]`);
                const width = formData.get(`products[${i}][width]`);
                const urgency = formData.get(`products[${i}][urgency]`);

                if (weight && height && width && urgency) {
                    json.products.push({ weight, height, width, urgency });
                }
            }

            try {
                const token = localStorage.getItem('token');

                const response = await axios.post('/api/orders', json, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                const orderId = response.data.order.id;
                localStorage.setItem("orderId", orderId);
                window.location.href = "/drivers";

            } catch (error) {
                console.error(error);
                alert('Error: ' + (error.response?.data?.message || 'Something went wrong.'));
            }
        });
    </script>
</body>
</html>
