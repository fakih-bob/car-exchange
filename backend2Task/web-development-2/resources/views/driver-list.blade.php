<!DOCTYPE html>
<html>
<head>
    <title>Driver List</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
        }

        .driver-list-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 1rem;
        }

        .page-heading {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 2rem;
        }

        .error-message {
            color: #dc2626;
            text-align: center;
            margin-bottom: 1rem;
            font-weight: bold;
        }

        .driver-card {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.25rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .driver-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .driver-card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .driver-card-description {
            font-size: 1rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }

        .driver-card-link {
            display: inline-block;
            color: #2563eb;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 1rem;
        }

        .driver-card-link:hover {
            text-decoration: underline;
        }

        .request-delivery-btn {
            background-color: #10b981;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .request-delivery-btn:hover {
            background-color: #059669;
        }

        .request-delivery-btn[disabled] {
            background-color: #9ca3af;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="driver-list-container">
        <h2 class="page-heading">Driver List</h2>
        <div id="error" class="error-message"></div>
        <div id="driver-list" class="space-y-4"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", async () => {
        const driverListContainer = document.getElementById("driver-list");
        const errorContainer = document.getElementById("error");
        const token = localStorage.getItem("token");

        try {
            const res = await axios.get("/api/AllDrivers", {
                headers: { Authorization: `Bearer ${token}` }
            });

            const orderId = localStorage.getItem("orderId");

            res.data.data.forEach(driver => {
                const card = document.createElement("div");
                card.className = "driver-card";

                const isAvailable = driver.driver && driver.driver.status === 'available'; // safe check

                card.innerHTML = `
                    <h3 class="driver-card-title">${driver.name}</h3>
                    <p class="driver-card-description">${driver.email}</p>
                    <a href="/drivers/${driver.id}" class="driver-card-link">View Reviews & Rating</a>
                    <button 
                        onclick="requestDelivery(${driver.id})" 
                        class="request-delivery-btn" 
                        ${!isAvailable ? 'disabled' : ''}
                    >
                        ${isAvailable ? 'Request Delivery' : 'Unavailable'}
                    </button>
                `;
                driverListContainer.appendChild(card);
            });
        } catch (error) {
            errorContainer.textContent = "Failed to load drivers.";
        }
    });

    async function requestDelivery(driverId) {
        const token = localStorage.getItem("token");
        const orderId = localStorage.getItem("orderId");

        if (!orderId) {
            document.getElementById("error").textContent = "You should create an order";
            return;
        }

        try {
            const res = await axios.post("http://localhost:8000/api/request-delivery", {
                order_id: orderId,
                driver_id: driverId
            }, {
                headers: { Authorization: `Bearer ${token}` }
            });

            alert("Delivery requested successfully!");
        } catch (err) {
            alert("You should create an order");
        }
    }
    </script>
</body>
</html>
