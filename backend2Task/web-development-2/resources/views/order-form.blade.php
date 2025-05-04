<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Order</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }

        .form-container {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .product-group {
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 10px;
            border-radius: 5px;
        }

        button {
            background: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background: #0056b3;
        }

        .remove-btn {
            background: #dc3545;
            margin-top: 10px;
        }

        .remove-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Create Order</h2>
    <form id="orderForm">
        <div class="form-group">
            <label for="distance">Distance (km)</label>
            <input type="number" name="distance" id="distance" required min="0" step="0.1">
        </div>

        <div id="productsContainer">
            <!-- Products will be added here -->
        </div>

        <button type="button" onclick="addProduct()">Add Product</button>
        <button type="submit">Submit Order</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    let productIndex = 0;

    function addProduct() {
        const container = document.getElementById('productsContainer');

        const productGroup = document.createElement('div');
        productGroup.className = 'product-group';
        productGroup.innerHTML = `
            <h4>Product ${productIndex + 1}</h4>
            <div class="form-group">
                <label>Weight</label>
                <input type="number" name="products[${productIndex}][weight]" required>
            </div>
            <div class="form-group">
                <label>Height</label>
                <input type="number" name="products[${productIndex}][height]" required>
            </div>
            <div class="form-group">
                <label>Width</label>
                <input type="number" name="products[${productIndex}][width]" required>
            </div>
            <div class="form-group">
                <label>Urgency</label>
                <select name="products[${productIndex}][urgency]" required>
                    <option value="Standard">Standard</option>
                    <option value="Priority">Priority</option>
                    <option value="Urgent">Urgent</option>
                </select>
            </div>
            <button type="button" class="remove-btn" onclick="this.parentElement.remove()">Remove Product</button>
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
