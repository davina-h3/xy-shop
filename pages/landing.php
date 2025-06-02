<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XY Shop - Premium Products</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Base Styles */
        :root {
            --primary: #ff6b6b;
            --primary-dark: #ff5252;
            --secondary: #4ecdc4;
            --dark: #2d3436;
            --light: #f5f6fa;
            --gray: #636e72;
            --light-gray: #dfe6e9;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--dark);
            line-height: 1.6;
            background-color: var(--light);
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }
        
        a {
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.6);
        }
        
        .btn-outline {
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }
        
        .section {
            padding: 100px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title h2 {
            font-size: 36px;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 3px;
            background: var(--primary);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .section-title p {
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto;
            font-size: 18px;
        }
        
        /* Header */
        header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            padding: 20px 0;
        }
        
        header.scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            font-family: 'Playfair Display', serif;
        }
        
        .logo span {
            color: var(--primary);
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 30px;
        }
        
        nav ul li a {
            font-weight: 500;
            position: relative;
            color: var(--dark);
        }
        
        nav ul li a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--primary);
            bottom: -5px;
            left: 0;
            transition: width 0.3s ease;
        }
        
        nav ul li a:hover:after,
        nav ul li a.active:after {
            width: 100%;
        }
        
        .mobile-menu-btn {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--dark);
        }
        
        /* Hero Section */
        #home {
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }
        
        .hero-content h1 {
            font-size: 60px;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero-content p {
            font-size: 18px;
            margin-bottom: 30px;
            color: var(--gray);
        }
        
        .hero-bg {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            clip-path: polygon(25% 0%, 100% 0%, 100% 100%, 0% 100%);
            z-index: 1;
        }
        
        .hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
        }
        
        /* Features Section */
        #features {
            background-color: white;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .feature-card {
            background-color: var(--light);
            border-radius: 10px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .feature-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            opacity: 0;
            z-index: -1;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            color: white;
        }
        
        .feature-card:hover:before {
            opacity: 1;
        }
        
        .feature-card:hover .feature-icon {
            background-color: white;
            color: var(--primary);
        }
        
        .feature-card:hover h3,
        .feature-card:hover p {
            color: white;
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background-color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 30px;
            transition: all 0.3s ease;
        }
        
        .feature-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
        }
        
        .feature-card p {
            color: var(--gray);
            transition: all 0.3s ease;
        }
        
        /* Products Section */
        #products {
            background-color: var(--light);
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .product-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--primary);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .product-image {
            height: 250px;
            overflow: hidden;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.1);
        }
        
        .product-info {
            padding: 20px;
        }
        
        .product-category {
            color: var(--primary);
            font-size: 14px;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .product-title {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .product-price {
            font-weight: 700;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .product-price .old-price {
            font-size: 16px;
            color: var(--gray);
            text-decoration: line-through;
            margin-right: 10px;
        }
        
        .product-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        
        .add-to-cart {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .add-to-cart i {
            margin-right: 5px;
        }
        
        .add-to-cart:hover {
            background-color: var(--primary-dark);
        }
        
        .wishlist {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .wishlist:hover {
            background-color: var(--primary);
            color: white;
        }
        
        /* About Section */
        #about {
            background-color: white;
        }
        
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }
        
        .about-image {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .about-image img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .about-text h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        
        .about-text p {
            margin-bottom: 20px;
            color: var(--gray);
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 40px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 16px;
            color: var(--gray);
        }
        
        /* Contact Section */
        #contact {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('contact-bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
        }
        
        #contact .section-title h2,
        #contact .section-title p {
            color: white;
        }
        
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            width: 100%;
            padding: 15px;
            border-radius: 5px;
            border: none;
            background-color: rgba(255, 255, 255, 0.9);
            font-family: 'Montserrat', sans-serif;
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        .submit-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 80px 0 30px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 50px;
        }
        
        .footer-column h3 {
            font-size: 20px;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-column h3:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 2px;
            background-color: var(--primary);
            bottom: 0;
            left: 0;
        }
        
        .footer-column p {
            color: var(--light-gray);
            margin-bottom: 20px;
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 10px;
        }
        
        .footer-column ul li a {
            color: var(--light-gray);
            transition: all 0.3s ease;
        }
        
        .footer-column ul li a:hover {
            color: var(--primary);
            padding-left: 5px;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--light-gray);
            font-size: 14px;
        }
        
        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        }
        
        .back-to-top.active {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            background-color: var(--primary-dark);
            transform: translateY(-5px);
        }
        
        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            max-width: 300px;
            height: 100vh;
            background-color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            transition: all 0.3s ease;
            padding: 30px;
            display: flex;
            flex-direction: column;
        }
        
        .mobile-menu.active {
            left: 0;
        }
        
        .mobile-menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .mobile-menu-close {
            font-size: 24px;
            cursor: pointer;
        }
        
        .mobile-nav ul {
            list-style: none;
        }
        
        .mobile-nav ul li {
            margin-bottom: 15px;
        }
        
        .mobile-nav ul li a {
            font-weight: 500;
            font-size: 18px;
        }
        
        .mobile-menu-footer {
            margin-top: auto;
        }
        
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .hero-content h1 {
                font-size: 48px;
            }
            
            .about-content {
                grid-template-columns: 1fr;
            }
            
            .about-image {
                order: -1;
            }
        }
        
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 36px;
            }
            
            .hero-bg {
                width: 100%;
                clip-path: none;
                opacity: 0.3;
            }
            
            .hero-content {
                max-width: 100%;
                text-align: center;
            }
            
            nav {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .section {
                padding: 70px 0;
            }
        }
        
        @media (max-width: 576px) {
            .hero-content h1 {
                font-size: 32px;
            }
            
            .section-title h2 {
                font-size: 30px;
            }
            
            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div>
    <div class="mobile-menu">
        <div class="mobile-menu-header">
            <div class="logo">XY<span>Shop</span></div>
            <div class="mobile-menu-close">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <nav class="mobile-nav">
            <ul>
                <li><a href="#home" class="mobile-nav-link active">Home</a></li>
                <li><a href="#features" class="mobile-nav-link">Features</a></li>
                <li><a href="#products" class="mobile-nav-link">Products</a></li>
                <li><a href="#about" class="mobile-nav-link">About</a></li>
                <li><a href="#contact" class="mobile-nav-link">Contact</a></li>
            </ul>
        </nav>
        <div class="mobile-menu-footer">
            <div class="auth-buttons">
                <a href="login.php" class="btn btn-outline" style="margin-bottom: 15px;">Login</a>
                <a href="landing.php" class="btn btn-primary">Register</a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header id="header">
        <div class="container header-container">
            <a href="#home" class="logo">XY<span>Shop</span></a>
            <nav>
                <ul>
                    <li><a href="#home" class="nav-link active">Home</a></li>
                    <li><a href="#features" class="nav-link">Features</a></li>
                    <li><a href="#products" class="nav-link">Products</a></li>
                    <li><a href="#about" class="nav-link">About</a></li>
                    <li><a href="#contact" class="nav-link">Contact</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                <a href="login.php" class="btn btn-outline">Login</a>
                <a href="signup.php" class="btn btn-primary">Register</a>
            </div>
            <div class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="section">
        <div class="container">
            <div class="hero-content">
                <h1>Discover Premium Products for Your Lifestyle</h1>
                <p>XY Shop offers carefully curated high-quality products that combine functionality with elegant design to enhance your everyday life.</p>
                <a href="#products" class="btn btn-primary">Shop Now</a>
            </div>
        </div>
        <div class="hero-bg">
            <img src="hero-bg.jpg" alt="XY Shop Products">
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose XY Shop?</h2>
                <p>We're committed to providing exceptional products and service to our valued customers.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Quality Guarantee</h3>
                    <p>All our products undergo rigorous quality checks to ensure you receive only the best.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3>Fast Shipping</h3>
                    <p>Get your orders delivered quickly with our reliable shipping partners worldwide.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>24/7 Support</h3>
                    <p>Our customer service team is always ready to assist you with any questions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Featured Products</h2>
                <p>Check out our most popular items this season.</p>
            </div>
            <div class="products-grid">
                <div class="product-card">
                    <div class="product-badge">New</div>
                    <div class="product-image">
                        <img src="product1.jpg" alt="Wireless Headphones">
                    </div>
                    <div class="product-info">
                        <div class="product-category">Electronics</div>
                        <h3 class="product-title">Premium Wireless Headphones</h3>
                        <div class="product-price">
                            <span>$199.99</span>
                        </div>
                        <div class="product-actions">
                            <button class="add-to-cart">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                            <div class="wishlist">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-badge">Sale</div>
                    <div class="product-image">
                        <img src="product2.jpg" alt="Smart Watch">
                    </div>
                    <div class="product-info">
                        <div class="product-category">Wearables</div>
                        <h3 class="product-title">Smart Fitness Watch</h3>
                        <div class="product-price">
                            <span class="old-price">$199.99</span>
                            <span>$149.99</span>
                        </div>
                        <div class="product-actions">
                            <button class="add-to-cart">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                            <div class="wishlist">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="product3.jpg" alt="Backpack">
                    </div>
                    <div class="product-info">
                        <div class="product-category">Accessories</div>
                        <h3 class="product-title">Urban Travel Backpack</h3>
                        <div class="product-price">
                            <span>$79.99</span>
                        </div>
                        <div class="product-actions">
                            <button class="add-to-cart">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                            <div class="wishlist">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="product4.jpg" alt="Coffee Maker">
                    </div>
                    <div class="product-info">
                        <div class="product-category">Home</div>
                        <h3 class="product-title">Automatic Coffee Maker</h3>
                        <div class="product-price">
                            <span>$129.99</span>
                        </div>
                        <div class="product-actions">
                            <button class="add-to-cart">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                            <div class="wishlist">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section">
        <div class="container">
            <div class="section-title">
                <h2>About XY Shop</h2>
                <p>Our story and what makes us different</p>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <h2>We Believe in Quality and Craftsmanship</h2>
                    <p>Founded in 2015, XY Shop began with a simple mission: to provide high-quality products that combine functionality with elegant design. What started as a small boutique has grown into a trusted brand known for its attention to detail and customer-focused approach.</p>
                    <p>Each product in our collection is carefully selected or designed in-house to meet our strict standards. We work directly with artisans and manufacturers who share our commitment to quality and sustainability.</p>
                    <div class="stats">
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Happy Customers</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">50+</div>
                            <div class="stat-label">Premium Products</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">10+</div>
                            <div class="stat-label">Countries Served</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Customer Support</div>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="about-img.jpg" alt="About XY Shop">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Get In Touch</h2>
                <p>Have questions or want to place an order? Contact us today!</p>
            </div>
            <div class="contact-form">
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>XY Shop</h3>
                    <p>Providing premium products since 2015. We're dedicated to quality and customer satisfaction.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Customer Service</h3>
                    <ul>
                        <li><a href="#">My Account</a></li>
                        <li><a href="#">Order Tracking</a></li>
                        <li><a href="#">Wishlist</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Shipping Info</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Shop Street, City</li>
                        <li><i class="fas fa-phone"></i> (123) 456-7890</li>
                        <li><i class="fas fa-envelope"></i> info@xyshop.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 XY Shop. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <div class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </div>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const mobileMenuClose = document.querySelector('.mobile-menu-close');
        const mobileMenu = document.querySelector('.mobile-menu');
        const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
        
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.add('active');
            mobileMenuOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        
        mobileMenuClose.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
        
        mobileMenuOverlay.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
        
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                mobileMenuOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            });
        });
        
        // Sticky Header
        const header = document.getElementById('header');
        const backToTop = document.querySelector('.back-to-top');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
                backToTop.classList.add('active');
            } else {
                header.classList.remove('scrolled');
                backToTop.classList.remove('active');
            }
        });
        
        // Smooth Scrolling for Navigation Links
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href');
                const targetSection = document.querySelector(targetId);
                
                window.scrollTo({
                    top: targetSection.offsetTop - 70,
                    behavior: 'smooth'
                });
                
                // Update active link
                navLinks.forEach(navLink => navLink.classList.remove('active'));
                link.classList.add('active');
            });
        });
        
        // Update active link on scroll
        const sections = document.querySelectorAll('section');
        
        window.addEventListener('scroll', () => {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                
                if (pageYOffset >= (sectionTop - 100)) {
                    current = section.getAttribute('id');
                                });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === #${current}) {
                    link.classList.add('active');
                }
            });
            
            // Also update mobile nav links
            mobileNavLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === #${current}) {
                    link.classList.add('active');
                }
            });
        });
        
        // Back to Top Button
        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Product Card Interactions
        const wishlistButtons = document.querySelectorAll('.wishlist');
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        
        wishlistButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const icon = button.querySelector('i');
                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    button.style.backgroundColor = 'var(--primary)';
                    button.style.color = 'white';
                    // Here you would typically add to wishlist via AJAX
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    button.style.backgroundColor = 'var(--light-gray)';
                    button.style.color = 'inherit';
                    // Here you would typically remove from wishlist via AJAX
                }
            });
        });
        
        addToCartButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const productCard = button.closest('.product-card');
                const productName = productCard.querySelector('.product-title').textContent;
                
                // Animation effect
                button.innerHTML = '<i class="fas fa-check"></i> Added!';
                button.style.backgroundColor = 'var(--secondary)';
                
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
                    button.style.backgroundColor = 'var(--primary)';
                }, 2000);
                
                // Here you would typically add to cart via AJAX
                console.log(Added ${productName} to cart);
            });
        });
        
        // Form Submission
        const contactForm = document.querySelector('.contact-form form');
        if (contactForm) {
            contactForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const submitBtn = contactForm.querySelector('.submit-btn');
                
                // Change button text and style during submission
                submitBtn.textContent = 'Sending...';
                submitBtn.style.opacity = '0.8';
                
                // Simulate form submission
                setTimeout(() => {
                    submitBtn.textContent = 'Message Sent!';
                    submitBtn.style.backgroundColor = 'var(--secondary)';
                    
                    // Reset form
                    setTimeout(() => {
                        contactForm.reset();
                        submitBtn.textContent = 'Send Message';
                        submitBtn.style.backgroundColor = 'var(--primary)';
                        submitBtn.style.opacity = '1';
                    }, 2000);
                }, 1500);
            });
        }
        
        // Initialize with home section active
        document.querySelector('.nav-link[href="#home"]').classList.add('active');
        document.querySelector('.mobile-nav-link[href="#home"]').classList.add('active');
    </script>
</body>
</html>