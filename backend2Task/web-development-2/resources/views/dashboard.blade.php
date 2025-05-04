<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="{{ asset('css/Login.css') }}" rel="stylesheet"> <!-- Optional: style reuse -->
    <style>
        .dashboard-container {
            text-align: center;
            margin-top: 100px;
        }
        .dashboard-btn {
            margin: 20px;
            padding: 15px 30px;
            font-size: 16px;
            background-color: #3490dc;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .dashboard-btn:hover {
            background-color: #2779bd;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome to the Dashboard</h1>
        <button onclick="goToDrivers()" class="dashboard-btn">View Drivers</button>
        <button onclick="goToOrderForm()" class="dashboard-btn">Create Order</button>
        <button onclick="goToOrders()" class="dashboard-btn">Show Orders</button>
    </div>

    <script>
        function goToDrivers() {
            window.location.href = "/drivers";
        }

        function goToOrderForm() {
            window.location.href = "/order-form";
        }

        function goToOrders() {
            window.location.href = "/OrderStatus";
        }
    </script>
</body>
</html>
