<?php
require_once 'db_config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotels.com Clone | Find Your Next Stay</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #003580;
            --primary-red: #d4111e;
            --accent-gold: #ffb700;
            --bg-light: #f5f5f5;
            --text-dark: #262626;
            --glass-bg: rgba(255, 255, 255, 0.9);
            --shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            background-image:
                linear-gradient(rgba(245, 245, 245, 0.95), rgba(245, 245, 245, 0.95)),
                url('https://www.transparenttextures.com/patterns/pinstriped-suit.png');
            /* Subtle texture */
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* Hero Section with Watermark Background */
        .hero {
            position: relative;
            height: 80vh;
            background: linear-gradient(rgba(0, 53, 128, 0.7), rgba(0, 53, 128, 0.8)),
                url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 20px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://icons.veryicon.com/png/o/business/icon-library-of-traditional-chinese-medicine-series/clay-pot.png') no-repeat;
            opacity: 0.05;
            background-position: bottom right;
            background-size: 300px;
            pointer-events: none;
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
            box-shadow: var(--shadow);
        }

        .logo {
            font-weight: 700;
            font-size: 28px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo span {
            color: var(--primary-red);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 25px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: var(--accent-gold);
        }

        .search-container {
            background: white;
            padding: 10px;
            border-radius: 15px;
            box-shadow: var(--shadow);
            display: flex;
            gap: 10px;
            max-width: 1000px;
            width: 90%;
            margin-top: -50px;
            z-index: 10;
            position: relative;
            transform: translateY(50%);
            border: 2px solid var(--accent-gold);
        }

        .search-item {
            flex: 1;
            padding: 10px 15px;
            border-right: 1px solid #ddd;
        }

        .search-item:last-child {
            border-right: none;
        }

        .search-item label {
            display: block;
            font-size: 12px;
            color: #666;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .search-item input,
        .search-item select {
            width: 100%;
            border: none;
            outline: none;
            font-size: 16px;
            font-weight: 500;
            background: transparent;
        }

        .search-btn {
            background: var(--primary-red);
            color: white;
            border: none;
            padding: 10px 40px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(212, 17, 30, 0.3);
        }

        .search-btn:hover {
            transform: scale(1.05);
            background: #b30e19;
        }

        .section-title {
            text-align: center;
            margin: 120px 0 40px;
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .destinations {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 0 50px 100px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dest-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .dest-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent-gold);
        }

        .dest-image {
            height: 250px;
            background-size: cover;
            background-position: center;
        }

        .dest-info {
            padding: 20px;
        }

        .dest-info h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--primary-blue);
        }

        .dest-info p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .price-badge {
            background: var(--primary-blue);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .currency-toggle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: white;
            padding: 10px 20px;
            border-radius: 30px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 100;
            border: 1px solid var(--accent-gold);
        }

        /* Smooth scroll & responsive */
        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
            }

            .search-container {
                flex-direction: column;
                margin-top: -100px;
            }

            .search-item {
                border-right: none;
                border-bottom: 1px solid #ddd;
            }

            .hero h1 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

    <header>
        <a href="index.php" class="logo">Hotels<span>.com</span></a>
        <nav>
            <ul>
                <li><a href="hotels.php">Explore</a></li>
                <li><a href="hotels.php?type=Resort">Resorts</a></li>
                <li><a href="login.php">Sign In</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <h1>Find your next luxury stay</h1>
        <p>Explore unique destinations and historical wonders across Dubai and beyond.</p>

        <form action="hotels.php" method="GET" class="search-container" id="searchForm">
            <div class="search-item">
                <label>Where to?</label>
                <input type="text" name="location" placeholder="e.g. Palm Jumeirah" required>
            </div>
            <div class="search-item">
                <label>Check-in</label>
                <input type="date" name="check_in" required>
            </div>
            <div class="search-item">
                <label>Check-out</label>
                <input type="date" name="check_out" required>
            </div>
            <div class="search-item">
                <label>Guests</label>
                <select name="guests">
                    <option value="1">1 Guest</option>
                    <option value="2" selected>2 Guests</option>
                    <option value="3">3 Guests</option>
                    <option value="4">4 Guests</option>
                </select>
            </div>
            <button type="submit" class="search-btn">Search</button>
        </form>
    </section>

    <h2 class="section-title">Featured Destinations</h2>
    <div class="destinations">
        <div class="dest-card" onclick="window.location.href='hotels.php?location=Palm Jumeirah'">
            <div class="dest-image"
                style="background-image: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=800&q=80')">
            </div>
            <div class="dest-info">
                <h3>Palm Jumeirah, Dubai</h3>
                <p>The world's most iconic man-made island, home to luxury resorts like Atlantis The Royal.</p>
                <span class="price-badge">From $450 / night</span>
            </div>
        </div>
        <div class="dest-card" onclick="window.location.href='hotels.php?location=Downtown'">
            <div class="dest-image"
                style="background-image: url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80')">
            </div>
            <div class="dest-info">
                <h3>Downtown Dubai</h3>
                <p>Heart of the city with the Burj Khalifa, massive malls, and stunning fountains.</p>
                <span class="price-badge">From $250 / night</span>
            </div>
        </div>
        <div class="dest-card" onclick="window.location.href='hotels.php?location=Desert'">
            <div class="dest-image"
                style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80')">
            </div>
            <div class="dest-info">
                <h3>Desert Retreats</h3>
                <p>Escape to the golden dunes of the Arabian desert for a historical hospitality experience.</p>
                <span class="price-badge">From $380 / night</span>
            </div>
        </div>
    </div>

    <div class="currency-toggle" id="currencyToggle">
        <strong>Currency:</strong>
        <span id="currVal">USD ($)</span>
        <button onclick="toggleCurrency()"
            style="background: var(--primary-red); color: white; border: none; padding: 5px 10px; border-radius: 15px; cursor: pointer; font-size: 12px;">Switch</button>
    </div>

    <script>
        let currentCurrency = 'USD';
        function toggleCurrency() {
            currentCurrency = currentCurrency === 'USD' ? 'AED' : 'USD';
            document.getElementById('currVal').innerText = currentCurrency === 'USD' ? 'USD ($)' : 'AED (د.إ)';
            // In a real app, this would refresh prices on the page
        }

        // JS for redirection as requested
        document.getElementById('searchForm').onsubmit = function (e) {
            // Re-routing logic can be handled by PHP action, 
            // but we can add JS enhancements here if needed.
        }
    </script>
</body>

</html>
