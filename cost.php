<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace | Cost</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

    :root {
        --color-deep-purple: #3a2d5c;
        --color-lavender: #a18cd1;
        --color-dusty-pink: #fbc2eb;
        --color-text: #2c2c2c;
        --color-light-text: #f0f0f0;
        --color-highlight: #51407d;
    }

    body {
        font-family: 'Roboto', sans-serif;
        background-color: var(--color-lavender);
        color: var(--color-text);
        min-height: 100vh;
    }

    /* Custom styles for sidebar */


    /* Main content area */
    .main-content-wrapper {
        flex-grow: 1;
        padding: 20px;
        overflow-y: auto;
    }

    .pricing-card {
        background-color: white;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
    }

    .pricing-card:hover {
        transform: translateY(-0.5rem);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .plan-header-free {
        background-color: var(--color-dusty-pink);
        color: var(--color-deep-purple);
        padding: 2rem;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .plan-header-paid {
        background-color: var(--color-highlight);
        color: white;
        padding: 2rem;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .plan-price {
        font-size: 2.5rem;
        font-weight: 700;
        margin-top: 1rem;
    }

    .plan-price-text {
        font-size: 1.25rem;
        font-weight: 500;
    }

    .features {
        padding: 2rem;
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
        justify-content: center;
        font-size: 1rem;
    }

    .features .fa-check {
        color: #28a745;
        margin-right: 0.5rem;
    }

    .features .fa-times {
        color: #dc3545;
        margin-right: 0.5rem;
    }

    .btn-plan {
        background-color: var(--color-deep-purple);
        color: white;
        font-weight: bold;
        border-radius: 9999px;
        padding: 0.75rem 1.5rem;
        transition: background-color 0.3s ease;
    }

    .btn-plan:hover {
        background-color: var(--color-highlight);
    }
    </style>
</head>

<body class="flex">
    <!-- Sidebar -->
    <?php include 'reader_sidebar.php'; ?>

    <div class="sidebar d-flex flex-column">
        <!-- Logo -->
        <div class="logo">
            <img src="logo.JPEG" alt="BookSpace Logo">
            <h4>bookSpace</h4>
        </div>

        <!-- Profile -->
        <div class="profile">
            <img src="profile.jpg" alt="Profile">
            <p>Welcome, <b><?php echo $_SESSION['role'] ?? 'Reader'; ?></b></p>
        </div>

        <!-- Search -->
        <form action="reader_dashboard.php" method="post" class="mb-3">
            <input type="text" class="form-control" name="search" placeholder="Search books...">
        </form>

        <!-- Navigation -->
        <ul class="nav flex-column mb-auto">
            <li class="nav-item"><a href="reader_dashboard.php" class="nav-link">Dashboard</a></li>
            <li><a href="bookshelf1.php" class="nav-link">Bookshelf</a></li>
            <li><a href="cost.php" class="nav-link">Cost</a></li>
            <li><a href="contact.php" class="nav-link">Contact</a></li>
            <li><a href="ai.php" class="nav-link">AI Chatbot</a></li>
            <li><a href="authors.php" class="nav-link">Authors</a></li>
        </ul>

        <!-- Logout -->
        <button class="btn btn-logout mt-3">LOGOUT</button>
    </div>


    <!-- Main Content Area -->
    <div class="main-content-wrapper flex flex-col items-center">
        <div class="container-fluid">
            <!-- Header Section -->
            <header class="text-center py-8">
                <h1 class="text-4xl font-bold mb-2" style="color: var(--color-deep-purple);">Our Plans</h1>
                <p class="text-lg text-gray-600">Choose the perfect plan for your reading journey.</p>
            </header>

            <!-- Pricing Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Free Plan Card -->
                <div class="pricing-card overflow-hidden">
                    <div class="plan-header-free">
                        <i class="fas fa-book text-3xl"></i>
                        <h3 class="text-xl font-bold mt-2">Reader</h3>
                        <div class="plan-price-text">Free</div>
                    </div>
                    <div class="features">
                        <ul>
                            <li><i class="fas fa-check"></i> 5 AI Summaries / month</li>
                            <li><i class="fas fa-check"></i> Limited Book Access</li>
                            <li class="text-gray-400"><i class="fas fa-times"></i> No AI Chatbot</li>
                            <li class="text-gray-400"><i class="fas fa-times"></i> No Author Insights</li>
                        </ul>
                        <button class="btn btn-plan mt-4">Get Started</button>
                    </div>
                </div>

                <!-- Book Lover Plan Card -->
                <div class="pricing-card overflow-hidden">
                    <div class="plan-header-paid">
                        <i class="fas fa-heart text-3xl"></i>
                        <h3 class="text-xl font-bold mt-2">Book Lover</h3>
                        <div class="plan-price">₹199<span class="text-sm font-normal"> / month</span></div>
                    </div>
                    <div class="features">
                        <ul>
                            <li><i class="fas fa-check"></i> 50 AI Summaries / month</li>
                            <li><i class="fas fa-check"></i> Full Bookshelf Access</li>
                            <li><i class="fas fa-check"></i> AI Chatbot Access</li>
                            <li class="text-gray-400"><i class="fas fa-times"></i> No Priority Support</li>
                        </ul>
                        <button class="btn btn-plan mt-4">Subscribe</button>
                    </div>
                </div>

                <!-- Library Master Plan Card -->
                <div class="pricing-card overflow-hidden">
                    <div class="plan-header-paid">
                        <i class="fas fa-university text-3xl"></i>
                        <h3 class="text-xl font-bold mt-2">Library Master</h3>
                        <div class="plan-price">₹399<span class="text-sm font-normal"> / month</span></div>
                    </div>
                    <div class="features">
                        <ul>
                            <li><i class="fas fa-check"></i> Unlimited AI Summaries</li>
                            <li><i class="fas fa-check"></i> All Books Unlocked</li>
                            <li><i class="fas fa-check"></i> AI Chatbot + Author Insights</li>
                            <li><i class="fas fa-check"></i> Priority Support</li>
                        </ul>
                        <button class="btn btn-plan mt-4">Go Premium</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>