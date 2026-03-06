<?php
require_once 'db_config.php';
session_start();

$conn = getDB();
$booking_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$sql = "SELECT b.*, h.name as hotel_name, h.location, h.main_image 
        FROM bookings b 
        JOIN hotels h ON b.hotel_id = h.id 
        WHERE b.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed | Hotels.com Clone</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #003580;
            --primary-red: #d4111e;
            --accent-gold: #ffb700;
            --bg-light: #f5f5f5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .conf-card {
            background: white;
            max-width: 600px;
            width: 100%;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            position: relative;
            animation: fadeIn 0.8s ease-out;
        }

        /* Shining Border Effect */
        .conf-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary-blue), var(--accent-gold), var(--primary-red), var(--primary-blue));
            z-index: -1;
            border-radius: 32px;
            animation: shine 3s linear infinite;
            background-size: 400%;
        }

        @keyframes shine {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header-msg {
            background: var(--primary-blue);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header-msg h1 {
            margin-bottom: 10px;
            font-size: 32px;
        }

        .success-icon {
            font-size: 60px;
            margin-bottom: 20px;
            color: var(--accent-gold);
        }

        .conf-body {
            padding: 40px;
        }

        .booking-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #ddd;
        }

        .label {
            font-weight: 600;
            color: #666;
        }

        .value {
            font-weight: 700;
            color: var(--primary-blue);
        }

        .total-box {
            background: #fdf2f3;
            padding: 20px;
            border-radius: 15px;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-box span {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary-red);
        }

        .btn-group {
            margin-top: 40px;
            display: flex;
            gap: 15px;
        }

        .btn {
            flex: 1;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-primary {
            background: var(--primary-blue);
            color: white;
        }

        .btn-outline {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
        }

        .btn:hover {
            transform: scale(1.02);
            opacity: 0.9;
        }

        .watermark {
            position: absolute;
            bottom: 10px;
            right: 15px;
            opacity: 0.05;
            font-size: 80px;
            pointer-events: none;
        }
    </style>
</head>

<body>

    <div class="conf-card">
        <div class="header-msg">
            <div class="success-icon">✔</div>
            <h1>Booking Confirmed!</h1>
            <p>Your reservation at
                <?php echo $booking['hotel_name']; ?> is secured.
            </p>
        </div>

        <div class="conf-body">
            <div class="booking-item">
                <span class="label">Booking ID</span>
                <span class="value">#
                    <?php echo str_pad($booking['id'], 6, '0', STR_PAD_LEFT); ?>
                </span>
            </div>
            <div class="booking-item">
                <span class="label">Check-in</span>
                <span class="value">
                    <?php echo date('M d, Y', strtotime($booking['check_in'])); ?>
                </span>
            </div>
            <div class="booking-item">
                <span class="label">Check-out</span>
                <span class="value">
                    <?php echo date('M d, Y', strtotime($booking['check_out'])); ?>
                </span>
            </div>
            <div class="booking-item">
                <span class="label">Guests</span>
                <span class="value">
                    <?php echo $booking['guests']; ?> Adults
                </span>
            </div>
            <div class="booking-item">
                <span class="label">Location</span>
                <span class="value">
                    <?php echo $booking['location']; ?>
                </span>
            </div>

            <div class="total-box">
                <span style="font-size: 16px; color: #666; font-weight: 600;">Total Price</span>
                <span>$
                    <?php echo number_format($booking['total_price'], 2); ?>
                </span>
            </div>

            <div class="btn-group">
                <a href="index.php" class="btn btn-primary">Home</a>
                <a href="javascript:window.print()" class="btn btn-outline">Print Receipt</a>
            </div>
        </div>

        <div class="watermark">🏺</div>
    </div>

</body>

</html>
<?php $conn->close(); ?>
