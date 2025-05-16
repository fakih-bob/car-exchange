<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Payment Method</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f5f5f5;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
        }

        .btn {
            padding: 12px 25px;
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .hidden {
            display: none;
        }

        .payment-section {
            margin-top: 30px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .crypto-form {
            margin-top: 20px;
        }

        .crypto-form input {
            padding: 10px;
            width: 200px;
            margin-right: 10px;
            font-size: 14px;
        }

        .crypto-form button {
            background-color: #555;
        }
    </style>
</head>
<body>

<h2>Choose Your Payment Method</h2>

<div class="payment-section">
    <button class="btn" onclick="selectPayment('cash')">Cash</button>
    <button class="btn" onclick="selectPayment('card')">Card</button>
    <button class="btn" onclick="selectPayment('crypto')">Crypto</button>

    <div id="cashMessage" class="hidden">
        <p><strong>Cash selected!</strong><br>No online payment required.</p>
    </div>

    <div id="cardForm" class="card-form hidden">
        <form id="stripeForm">
            <input type="text" id="productField" name="product" value="Order Payment" hidden>
            <input type="number" id="amountField" name="amount" value="0" hidden>
            <input type="number" id="orderIdField" name="order_id" value="0" hidden>
            <button type="submit" class="btn" style="background-color: #2196F3;" id="payBtn">Pay with Card</button>
        </form>
    </div>

    <div id="cryptoMessage" class="crypto-message hidden">
        <form id="cryptoForm" class="crypto-form" onsubmit="redirectToCrypto(event)">
            <input type="text" id="cryptoCurrency" name="currency" placeholder="Enter currency (e.g. BTC)" required>
            <input type="hidden" id="cryptoAmount" name="amount" value="0">
            <button type="submit" class="btn">Pay with Crypto</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
   function getQueryParams() {
    const urlParams = new URLSearchParams(window.location.search);
    const rawAmount = urlParams.get('amount');
    return {
        orderId: urlParams.get('orderId'),
        amount: rawAmount ? parseFloat(rawAmount) : 0,
        currency: urlParams.get('currency') || 'USD'
    };
}

    const { orderId, amount, currency } = getQueryParams();
    document.getElementById('amountField').value = amount;
    document.getElementById('orderIdField').value = orderId;
    document.getElementById('payBtn').innerText = `Pay ${(amount || 0).toFixed(2)} ${currency} with Card`;
    document.getElementById('cryptoAmount').value = amount;

    async function selectPayment(method) {
        const confirmed = confirm(`Are you sure you want to proceed with ${method.toUpperCase()} payment?`);
        if (!confirmed) return;

        try {
            const token = localStorage.getItem('token');
            await axios.post(`/api/orders/mark-paid/${orderId}`, {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            console.log(`Order ${orderId} marked as paid`);
        } catch (error) {
            alert('Failed to mark order as paid. Please try again.');
            console.error(error);
            return;
        }

        document.getElementById('cashMessage').classList.add('hidden');
        document.getElementById('cardForm').classList.add('hidden');
        document.getElementById('cryptoMessage').classList.add('hidden');

        if (method === 'cash') {
            document.getElementById('cashMessage').classList.remove('hidden');
        } else if (method === 'card') {
            document.getElementById('cardForm').classList.remove('hidden');
        } else if (method === 'crypto') {
            document.getElementById('cryptoMessage').classList.remove('hidden');
        }
    }

    async function redirectToCrypto(event) {
        event.preventDefault();
        const currencyInput = document.getElementById('cryptoCurrency').value.trim();
        const cost = parseFloat(document.getElementById('cryptoAmount').value) || 0;

        if (!currencyInput) {
            alert("Please enter a valid cryptocurrency.");
            return;
        }

        try {
            const token = localStorage.getItem('token');
            const response = await axios.post('/api/create-coinbase-charge', {
                amount: cost,
                currency: currencyInput,
                _token: '{{ csrf_token() }}'
            }, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (response.data.success) {
                window.location.href = response.data.hosted_url;
            } else {
                alert('Failed to create charge.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('You should put a real price .');
        }
    }

    document.getElementById('stripeForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const token = localStorage.getItem('token');

        try {
            const response = await fetch("{{ url('/api/create-checkout-session') }}", {
                method: "POST",
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product: 'Order Payment',
                    amount: parseInt(amount),
                    order_id: orderId
                })
            });

            const data = await response.json();
            if (data.url) {
                window.location.href = data.url;
            } else {
                alert("Something went wrong: " + (data.error || 'No URL returned'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while processing your payment.');
        }
    });
</script>

</body>
</html>
