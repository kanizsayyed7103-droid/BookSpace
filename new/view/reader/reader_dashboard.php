<!DOCTYPE html>
<html lang="en">
<?php
require_once '../../controller/db/database.php';

// PHP logic to fetch books from Google Books API
$q = urlencode($_POST['search'] ?? 'harry potter'); // Your search query
// NOTE: For security, never hardcode API keys in public code. Use environment variables.
$key = 'AIzaSyCOCuStWqupRkpuhuYgeG4tqGYUDIsizns'; // Replace with your actual key
$url = "https://www.googleapis.com/books/v1/volumes?q={$q}&key={$key}&maxResults=10";
session_start();

// Fetch and decode the JSON data
$json = file_get_contents($url);
$data = json_decode($json, true);
// echo json_encode($data);
if (isset($_SESSION['role'])) {
   if( $_SESSION['role'] == 'author'){
    header("Location: ../author_dashboard.php");
   };
}


// Start the session
// Set a placeholder role if session isn't set (for testing)
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'Reader';
}

$my_books = [];
$stmt_my_books = $pdo->prepare("SELECT book_id,rating, title,username, cover_image, genre, views ,status FROM books JOIN users ON books.author_id = users.user_id Where books.status='Published'  ORDER BY books.created_at DESC;");
$stmt_my_books->execute();
$my_books = $stmt_my_books->fetchAll(PDO::FETCH_ASSOC);
// echo json_encode($my_books);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Cinzel+Decorative:wght@700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Lora:wght@400;600&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
        font-family: 'Poppins', sans-serif;
        background: var(--color-lavender);
        color: var(--color-text);
    }

    .books {
        padding: 30px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        justify-items: center;
    }

    /* bookcard style */

    .book-card {
        background-color: #ddcffeff;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        text-align: center;
        width: 100%;
        max-width: 230px;
        transition: transform 0.2s,
            box-shadow 0.2s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.7);
    }

    .book-card img {
        width: 100%;
        height: auto;
        max-height: 250px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    }

    .book-info {
        text-align: left;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .book-info h3 {
        margin: 0 0 5px 0;
        font-size: 1em;
        font-weight: 600;
        line-height: 1.2;
        color: var(--text-light);
    }

    .book-info p {
        font-size: 0.85em;
        color: var(--text-secondary);
        margin: 0 0 10px 0;
        flex-grow: 1;
    }

    /* Rating Style */
    .rating {
        display: flex;
        align-items: center;
        font-size: 0.9em;
        color: var(--rating-color);
        margin-bottom: 10px;
    }

    /* AI Summary Button */
    .btn {
        display: block;
        background-color: var(--primary-color);
        color: white !important;
        border: none;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.85em;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 10px;
    }

    .btn:hover {
        background-color: #af52c0;
    }

    /* Optional: Basic responsiveness */
    @media (max-width: 768px) {
        .header {
            padding: 10px 15px;
        }

        .books {
            padding: 15px;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }
    }

    /* Filter bar styling */
    .filter-bar {
        background-color: #b39ddb;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        border-radius: 10px;
        width: fit-content;
        margin: 20px auto;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .filter-bar label {
        font-weight: 600;
        color: #3e1d6d;
    }

    .filter-bar select {
        padding: 8px 12px;
        border: none;
        border-radius: 8px;
        outline: none;
        background-color: #fff;
        color: #3e1d6d;
        font-weight: 500;
    }

    <style>.btn-success {
        background-color: #4CAF50;
        color: white;
    }

    .btn-success:hover {
        background-color: #45a049;
    }

    .btn-secondary {
        background-color: #999;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #777;
    }
    </style>

    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="filter-bar">
        <label for="authorFilter">Filter by Author:</label>
        <select id="authorFilter" onchange="filterBooks()">
            <option value="all">All Authors</option>
            <?php 
              $uniqueAuthors = [];
                foreach ($data['items'] as $item) {
                    if (!empty($item['volumeInfo']['authors'])) {
                        // foreach ($item['volumeInfo']['authors'] as $author) {
                            // $uniqueAuthors[$author] = true; // store unique
                             $author_slug = str_replace([' ', '.',','], '_', implode(', ', $item['volumeInfo']['authors']));
                            $uniqueAuthors[$author_slug] = implode(', ', $item['volumeInfo']['authors']); // store slug → real name
                        // }
                    }
                }
                //  echo json_encode($my_books);

                foreach ($my_books as $book) {
                //  echo json_encode($my_books);
                    if (!empty($book['username'])) {
                        // foreach ($book['username'] as $username) {
                            // echo $username;
                            //$uniqueAuthors[$book['username']] = true; // store unique
                             $author_slug = str_replace([' ', '.',','], '_', $book['username']);
                            $uniqueAuthors[$author_slug] = $book['username']; // store slug → real name
                        // }
                    }
                }
                // Output unique author options
                foreach ($uniqueAuthors as $slug => $name) {
                    echo "<option value=\"{$slug}\">{$name}</option>";
                }
            ?>


        </select>
    </div>
    <div class="books">

        <?php
// Display local DB books
if (!empty($my_books)) {
    foreach ($my_books as $book) {
        $title = $book['title'] ?? 'No Title';
        $authors = $book['username'] ?? 'Unknown Author';
        $cover = "../../uploads/" . ($book['cover_image'] ?? 'https://via.placeholder.com/150');
        $rating = $book['rating'] ?? 'N/A';
        $infoLink = "book_details.php?id=" . ($book['book_id'] ?? '#');
        $author_slug = str_replace([' ', '.', ','], '_', $authors);
        ?>

        <div class="book-card" data-author="<?= htmlspecialchars($author_slug) ?>">
            <img src="<?= htmlspecialchars($cover) ?>" alt="Book Cover">
            <div class="book-info">
                <h3><?= htmlspecialchars($title) ?></h3>
                <p><?= htmlspecialchars($authors) ?></p>
                <div class="rating">⭐ <?= htmlspecialchars($rating) ?></div>

                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= htmlspecialchars($infoLink) ?>" class="btn btn-primary">View</a>
                <button class="btn btn-success mt-2" onclick="addToBookshelf(
                             '<?= addslashes($title) ?>',
                            '<?= addslashes($authors) ?>',
                            '<?= addslashes($rating) ?>',
                            '<?= addslashes($cover) ?>',
                            'db',
                            '<?= htmlspecialchars($infoLink) ?>'
                        )">
                    Add to Bookshelf
                </button>
                <?php else: ?>
                <a href="#" onclick="confirmActionpt(event)" class="btn btn-primary">View</a>
                <button class="btn btn-secondary mt-2" onclick="loginPrompt()">Add to Bookshelf</button>
                <?php endif; ?>
            </div>
        </div>

        <?php
    }
}

// Loop through the books fetched from the Google Books API
if (!empty($data['items'])) {
    foreach ($data['items'] as $item) { 
        $title = $item['volumeInfo']['title'] ?? 'No Title';
        $authors = isset($item['volumeInfo']['authors']) ? implode(', ', $item['volumeInfo']['authors']) : 'Unknown Author';
        $cover = $item['volumeInfo']['imageLinks']['thumbnail'] ?? 'https://via.placeholder.com/150';
        $rating = $item['volumeInfo']['averageRating'] ?? 'N/A';
        $infoLink = $item['volumeInfo']['infoLink'] ?? '#';
        $author_slug = str_replace([' ', '.', ','], '_', $authors);
        ?>

        <div class="book-card" data-author="<?= htmlspecialchars($author_slug) ?>">
            <img src="<?= htmlspecialchars($cover) ?>" alt="Book Cover">
            <div class="book-info">
                <h3><?= htmlspecialchars($title) ?></h3>
                <p><?= htmlspecialchars($authors) ?></p>
                <div class="rating">⭐ <?= htmlspecialchars($rating) ?></div>

                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= htmlspecialchars($infoLink) ?>" class="btn btn-primary" target='_black'>View</a>
                <button class="btn btn-success mt-2" onclick="addToBookshelf(
                            '<?= addslashes($title) ?>',
                            '<?= addslashes($authors) ?>',
                            '<?= addslashes($rating) ?>',
                            '<?= addslashes($cover) ?>',
                            'db',
                            '<?= htmlspecialchars($infoLink) ?>'
                        )">
                    Add to Bookshelf
                </button>
                <?php else: ?>
                <a href="#" onclick="confirmActionpt(event)" class="btn btn-primary">View</a>
                <button class="btn btn-secondary mt-2" onclick="loginPrompt()">Add to Bookshelf</button>
                <?php endif; ?>
            </div>
        </div>

        <?php
    }
}


?>

        <!-- <div class="book-card">
            <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1733931824i/221228045.jpg"
                alt="Book Cover">
            <div class="book-info">
                <h3>A Study in Drowning #2 A Theory of Dreaming</h3>
                <p>Ava Reid</p>
                <div class="rating">⭐ 3.84</div>
                <a href="#" class="btn">Summary</a>
            </div>
        </div>

        <div class="book-card">
            <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1541428344i/17165596.jpg"
                alt="Book Cover">
            <div class="book-info">
                <h3>The Kite Runner</h3>
                <p>Khaled Hosseini</p>
                <div class="rating">⭐ 4.35</div>
                <a href="#" class="btn">✨ AI Summary</a>
            </div>
        </div> -->
    </div>
</body>

<script>
function filterBooks() {
    const selectedAuthor = document.getElementById("authorFilter").value;
    const books = document.querySelectorAll(".book-card");

    books.forEach(book => {
        const author = book.getAttribute("data-author");
        if (selectedAuthor === "all" || author === selectedAuthor) {
            book.style.display = "block";
        } else {
            book.style.display = "none";
        }
    });
}
</script>
<script>
function addToBookshelf(title, author, rating, coverURL, flag, file_url) {
    // alert("Book " + bookId + " added to your bookshelf!");
    // Prepare data to send
    const formData = new FormData();
    formData.append("title", title);
    formData.append("author", author);
    formData.append("rating", rating);
    formData.append("coverURL", coverURL);
    formData.append("flag", flag);
    formData.append("file_url", file_url);

    // Send data to PHP file
    fetch("/BookSpace_project/new/controller/db/add_bookshelf.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(response => {
            alert("Book Added Successfully");
        })
        .catch(err => console.error("Error:", err));
}



function loginPrompt() {
    event.preventDefault();
    let result = confirm("Please login first to add this book to your bookshelf.");
    if (result) {
        window.location.href = "/BookSpace_project/new/index.php";
    } else {

    }
}
</script>

</html>