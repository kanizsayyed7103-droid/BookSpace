<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
        font-family: "Segoe UI", sans-serif;
        background: var(--color-lavender);
        color: var(--color-text);
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
    }

    .btn-logout:hover {
        background: var(--color-lavender);
        color: #fff;
    }
    </style>
</head>

<body>
    <!-- Sidebar -->
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
            <li class="nav-item"><a href="bookshelf1.php" class="nav-link">Bookshelf</a></li>
            <li class="nav-item"><a href="cost.php" class="nav-link">Cost</a></li>
            <li class="nav-item"><a href="contact.php" class="nav-link active">Contact</a></li>
            <li class="nav-item"><a href="ai.php" class="nav-link">AI Chatbot</a></li>
            <li class="nav-item"><a href="authors.php" class="nav-link">Authors</a></li>
        </ul>

        <!-- Logout -->
        <button class="btn btn-logout mt-3">LOGOUT</button>
    </div>
</body>

</html>