<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace | Contact</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
        margin: 0;
        font-family: 'Roboto', sans-serif;
        background: var(--color-lavender);
        color: var(--color-text);
        display: flex;
        flex-direction: row;
        overflow-x: hidden;
    }

    /* Custom styles for sidebar */
    .sidebar {
        width: 260px;
        min-height: 100vh;
        background: var(--color-deep-purple);
        color: var(--color-light-text);
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        position: sticky;
        top: 0;
    }

    .sidebar .logo {
        text-align: center;
        margin-bottom: 20px;
    }

    .sidebar .logo img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .sidebar .profile {
        text-align: center;
        margin-bottom: 30px;
    }

    .sidebar .profile img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .sidebar .nav-link {
        color: var(--color-light-text);
        font-weight: 500;
        padding: 10px;
        border-radius: 8px;
        text-decoration: none;
    }

    .sidebar .nav-link:hover {
        background: var(--color-highlight);
        color: #fff;
    }

    .btn-logout {
        width: 100%;
        background: var(--color-dusty-pink);
        color: var(--color-deep-purple);
        font-weight: bold;
        border-radius: 8px;
        border: none;
        padding: 10px;
        margin-top: auto;
    }

    .btn-logout:hover {
        background: var(--color-lavender);
        color: #fff;
    }

    /* Main content styling */
    .main-content-wrapper {
        flex-grow: 1;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow-y: auto;
    }

    .contact-form {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 700px;
    }

    .btn-contact {
        display: inline-block;
        padding: 10px 20px;
        border: none;
        background-color: var(--color-deep-purple);
        color: white;
        border-radius: 25px;
        cursor: pointer;
        transition: background 0.3s ease;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-contact:hover {
        background: var(--color-highlight);
    }

    .contact-info {
        background: var(--color-deep-purple);
        color: var(--color-light-text);
        border-radius: 15px;
        padding: 30px;
    }

    .contact-info a {
        color: var(--color-light-text);
        text-decoration: none;
    }
    </style>
</head>

<body class="vh-100">
    <div class="d-flex w-100 vh-100">
        <!-- Sidebar -->
        <div class="sidebar d-none d-md-block">
            <!-- Logo -->
            <div class="logo">
                <img src="logo.JPEG" alt="BookSpace Logo">
                <h4>bookSpace</h4>
            </div>
            <!-- Profile -->
            <div class="profile">
                <img src="profile.jpg" alt="Profile">
                <p>Welcome, <b>Reader</b></p>
            </div>
            <!-- Search -->
            <form action="#" method="post" class="mb-3">
                <input type="text" class="form-control" name="search" placeholder="Search books...">
            </form>
            <!-- Navigation -->
            <ul class="nav flex-column mb-auto">
                <li class="nav-item"><a href="reader_dashboard.php" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="bookshelf1.php" class="nav-link">Bookshelf</a></li>
                <li class="nav-item"><a href="cost.php" class="nav-link">Cost</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link active">Contact</a></li>
                <li class="nav-item"><a href="ai.php" class="nav-link">AI Chatbot</a></li>
                <li class="nav-item"><a href="authors.php" class="nav-link">Authors</a></li>
            </ul>
            <!-- Logout -->
            <button class="btn btn-logout mt-3">LOGOUT</button>
        </div>

        <!-- Main Content Area -->
        <div class="main-content-wrapper">
            <div class="container-fluid">
                <div class="row w-100 justify-content-center mb-4">
                    <div class="col-12 text-center">
                        <h2 class="mb-4">Contact Us</h2>
                    </div>
                </div>

                <!-- Contact Form and Info -->
                <div class="row w-100 justify-content-center g-4">
                    <!-- Contact Form -->
                    <div class="col-12 col-lg-7">
                        <div class="contact-form">
                            <h4 class="text-center mb-4">Send a Message</h4>
                            <form action="#" method="post">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fullName"
                                        placeholder="Enter your full name">
                                </div>
                                <div class="mb-3">
                                    <label for="emailAddress" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="emailAddress"
                                        placeholder="Enter your email">
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="5"
                                        placeholder="Enter your message"></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-contact">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-12 col-lg-5">
                        <div class="contact-info h-100">
                            <h4 class="mb-4">Get in Touch</h4>
                            <p><i class="fas fa-map-marker-alt me-2"></i> 123 Bookworm Lane, Reading, Fictionland</p>
                            <p><i class="fas fa-envelope me-2"></i> <a
                                    href="mailto:contact@bookspace.com">contact@bookspace.com</a></p>
                            <p><i class="fas fa-phone me-2"></i> <a href="tel:+1234567890">+1 (234) 567-890</a></p>
                            <p class="mt-4">
                                <a href="#" class="me-3"><i class="fab fa-twitter fa-2x"></i></a>
                                <a href="#" class="me-3"><i class="fab fa-facebook fa-2x"></i></a>
                                <a href="#" class="me-3"><i class="fab fa-instagram fa-2x"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>