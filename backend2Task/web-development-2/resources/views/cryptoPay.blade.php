<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Payment</title>
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

<h2>Make Crypto Payment</h2>

<div class="payment-section">
    <form id="cryptoPaymentForm" class="crypto-form">
        <label for="cryptoCurrency">Cryptocurrency</label>
        <input type="text" id="cryptoCurrency" name="currency" placeholder="Enter cryptocurrency (e.g., BTC)" required><br><br>
        <label for="cryptoAmount">Amount</label>
        <input type="number" id="cryptoAmount" name="amount" readonly><br><br>
        <button type="submit" class="btn">Pay with Crypto</button>
    </form>
</div>

<script>
    // Function to get URL parameters (orderId, amount, currency)
    function getQueryParams() {
        const urlParams = new URLSearchParams(window.location.search);
        return {
            orderId: urlParams.get('orderId'),
            amount: urlParams.get('amount'),
            currency: urlParams.get('currency')
        };
    }

    const { orderId, amount, currency } = getQueryParams();

    // Check if the parameters are present
    if (!orderId || !amount || !currency) {
        alert('Invalid payment details.');
        window.location.href = '/'; // Redirect to the home page if details are missing
    }

    // Pre-fill the amount and currency fields
    document.getElementById('cryptoAmount').value = amount;
    document.getElementById('cryptoCurrency').value = currency;

    // Handle the crypto payment form submission
    document.getElementById('cryptoPaymentForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const cryptoCurrency = document.getElementById('cryptoCurrency').value;
        const cryptoAmount = document.getElementById('cryptoAmount').value;

        if (!cryptoCurrency || !cryptoAmount) {
            alert('Please enter a valid cryptocurrency and amount.');
            return;
        }

        const token = localStorage.getItem('token');
        if (!token) {
            alert('You are not authenticated. Please log in.');
            return;
        }

        try {
            const response = await fetch("/api/crypto-payment", {
                method: "POST",
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    orderId: orderId,
                    amount: cryptoAmount,
                    currency: cryptoCurrency
                })
            });

            const data = await response.json();
            if (data.success) {
                alert("Payment successful!");
                window.location.href = '/payment-success';  // Redirect to a success page
            } else {
                alert('Failed to process payment. Please try again.');
            }
        } catch (error) {
            console.error(error);
            alert('An error occurred. Please try again.');
        }
    });
</script>

</body>
</html>
