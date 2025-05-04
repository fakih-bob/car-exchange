<!DOCTYPE html>
<html>
<head>
    <title>Driver Detail</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            color: #333;
        }

        .driver-detail-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            transition: box-shadow 0.3s ease-in-out;
        }

        .driver-detail-container:hover {
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }

        .page-heading {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }

        .driver-detail-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2980b9;
        }

        .driver-review-section {
            margin-top: 20px;
        }

        .driver-review-section h4 {
            font-size: 1.2rem;
            color: #34495e;
            margin-bottom: 10px;
        }

        .review-card {
            background-color: #f1f5f9;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            border-left: 5px solid #2980b9;
            transition: transform 0.2s;
        }

        .review-card:hover {
            transform: translateY(-3px);
            background-color: #e9f1fb;
        }

        .review-card-text {
            font-size: 1rem;
            font-style: italic;
            color: #555;
            margin-bottom: 8px;
        }

        .review-card-rating {
            font-weight: bold;
            color: #2c3e50;
        }

        .review-card-client {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .error-message {
            text-align: center;
            font-size: 1.2rem;
            color: #e74c3c;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="driver-detail-container">
        <h2 class="page-heading" id="driver-name">Driver Reviews</h2>
        <div class="driver-detail-card">
            <h3 class="driver-detail-title" id="driver-rating">Rating: </h3>
            <div class="driver-review-section">
                <h4 class="text-xl font-semibold">Reviews:</h4>
                <div id="reviews"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", async () => {
        const pathParts = window.location.pathname.split("/");
        const driverId = pathParts[pathParts.length - 1];
        const token = localStorage.getItem("token");

        try {
            const res = await axios.get(`http://localhost:8000/api/drivers/${driverId}`, {
                headers: { Authorization: `Bearer ${token}` }
            });

            const reviews = res.data.data;

            const driverName = reviews.length > 0 ? reviews[0].client.name : "Unknown Driver";
            document.getElementById("driver-name").textContent = `${driverName}'s Reviews & Rating`;

            const avgRating = reviews.length
                ? (reviews.reduce((sum, r) => sum + r.rating, 0) / reviews.length).toFixed(1)
                : "No Rating";
            document.getElementById("driver-rating").textContent = `Average Rating: ${avgRating}/5`;

            const reviewsContainer = document.getElementById("reviews");

            if (reviews.length > 0) {
                reviews.forEach(review => {
                    const card = document.createElement("div");
                    card.className = "review-card";
                    card.innerHTML = `
                        <p class="review-card-text">"${review.review}"</p>
                        <p class="review-card-rating">Rating: ${review.rating}</p>
                        <p class="review-card-client">By: ${review.client?.name || 'Unknown Client'}</p>
                    `;
                    reviewsContainer.appendChild(card);
                });
            } else {
                reviewsContainer.innerHTML = "<p>No reviews available yet.</p>";
            }
        } catch (err) {
            console.error('Error fetching driver reviews:', err);
            document.querySelector(".driver-detail-container").innerHTML = `<p class="error-message">Error loading driver details. Please try again later.</p>`;
        }
    });
    </script>
</body>
</html>
