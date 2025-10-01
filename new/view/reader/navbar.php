<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace | Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Cinzel+Decorative:wght@700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
    /* Define CSS Variables */
    :root {
        --color-deep-purple: #3a2d5c;
        --color-lavender: #a18cd1;
        --color-dusty-pink: #fbc2eb;
        --color-text: #2c2c2c;
        --color-light-text: #f0f0f0;
        --color-highlight: #51407d;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--color-lavender);
        margin: 0;
        padding-top: 70px;
    }

    /* --- Navbar Styling --- */
    .navbar {
        background-color: var(--color-highlight);
        padding: 0.5rem 1rem;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
    }

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>