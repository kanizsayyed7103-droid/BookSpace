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
    <title>BookSpace | My Bookshelf</title>
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

    /* --- Main Content Layout --- */
    .main-content-wrapper {
        padding: 20px;
        width: 100%;
        min-height: calc(100vh - 70px);
    }

    /* Custom class for 4 books per row on large screens inside a col-lg-8 (Perfect fit!) */
    @media (min-width: 992px) {
        .col-lg-1-4 {
            flex: 0 0 auto;
            width: 25%;
            /* 4 books per row in an 8-column space */
        }
    }

    /* Fallback for smaller screens: 2 books per row */
    @media (max-width: 991.98px) {
        .col-6 {
            width: 50%;
        }
    }


    /* --- Book Card Minimization --- */
    .book-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 8px;
        text-align: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .book-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .book-card img {
        width: 100%;
        aspect-ratio: 2 / 3;
        height: auto;
        border-radius: 6px;
        margin-bottom: 5px;
    }

    .book-title {
        font-weight: 600;
        font-size: 0.95em;
        line-height: 1.2;
        min-height: 34px;
        margin-bottom: 3px;
        color: var(--color-deep-purple);
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .book-author {
        color: var(--color-text);
        font-size: 0.85em;
        margin-top: 2px;
    }

    /* --- Form Minimization --- */
    .add-book-form {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        max-width: none;
        margin-top: 50px;
    }

    .add-book-form .form-label,
    .add-book-form .form-control {
        font-size: 0.9rem;
    }

    .add-book-form .form-control {
        padding: 0.375rem 0.75rem;
    }

    .btn-add-book {
        padding: 8px 15px;
        font-size: 0.9rem;
        border-radius: 20px;
        background: #ac91f1ff;
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

    <div class="main-content-wrapper">
        <div class="container-fluid">
            <div class="row w-100">
                <div class="col-12 text-center mb-4">
                    <h2 class="mb-4">Explore My Bookshelf</h2>
                </div>
            </div>

            <div class="row w-100 g-4">

                <div class="col-12 col-lg-8">
                    <h4 class="mb-3">My Current Reads</h4>
                    <div class="row g-3">

                        <div class="col-6 col-md-4 col-lg-1-4">
                            <div class="book-card">
                                <img src="https://placehold.co/300x450/a18cd1/3a2d5c?text=Book+1" alt="Book Cover 1">
                                <div class="book-info">
                                    <div class="book-title">The Book Title Can Be Very Long</div>
                                    <div class="book-author">Author Name</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4 col-lg-1-4">
                            <div class="book-card">
                                <img src="https://placehold.co/300x450/a18cd1/3a2d5c?text=Book+2" alt="Book Cover 2">
                                <div class="book-info">
                                    <div class="book-title">Another Great Read</div>
                                    <div class="book-author">Jane Doe</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4 col-lg-1-4">
                            <div class="book-card">
                                <img src="https://placehold.co/300x450/a18cd1/3a2d5c?text=Book+3" alt="Book Cover 3">
                                <div class="book-info">
                                    <div class="book-title">Mystery of the Woods: Part II</div>
                                    <div class="book-author">John Smith</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4 col-lg-1-4">
                            <div class="book-card">
                                <img src="https://placehold.co/300x450/a18cd1/3a2d5c?text=Book+4" alt="Book Cover 4">
                                <div class="book-info">
                                    <div class="book-title">Sci-Fi Adventures</div>
                                    <div class="book-author">A. Writer</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="add-book-form">
                        <h4 class="text-center mb-3">Add a New Book</h4>
                        <form action="#" method="post">
                            <div class="mb-3">
                                <label for="bookTitle" class="form-label">Book Title</label>
                                <input type="text" class="form-control" id="bookTitle" placeholder="Enter book title">
                            </div>
                            <div class="mb-3">
                                <label for="bookAuthor" class="form-label">Author Name</label>
                                <input type="text" class="form-control" id="bookAuthor" placeholder="Enter author name">
                            </div>
                            <div class="mb-3">
                                <label for="bookCover" class="form-label">Cover URL (Optional)</label>
                                <input type="text" class="form-control" id="bookCover"
                                    placeholder="Paste image URL here">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-add-book">Add Book</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>