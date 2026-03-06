<?php
require_once 'db_config.php';
session_start();

$conn = getDB();
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM hotels WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$hotel = $result->fetch_assoc();

if (!$hotel) {
    header("Location: hotels.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $hotel['name']; ?> | Hotels.com Clone
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #003580;
            --primary-red: #d4111e;
            --accent-gold: #ffb700;
            --bg-light: #f5f5f5;
            --text-dark: #262626;
            --shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            padding-top: 80px;
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            background: var(--primary-blue);
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .logo {
            font-weight: 700;
            font-size: 28px;
            color: white;
            text-decoration: none;
        }

        .logo span {
            color: var(--primary-red);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* Gallery */
        .gallery {
            display: grid;
            grid-template-columns: 2fr 1fr;
            grid-template-rows: repeat(2, 200px);
            gap: 10px;
            margin-bottom: 30px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .gallery-main {
            grid-row: span 2;
            background-size: cover;
            background-position: center;
        }

        .gallery-sub {
            background-size: cover;
            background-position: center;
        }

        /* Hotel Content */
        .content-wrap {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
        }

        .hotel-details h1 {
            color: var(--primary-blue);
            font-size: 36px;
            margin-bottom: 10px;
        }

        .location {
            color: #666;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .rating-badge {
            background: var(--primary-blue);
            color: white;
            padding: 8px 15px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 18px;
            width: fit-content;
        }

        .description {
            margin: 30px 0;
            line-height: 1.8;
            color: #444;
            font-size: 16px;
        }

        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .amenity-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            background: white;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #eee;
        }

        /* Booking Card */
        .booking-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            border: 2px solid var(--accent-gold);
            height: fit-content;
            position: sticky;
            top: 110px;
        }

        .price-tag {
            text-align: center;
            margin-bottom: 25px;
        }

        .price-usd {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-red);
        }

        .price-aed {
            font-size: 18px;
            color: #666;
            margin-top: 5px;
        }

        .book-form select,
        .book-form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .book-btn {
            width: 100%;
            background: var(--primary-red);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(212, 17, 30, 0.3);
        }

        .book-btn:hover {
            background: #b30e19;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .gallery {
                grid-template-columns: 1fr;
                grid-template-rows: 300px;
            }

            .content-wrap {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <header>
        <a href="index.php" class="logo">Hotels<span>.com</span></a>
        <a href="hotels.php" style="color: white; text-decoration: none; font-weight: 600;">← Back to results</a>
    </header>

    <div class="container">
        <div class="gallery">
            <div class="gallery-main" style="background-image: url('<?php echo $hotel['main_image']; ?>')"></div>
            <div class="gallery-sub"
                style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=400&q=80')">
            </div>
            <div class="gallery-sub"
                style="background-image: url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=400&q=80')">
            </div>
        </div>

        <div class="content-wrap">
            <div class="hotel-details">
                <div class="rating-badge">
                    <?php echo $hotel['rating']; ?> / 5
                </div>
                <h1>
                    <?php echo $hotel['name']; ?>
                </h1>
                <div class="location">
                    <span>📍
                        <?php echo $hotel['location']; ?>
                    </span>
                </div>

                <div class="description">
                    <p>
                        <?php echo $hotel['description']; ?>
                    </p>
                </div>

                <h3>Amenities</h3>
                <div class="amenities-grid">
                    <?php
                    $amenities = explode(',', $hotel['amenities']);
                    foreach ($amenities as $amenity) {
                        echo "<div class='amenity-item'>✨ " . trim($amenity) . "</div>";
                    }
                    ?>
                </div>

                <div
                    style="margin-top: 40px; padding: 30px; background: #fff; border-radius: 20px; box-shadow: var(--shadow);">
                    <h3>Historical Significance</h3>
                    <p style="color: #666; font-style: italic; margin-top: 10px;">
                        Inspired by the rich heritage of the UAE, this property blends ancient pottery aesthetics with
                        modern luxury,
                        offering a royal experience for travelers seeking authenticity.
                    </p>
                </div>
            </div>

            <!-- Booking Card -->
            <div class="booking-card">
                <div class="price-tag">
                    <div class="price-usd">$
                        <?php echo number_format($hotel['price_usd'], 0); ?> <span
                            style="font-size: 14px; color: #888;">/ night</span>
                    </div>
                    <div class="price-aed">Approx. AED
                        <?php echo number_format($hotel['price_aed'], 0); ?>
                    </div>
                </div>

                <form action="book.php" method="POST" class="book-form">
                    <input type="hidden" name="hotel_id" value="<?php echo $hotel['id']; ?>">
                    <input type="hidden" name="price_usd" value="<?php echo $hotel['price_usd']; ?>">

                    <label style="font-size: 13px; color: #666; font-weight: 600;">Check-in</label>
                    <input type="date" name="check_in" required value="<?php echo date('Y-m-d'); ?>">

                    <label style="font-size: 13px; color: #666; font-weight: 600;">Check-out</label>
                    <input type="date" name="check_out" required
                        value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">

                    <label style="font-size: 13px; color: #666; font-weight: 600;">Guests</label>
                    <select name="guests">
                        <option value="1">1 Adult</option>
                        <option value="2" selected>2 Adults</option>
                        <option value="3">3 Adults</option>
                        <option value="4">4 Adults</option>
                    </select>

                    <button type="submit" class="book-btn">Reserve Now</button>
                    <p style="text-align: center; font-size: 12px; color: #888; margin-top: 15px;">
                        No immediate payment required. Confirmation sent instantly.
                    </p>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
<?php $conn->close(); ?>
