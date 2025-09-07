<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace | My Bookshelf</title>
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

    .book-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        padding: 20px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .book-card img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .book-title {
        font-weight: bold;
        font-size: 1.1em;
        margin-bottom: 5px;
        color: var(--color-deep-purple);
    }

    .book-author {
        color: var(--color-text);
        font-size: 0.9em;
    }

    .add-book-form {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        margin-bottom: 2rem;
        width: 100%;
        max-width: 600px;
    }

    /* Add Book Button Style */
    .btn-add-book {
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

    .btn-add-book:hover {
        background: var(--color-highlight);
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
                <li><a href="bookshelf1.php" class="nav-link">Bookshelf</a></li>
                <li><a href="cost.php" class="nav-link">Cost</a></li>
                <li><a href="contact.html" class="nav-link">Contact</a></li>
                <li><a href="chatbot.html" class="nav-link">AI Chatbot</a></li>
                <li><a href="authors.html" class="nav-link">Authors</a></li>
            </ul>
            <!-- Logout -->
            <button class="btn btn-logout mt-3">LOGOUT</button>
        </div>

        <!-- Main Content Area -->
        <div class="main-content-wrapper">
            <div class="container-fluid">
                <div class="row w-100 justify-content-center">
                    <div class="col-12 text-center mb-4">
                        <h2 class="mb-4">Explore My Bookshelf</h2>
                    </div>
                </div>

                <!-- Bookshelf Grid -->
                <div class="row w-100 mt-4 g-4 justify-content-center">
                    <!-- Example Book Cards -->
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="book-card">
                            <img src="https://placehold.co/300x450/fbc2eb/3a2d5c?text=Book+1" alt="Book Cover 1">
                            <div class="book-info">
                                <div class="book-title">The Book Title</div>
                                <div class="book-author">Author Name</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="book-card">
                            <img src="https://placehold.co/300x450/fbc2eb/3a2d5c?text=Book+2" alt="Book Cover 2">
                            <div class="book-info">
                                <div class="book-title">Another Great Read</div>
                                <div class="book-author">Jane Doe</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="book-card">
                            <img src="https://placehold.co/300x450/fbc2eb/3a2d5c?text=Book+3" alt="Book Cover 3">
                            <div class="book-info">
                                <div class="book-title">Mystery of the Woods</div>
                                <div class="book-author">John Smith</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="book-card">
                            <img src="https://placehold.co/300x450/fbc2eb/3a2d5c?text=Book+4" alt="Book Cover 4">
                            <div class="book-info">
                                <div class="book-title">Sci-Fi Adventures</div>
                                <div class="book-author">A. Writer</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Book Form -->
                <div class="row w-100 justify-content-center mt-4">
                    <div class="col-12 col-md-10 col-lg-8 add-book-form">
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
                                <label for="bookCover" class="form-label">Book Cover URL (Optional)</label>
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
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>