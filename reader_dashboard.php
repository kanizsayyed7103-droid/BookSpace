<!DOCTYPE html>
<html lang="en">
<?php
$q = urlencode($_POST['search'] ?? 'harry potter');  // search query
$key = 'AIzaSyCOCuStWqupRkpuhuYgeG4tqGYUDIsizns';    // Google API key
$url = "https://www.googleapis.com/books/v1/volumes?q={$q}&key={$key}&maxResults=10";

$json = file_get_contents($url);
$data = json_decode($json, true);
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Cinzel+Decorative:wght@700&display=swap"
        rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom CSS (reader.css content + adjustments for navbar) -->
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #a18cd1;
        margin: 0;
        padding-top: 70px;
    }

    /* Navbar Styling */
    .navbar {
        background-color: #51407d;
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
        color: #f0f0f0;
    }

    .navbar-brand img {
        height: 50px;
        /* Adjust logo size */
        margin-right: 10px;
        border-radius: 50%;

    }

    .navbar-brand h4 {
        margin: 0;
        color: #f0f0f0;
        /* Darker text for brand name */
        font-family: 'Cinzel Decorative', cursive;
        /* Use the decorative font for the brand name */
    }

    .navbar .nav-link {
        color: #f0f0f0;
        font-weight: 500;
        padding: 0.5rem 1rem;
    }

    .navbar .nav-link.active,
    .navbar .nav-link:hover {
        color: #b899f1ff;
        /* Purple hover/active state */
        font-weight: 600;
    }

    .navbar .form-control {
        border-radius: 20px;
        border: 1px solid #f39bfbff;
        padding: 0.4rem 1rem;
        width: 350px;
    }

    .profile-section {
        display: flex;
        align-items: center;
        color: #f0f0f0;
    }

    .profile-section img {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        margin-right: 8px;
        border: 1px solid #ddd;
    }

    .profile-section b {
        color: #f0f0f0;
        font-weight: 600;
    }

    .btn-logout {
        background-color: #fbc2eb;
        /* Red logout button */
        color: white;
        border-radius: 20px;
        padding: 0.4rem 1.2rem;
        font-size: 0.9rem;
    }

    .btn-logout:hover {
        background-color: #ec9ed6ff;
        color: white;
    }

    /* Main Content */
    .main-content {
        padding: 20px;
    }

    .books {
        justify-content: center;
        /* Center book cards */
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s;
        overflow: hidden;
        /* Ensure content stays within rounded corners */
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-img-top {
        width: 100%;
        height: 220px;
        /* Fixed height for book covers */
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }

    .card-body {
        padding: 15px;
        text-align: center;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        height: 48px;
        /* Fixed height for title to prevent layout shifts */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        margin-bottom: 8px;
    }

    .card-text {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 5px;
    }

    .text-warning {
        color: #ffc107 !important;
        /* Ensure star color is vibrant yellow */
        font-size: 0.95rem;
        margin-bottom: 10px;
        display: block;
        /* Make it a block element to control margin */
    }

    .btn-primary {
        background-color: #6f42c1;
        /* Purple AI Summary button */
        border-color: #6f42c1;
        border-radius: 20px;
        font-size: 0.85rem;
        padding: 6px 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary:hover {
        background-color: #5935a4;
        border-color: #5935a4;
    }

    .btn-primary .bi {
        margin-right: 5px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .navbar .form-control {
            width: 180px;
            /* Adjust search bar width on smaller screens */
        }

        .navbar-nav {
            flex-direction: column;
            /* Stack nav links vertically on small screens */
            align-items: flex-start;
        }

        .profile-section {
            margin-top: 10px;
        }

        .btn-logout {
            margin-top: 10px;
        }

        .books .card {
            width: 48%;
            /* Two cards per row on small screens */
        }

        .books {
            gap: 10px;
        }

        body {
            padding-top: 120px;
            /* Adjust padding for expanded navbar on small screens */
        }
    }

    @media (max-width: 576px) {
        .navbar-brand h4 {
            font-size: 1.2rem;
        }

        .navbar .form-control {
            width: 100%;
            /* Full width search bar on extra small screens */
        }

        .books .card {
            width: 100%;
            /* Single card per row on extra small screens */
        }
    }
    </style>
</head>

<body>

    <!-- Navbar -->
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
                    <div class="profile-section me-3">
                        <img src="profile.jpg" alt="Profile">
                        <p class="mb-0">Welcome, <b><?php echo $_SESSION['role'] ?? 'Reader'; ?></b></p>
                    </div>
                    <button class="btn btn-logout">LOGOUT</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content container-fluid">
        <div class="books d-flex flex-wrap gap-3 justify-content-center">
            <?php
            if (!empty($data['items'])) {
                foreach ($data['items'] as $item) {
                    // Extract book information safely
                    $title = $item['volumeInfo']['title'] ?? 'No Title';
                    $authors = isset($item['volumeInfo']['authors']) ? implode(', ', $item['volumeInfo']['authors']) : 'Unknown Author';
                    $thumbnail = $item['volumeInfo']['imageLinks']['thumbnail'] ?? 'https://via.placeholder.com/150?text=No+Cover';
                    $averageRating = $item['volumeInfo']['averageRating'] ?? 'N/A';
                    $infoLink = $item['volumeInfo']['infoLink'] ?? '#';
            ?>
            <div class="card" style="width: 14rem;">
                <img src="<?php echo htmlspecialchars($thumbnail); ?>" class="card-img-top" alt="Book Cover">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($authors); ?></p>
                    <p class="text-warning">⭐ <?php echo htmlspecialchars($averageRating); ?></p>
                    <a href="<?php echo htmlspecialchars($infoLink); ?>" class="btn btn-primary btn-sm"><i
                            class="bi bi-robot"></i> AI Summary</a>
                </div>
            </div>
            <?php
                }
            } else {
                echo '<p class="text-center w-100 mt-5">No books found for your search.</p>';
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>