<?php
require_once 'db_config.php';
session_start();

$conn = getDB();

// Get Search/Filter Params
$location = isset($_GET['location']) ? $_GET['location'] : '';
$hotel_type = isset($_GET['type']) ? $_GET['type'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'rating';

// Build Query
$sql = "SELECT * FROM hotels WHERE 1=1";
if ($location) {
    $sql .= " AND (location LIKE '%$location%' OR name LIKE '%$location%')";
}
if ($hotel_type) {
    $sql .= " AND hotel_type = '$hotel_type'";
}

if ($sort == 'price_low') {
    $sql .= " ORDER BY price_usd ASC";
} elseif ($sort == 'price_high') {
    $sql .= " ORDER BY price_usd DESC";
} else {
    $sql .= " ORDER BY rating DESC";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Hotels | Hotels.com Clone</title>
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
            color: var(--text-dark);
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
            box-shadow: var(--shadow);
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 50px;
            display: flex;
            gap: 30px;
        }

        /* Sidebar Filters */
        .sidebar {
            width: 300px;
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            height: fit-content;
            position: sticky;
            top: 110px;
        }

        .sidebar h3 {
            margin-bottom: 20px;
            color: var(--primary-blue);
            border-bottom: 2px solid var(--accent-gold);
            padding-bottom: 10px;
        }

        .filter-group {
            margin-bottom: 25px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            font-size: 14px;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        /* Hotels List */
        .main-content {
            flex: 1;
        }

        .listing-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .hotel-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-bottom: 25px;
            display: flex;
            transition: 0.3s;
            border: 1px solid transparent;
        }

        .hotel-card:hover {
            transform: scale(1.01);
            border-color: var(--accent-gold);
        }

        .hotel-img {
            width: 350px;
            height: 250px;
            background-size: cover;
            background-position: center;
        }

        .hotel-info {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .hotel-info h2 {
            color: var(--primary-blue);
            font-size: 24px;
            margin-bottom: 5px;
        }

        .location {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .amenities {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .tag {
            background: #f0f4f8;
            color: var(--primary-blue);
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }

        .rating-box {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: auto;
        }

        .rating-badge {
            background: var(--primary-blue);
            color: white;
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: 700;
        }

        .price-section {
            width: 250px;
            padding: 25px;
            border-left: 1px solid #eee;
            text-align: right;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .price-label {
            font-size: 12px;
            color: #666;
        }

        .price-amount {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-red);
            margin: 5px 0;
        }

        .view-btn {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .view-btn:hover {
            background: var(--primary-red);
        }

        /* Currency toggle */
        .currency-btn {
            background: white;
            border: 1px solid var(--primary-blue);
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: static;
            }

            .hotel-card {
                flex-direction: column;
            }

            .hotel-img {
                width: 100%;
                height: 200px;
            }

            .price-section {
                width: 100%;
                border-left: none;
                border-top: 1px solid #eee;
                text-align: left;
            }
        }
    </style>
</head>

<body>

    <header>
        <a href="index.php" class="logo">Hotels<span>.com</span></a>
        <nav>
            <ul style="display: flex; list-style: none; gap: 20px;">
                <li><a href="index.php" style="color: white; text-decoration: none;">Home</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <!-- Sidebar Filters -->
        <aside class="sidebar">
            <h3>Filters</h3>
            <form action="hotels.php" method="GET">
                <div class="filter-group">
                    <label>Destination</label>
                    <input type="text" name="location" value="<?php echo htmlspecialchars($location); ?>"
                        placeholder="Search city...">
                </div>
                <div class="filter-group">
                    <label>Hotel Type</label>
                    <select name="type">
                        <option value="">All Types</option>
                        <option value="Luxury" <?php if ($hotel_type == 'Luxury')
                            echo 'selected'; ?>>Luxury</option>
                        <option value="Resort" <?php if ($hotel_type == 'Resort')
                            echo 'selected'; ?>>Resort</option>
                        <option value="Budget" <?php if ($hotel_type == 'Budget')
                            echo 'selected'; ?>>Budget</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Sort By</label>
                    <select name="sort">
                        <option value="rating" <?php if ($sort == 'rating')
                            echo 'selected'; ?>>Best Rated</option>
                        <option value="price_low" <?php if ($sort == 'price_low')
                            echo 'selected'; ?>>Price Low to High
                        </option>
                        <option value="price_high" <?php if ($sort == 'price_high')
                            echo 'selected'; ?>>Price High to Low
                        </option>
                    </select>
                </div>
                <button type="submit" class="view-btn" style="width:100%">Apply Filters</button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="listing-header">
                <h1>
                    <?php echo $location ? "Hotels in " . htmlspecialchars($location) : "Available Stays"; ?>
                </h1>
                <p>
                    <?php echo $result->num_rows; ?> properties found
                </p>
            </div>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="hotel-card">
                        <div class="hotel-img" style="background-image: url('<?php echo $row['main_image']; ?>')"></div>
                        <div class="hotel-info">
                            <h2>
                                <?php echo $row['name']; ?>
                            </h2>
                            <p class="location"><i class="fas fa-map-marker-alt"></i>
                                <?php echo $row['location']; ?>
                            </p>
                            <div class="amenities">
                                <?php
                                $amenities = explode(',', $row['amenities']);
                                foreach ($amenities as $amenity) {
                                    echo "<span class='tag'>" . trim($amenity) . "</span>";
                                }
                                ?>
                            </div>
                            <div class="rating-box">
                                <span class="rating-badge">
                                    <?php echo $row['rating']; ?>
                                </span>
                                <span style="font-weight: 600;">
                                    <?php echo $row['rating'] >= 4.5 ? 'Exceptional' : 'Excellent'; ?>
                                </span>
                                <span style="color: #666;">(
                                    <?php echo $row['reviews_count']; ?> reviews)
                                </span>
                            </div>
                        </div>
                        <div class="price-section">
                            <div class="curr-wrap">
                                <p class="price-label">Price per night</p>
                                <p class="price-amount" id="price-<?php echo $row['id']; ?>">$
                                    <?php echo number_format($row['price_usd'], 0); ?>
                                </p>
                                <p style="font-size: 11px; color:#888;">includes taxes & fees</p>
                            </div>
                            <a href="details.php?id=<?php echo $row['id']; ?>" class="view-btn">View Deal</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 50px; background: white; border-radius: 20px;">
                    <h2 style="color: var(--primary-blue);">No hotels found!</h2>
                    <p>Try adjusting your filters or location.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Currency Switcher JS -->
    <script>
        // Simple JS for redirection simulator
        function goTo(page) {
            window.location.href = page;
        }
    </script>
</body>

</html>
<?php $conn->close(); ?>
