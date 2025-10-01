<!DOCTYPE html>
<html lang="en">
<?php
// PHP logic kept for context
$q = urlencode($_POST['search'] ?? 'harry potter');
$key = 'AIzaSyCOCuStWqupRkpuhuYgeG4tqGYUDIsizns';
$url = "https://www.googleapis.com/books/v1/volumes?q={$q}&key={$key}&maxResults=10";

$json = file_get_contents($url);
$data = json_decode($json, true);
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace | Pricing Plans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Cinzel+Decorative:wght@700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
    :root {
        --color-deep-purple: #3a2d5c;
        --color-lavender: #a18cd1;
        --color-dusty-pink: #fbc2eb;
        --color-text: #2c2c2c;
        --color-light-text: #f0f0f0;
        --color-highlight: #51407d;
        --color-premium-dark: #261f43;
        /* New darker color for Library Master */
        --color-accent-green: #28a745;
        --color-accent-red: #dc3545;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--color-lavender);
        margin: 0;
        padding-top: 70px;
    }

    /* --- Navbar Styling (Retained) --- */
    .navbar {
        background-color: var(--color-highlight);
        padding: 0.5rem 1rem;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
    }

    /* ... (Navbar styles omitted for brevity) ... */
    .navbar-brand {
        display: flex;
        align-items: center;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--color-light-text);
    }

    .navbar-brand img {
        height: 50px;
        margin-right: 10px;
        border-radius: 50%;
    }

    .navbar-brand h4 {
        margin: 0;
        color: var(--color-light-text);
        font-family: 'Cinzel Decorative', cursive;
    }

    .navbar .nav-link {
        color: var(--color-light-text);
        font-weight: 500;
        padding: 0.5rem 1rem;
    }

    .navbar .nav-link.active,
    .navbar .nav-link:hover {
        color: #b899f1ff;
        font-weight: 600;
    }

    .navbar .form-control {
        border-radius: 20px;
        border: 1px solid #f39bfbff;
        padding: 0.4rem 1rem;
        width: 300px;
    }

    .profile-section {
        display: flex;
        align-items: center;
        color: var(--color-light-text);
    }

    .profile-section img {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        margin-right: 8px;
        border: 1px solid #ddd;
    }

    .profile-section b {
        color: var(--color-light-text);
        font-weight: 600;
    }

    .btn-logout {
        background-color: var(--color-dusty-pink);
        color: var(--color-deep-purple);
        font-weight: bold;
        border-radius: 20px;
        padding: 0.4rem 1.2rem;
        font-size: 0.9rem;
    }

    .btn-logout:hover {
        background-color: #ec9ed6ff;
        color: var(--color-deep-purple);
    }

    /* --- End Navbar Styling --- */

    /* --- Main Content Styling --- */
    .main-content-wrapper {
        padding: 40px 20px;
        margin: auto;
        width: 100%;
        max-width: 1200px;
    }

    header h1 {
        font-size: 2.5rem;
        font-weight: 700;
    }

    .pricing-card {
        background-color: white;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
        position: relative;
    }

    .pricing-card:hover {
        transform: translateY(-0.75rem);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .plan-header-free,
    .plan-header-paid {
        padding: 2.5rem 1rem 1.5rem 1rem;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
        position: relative;
    }

    /* Default paid plan header color (Book Lover) */
    .plan-header-paid {
        background-color: var(--color-highlight);
        color: white;
    }

    .plan-header-free {
        background-color: var(--color-dusty-pink);
        color: var(--color-deep-purple);
    }

    .row-cols-lg-3>.col:nth-child(3) .plan-header-paid {
        background-color: var(--color-dusty-pink);
        color: var(--color-deep-purple);
    }


    .plan-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .plan-name {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .plan-price {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1;
    }

    .plan-price-text {
        font-size: 1rem;
        font-weight: 500;
        margin-top: 5px;
    }

    .price-currency {
        font-size: 1.5rem;
        font-weight: 600;
        vertical-align: top;
        margin-right: -5px;
    }

    .features {
        padding: 1.5rem 2rem 2.5rem 2rem;
        flex-grow: 1;
    }

    .features ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .features li {
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        font-size: 1rem;
        text-align: left;
    }

    /* Icon styles using Bootstrap Icons */
    .features .bi-check-circle {
        color: var(--color-accent-green);
        font-size: 1.25rem;
        margin-right: 0.75rem;
    }

    .features .bi-x-circle-fill {
        color: var(--color-accent-red);
        font-size: 1.25rem;
        margin-right: 0.75rem;
    }

    .feature-disabled {
        color: #999;
    }

    /* Button Styling */
    .btn-plan {
        background-color: var(--color-deep-purple);
        color: white;
        font-weight: 600;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        transition: background-color 0.3s ease;
        border: none;
        margin-top: 1.5rem;
        width: 80%;
    }

    /* Button for Recommended plan (Book Lover) */
    .pricing-card:nth-child(2) .btn-plan {
        background-color: var(--color-dusty-pink);
        color: var(--color-deep-purple);
    }

    /* Button for Premium plan (Library Master) */
    .pricing-card:nth-child(3) .btn-plan {
        background-color: var(--color-highlight);
        /* Use the default paid color for its button */
        color: white;
    }

    .btn-plan:hover {
        opacity: 0.9;
        color: white;
    }

    /* Recommended Badge */
    .recommended-badge {
        position: absolute;
        top: 0;
        right: 0;
        background-color: var(--color-dusty-pink);
        color: var(--color-deep-purple);
        font-weight: 700;
        padding: 0.3rem 1.5rem;
        border-bottom-left-radius: 1rem;
        z-index: 10;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="reader_dashboard.php">
                <img src="logo.JPEG" alt="BookSpace Logo">
                <h4>bookSpace</h4>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a href="reader_dashboard.php" class="nav-link active">Dashboard</a></li>
                    <li class="nav-item"><a href="bookshelf1.php" class="nav-link">Bookshelf</a></li>
                    <li class="nav-item"><a href="cost.php" class="nav-link">Cost</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                    <li class="nav-item"><a href="chatbot.php" class="nav-link">AI Chatbot</a></li>
                    <li class="nav-item"><a href="authors.php" class="nav-link">Authors</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <form action="reader_dashboard.php" method="post" class="d-flex me-3">
                        <input type="text" class="form-control" name="search" placeholder="Search books..."
                            value="<?php echo htmlspecialchars($_POST['search'] ?? ''); ?>">
                    </form>
                    <div class="profile-section me-3 d-none d-lg-flex">
                        <img src="profile.jpg" alt="Profile">
                        <p class="mb-0">Welcome, <b><?php echo $_SESSION['role'] ?? 'Reader'; ?></b></p>
                    </div>
                    <button class="btn btn-logout">LOGOUT</button>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content-wrapper container">
        <header class="text-center py-5">
            <h1 class="mb-3" style="color: var(--color-deep-purple);">Find Your Perfect Reading Plan</h1>
            <p class="lead text-muted">Choose the features that best fit your reading style and budget.</p>
        </header>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center pt-4">
            <div class="col">
                <div class="pricing-card h-100 d-flex flex-column">
                    <div class="plan-header-free">
                        <i class="bi bi-book plan-icon"></i>
                        <h3 class="plan-name">Basic Reader</h3>
                        <div class="plan-price-text">Always</div>
                        <div class="plan-price">Free</div>
                    </div>
                    <div class="features flex-grow-1 d-flex flex-column justify-content-between">
                        <ul>
                            <li><i class="bi bi-check-circle"></i> 5 AI Summaries / month</li>
                            <li><i class="bi bi-check-circle"></i> Limited Bookshelf Access</li>
                            <li class="feature-disabled"><i class="bi bi-x-circle-fill"></i> No Dedicated AI Chatbot
                            </li>
                            <li class="feature-disabled"><i class="bi bi-x-circle-fill"></i> No Author Insights</li>
                            <li class="feature-disabled"><i class="bi bi-x-circle-fill"></i> Standard Support</li>
                        </ul>
                        <a href="#" class="btn btn-plan align-self-center">Get Started</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="pricing-card h-100 d-flex flex-column" style="border: 3px solid var(--color-dusty-pink);">
                    <div class="recommended-badge">RECOMMENDED</div>
                    <div class="plan-header-paid">
                        <i class="bi bi-heart plan-icon"></i>
                        <h3 class="plan-name">Book Lover</h3>
                        <div class="plan-price">
                            <span class="price-currency">₹</span>199
                            <span class="plan-price-text text-white-50">/ month</span>
                        </div>
                    </div>
                    <div class="features flex-grow-1 d-flex flex-column justify-content-between">
                        <ul>
                            <li><i class="bi bi-check-circle"></i> 50 AI Summaries / month</li>
                            <li><i class="bi bi-check-circle"></i> Full Bookshelf Access</li>
                            <li><i class="bi bi-check-circle"></i> Dedicated AI Chatbot</li>
                            <li class="feature-disabled"><i class="bi bi-x-circle-fill"></i> No Author Insights</li>
                            <li><i class="bi bi-check-circle"></i> Standard Support</li>
                        </ul>
                        <a href="#" class="btn btn-plan align-self-center">Subscribe Now</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="pricing-card h-100 d-flex flex-column">
                    <div class="plan-header-paid">
                        <i class="bi bi-gem plan-icon"></i>
                        <h3 class="plan-name">Library Master</h3>
                        <div class="plan-price">
                            <span class="price-currency">₹</span>399
                            <span class="plan-price-text text-white-50">/ month</span>
                        </div>
                    </div>
                    <div class="features flex-grow-1 d-flex flex-column justify-content-between">
                        <ul>
                            <li><i class="bi bi-check-circle"></i> Unlimited AI Summaries</li>
                            <li><i class="bi bi-check-circle"></i> All Books Unlocked</li>
                            <li><i class="bi bi-check-circle"></i> Dedicated AI Chatbot</li>
                            <li><i class="bi bi-check-circle"></i> Exclusive Author Insights</li>
                            <li><i class="bi bi-check-circle"></i> Priority Support</li>
                        </ul>
                        <a href="#" class="btn btn-plan align-self-center">Go Premium</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>