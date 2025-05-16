<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Driver Details</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9fafb;
            color: #1f2937;
            display: flex;
            justify-content: center;
            padding: 40px;
        }

        .driver-details-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
            padding: 2rem;
            width: 100%;
            max-width: 600px;
        }

        .driver-details-title {
            font-size: 1.75rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-align: center;
        }

        .driver-info {
            margin-bottom: 1rem;
        }

        .label {
            font-weight: 600;
            color: #374151;
        }

        .value {
            color: #6b7280;
        }

        .back-btn {
            display: block;
            margin-top: 2rem;
            text-align: center;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }

        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="driver-details-card" id="driver-details">
        <h2 class="driver-details-title">Driver Details</h2>
        <!-- JS will inject content here -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const urlParams = new URLSearchParams(window.location.search);
            const driverId = urlParams.get('id');
            const token = localStorage.getItem('token');
            const container = document.getElementById("driver-details");

            try {
                const res = await axios.get(`http://localhost:8000/api/GetDriverDetails/${driverId}`, {
                    headers: { Authorization: `Bearer ${token}` }
                });

                const d = res.data.data;

                const formatLine = (label, value) => `
                    <div class="driver-info">
                        <span class="label">${label}: </span>
                        <span class="value">${value ?? 'N/A'}</span>
                    </div>
                `;

                container.innerHTML += `
                    ${formatLine("Plate Number", d.plate_number)}
                    ${formatLine("Vehicle Type", d.vehicle_type)}
                    ${formatLine("License Number", d.license_number)}
                    ${formatLine("License Expiry", d.license_expiry)}
                    ${formatLine("Status", d.status)}
                    ${formatLine("Shift Start", d.shift_start)}
                    ${formatLine("Shift End", d.shift_end)}
                    ${formatLine("Working Area", d.working_area)}
                    ${formatLine("Verified", d.verified ? 'Yes' : 'No')}
                    <a href="/drivers" class="back-btn">← Back to List</a>
                `;
            } catch (err) {
                container.innerHTML += `<div class="driver-info"><span class="label">Error:</span> <span class="value">Unable to fetch driver details.</span></div>`;
            }
        });
    </script>
</body>
</html>
