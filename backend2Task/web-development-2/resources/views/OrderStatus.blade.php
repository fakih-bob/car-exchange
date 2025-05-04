<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Orders & Driver Review</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            position: relative;
        }

        .currency-dropdown-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .currency-dropdown {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: white;
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            appearance: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .currency-dropdown:hover {
            border-color: #007BFF;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .order {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .order h3 {
            margin: 0 0 10px;
        }

        .product {
            margin-left: 15px;
            padding-left: 10px;
            border-left: 3px solid #007BFF;
        }

        button {
            margin-top: 10px;
            padding: 8px 16px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        #reviewModal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        #reviewModal .modal-content {
            background: white;
            padding: 20px;
            margin: 100px auto;
            width: 300px;
            border-radius: 10px;
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        select {
            padding: 8px;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<h1>Your Orders</h1>

<div class="currency-dropdown-container">
    <label for="currencySelect" style="margin-right: 8px;">Currency:</label>
    <select id="currencySelect" class="currency-dropdown">
        <option value="USD">USD</option>
        <option value="EUR">EUR</option>
        <option value="GBP">GBP</option>
        <option value="INR">INR</option>
        <option value="AUD">AUD</option>
        <option value="CAD">CAD</option>
        <option value="LBP">LBP</option>
    </select>
</div>

<div id="orders-container"></div>

<div id="reviewModal">
    <div class="modal-content">
        <h3>Leave a Review</h3>
        <form id="reviewForm">
            <input type="hidden" id="driverIdInput" name="driver_id">
            <label>Rating (1–5):</label><br>
            <input type="number" name="rating" min="1" max="5" required><br><br>
            <label>Review:</label><br>
            <textarea name="review" rows="4" style="width:100%;"></textarea><br><br>
            <button type="submit">Submit Review</button>
            <button type="button" onclick="closeReviewModal()">Cancel</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const ordersContainer = document.getElementById('orders-container');
    const token = localStorage.getItem('token');
    const currencySelect = document.getElementById('currencySelect');
    let ordersData = [];

    async function fetchOrders() {
        try {
            const response = await axios.get('/api/AllMyOrders', {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            ordersData = response.data.orders;
            displayOrders();

        } catch (error) {
            console.error('Error fetching orders:', error);
        }
    }

    function displayOrders() {
        ordersContainer.innerHTML = '';

        let hasOrders = false;

        ordersData.forEach(order => {
            if (order.status.toLowerCase() === 'pending') return;

            hasOrders = true;

            const orderEl = document.createElement('div');
            orderEl.className = 'order';

            orderEl.innerHTML = `
                <h3>Order #${order.id}</h3>
                <p><strong>Status:</strong> ${order.status}</p>
                <p><strong>Scheduled:</strong> ${order.scheduled_at ?? 'Not scheduled'}</p>
                <p><strong>Paid:</strong> ${order.paid ? 'Yes' : 'No'}</p>
                <p><strong>Cost:</strong> 
                    <span class="cost" data-original-cost="${order.cost ?? 0}">
                        $${parseFloat(order.cost ?? 0).toFixed(2)}
                    </span>
                </p>
                <div>
                    <strong>Products:</strong>
                    ${order.products.map(product => `
                        <div class="product">
                            <p>Weight: ${product.weight}</p>
                            <p>Height: ${product.height}</p>
                            <p>Width: ${product.width}</p>
                            <p>Urgency: ${product.Urgency}</p>
                        </div>
                    `).join('')}
                </div>
                <p><strong>Driver:</strong> ${order.driver_id ? `${order.driver.name}` : 'Not assigned yet'}</p>
                ${order.driver_id ? `<button onclick="openReviewModal(${order.driver_id})">Leave a Review</button>` : ''}
                <button ${order.paid ? 'disabled' : ''} onclick="goToPayment(${order.id}, ${order.cost})">Pay Now</button>
            `;

            ordersContainer.appendChild(orderEl);
        });

        if (!hasOrders) {
            ordersContainer.innerHTML = "<p>No orders available yet.</p>";
        }

        updateOrderCosts();
    }

    function goToPayment(orderId, cost) {
        window.location.href = `/pay?orderId=${orderId}&amount=${cost}`;
    }

    function openReviewModal(driverId) {
        document.getElementById('reviewModal').style.display = 'block';
        document.getElementById('driverIdInput').value = driverId;
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').style.display = 'none';
        document.getElementById('reviewForm').reset();
    }

    document.getElementById('reviewForm').onsubmit = async function (e) {
        e.preventDefault();

        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await axios.post('/api/reviews', data, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            alert(response.data.message);
            closeReviewModal();
        } catch (error) {
            console.error('Review Error:', error);
            alert('Failed to submit review.');
        }
    };

    async function updateOrderCosts() {
        const selectedCurrency = currencySelect.value;

        const costElements = document.querySelectorAll('.cost');
        costElements.forEach(async costEl => {
            const originalCost = parseFloat(costEl.getAttribute('data-original-cost'));

            try {
                const response = await axios.post('/api/currency/convert', {
                    base_currency: 'USD',
                    target_currency: selectedCurrency,
                    amount: originalCost
                }, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.data.success) {
                    const convertedAmount = parseFloat(response.data.converted_amount).toFixed(2);
                    costEl.innerText = `${selectedCurrency} ${convertedAmount}`;
                } else {
                    console.error('Conversion failed:', response.data.message);
                }
            } catch (error) {
                console.error('Error converting currency:', error);
            }
        });
    }

    currencySelect.addEventListener('change', () => {
        updateOrderCosts();
    });

    fetchOrders();
</script>

</body>
</html>
