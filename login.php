<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Hotels.com Clone</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #003580;
            --primary-red: #d4111e;
            --accent-gold: #ffb700;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #001f4d 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            width: 100%;
            max-width: 450px;
            padding: 50px;
            border-radius: 30px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo {
            font-size: 32px;
            font-weight: 800;
            color: var(--primary-blue);
            margin-bottom: 30px;
            display: block;
            text-decoration: none;
        }

        .logo span {
            color: var(--primary-red);
        }

        h2 {
            margin-bottom: 30px;
            color: var(--primary-blue);
            font-size: 24px;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #ddd;
            outline: none;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 10px rgba(0, 53, 128, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: var(--primary-red);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.3s;
        }

        .login-btn:hover {
            background: #b30e19;
            transform: translateY(-2px);
        }

        .footer-links {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }

        .footer-links a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }

        /* Subtle Ancient Patterns Background */
        .bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://icons.veryicon.com/png/o/business/icon-library-of-traditional-chinese-medicine-series/clay-pot.png');
            background-repeat: repeat;
            opacity: 0.03;
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>

<body>

    <div class="bg-pattern"></div>

    <div class="login-card">
        <a href="index.php" class="logo">Hotels<span>.com</span></a>
        <h2>Welcome Back</h2>

        <form onsubmit="event.preventDefault(); window.location.href='index.php';">
            <div class="input-group">
                <label>Email Address</label>
                <input type="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="login-btn">Sign In</button>
        </form>

        <div class="footer-links">
            Don't have an account? <a href="#">Create one</a>
        </div>
    </div>

</body>

</html>
