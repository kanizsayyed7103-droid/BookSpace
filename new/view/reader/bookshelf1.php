<?php
session_start();
require_once '../../controller/db/database.php';

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Fetch author's books
$my_books = [];
if ($role === 'author') {
    $stmt_my_books = $pdo->prepare("SELECT book_id, title, genre, views, created_at, status, cover_image 
                                    FROM books 
                                    WHERE author_id = ? 
                                    ORDER BY created_at DESC");
    $stmt_my_books->execute([$user_id]);
    $my_books = $stmt_my_books->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch general bookshelf
$stmt = $pdo->query("SELECT * FROM bookshelf ORDER BY id DESC");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace | Bookshelf</title>
    <style>
    :root {
        --purple: #5e35b1;
        --lavender: #a18cd1;
        --white: #fff;
        --gray: #f3f3f3;
        --text-dark: #333;
        --shadow: rgba(0, 0, 0, 0.15);
    }

    body {
        margin: 0;
        font-family: "Poppins", sans-serif;
        background: var(--lavender);
        color: var(--text-dark);
    }

    .main-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 30px 50px;
        gap: 30px;
    }

    /* Left side - Bookshelf */
    .books-section {
        flex: 3;
        background: #fff;
        padding: 25px;
        border-radius: 14px;
        box-shadow: 0 4px 14px var(--shadow);
    }

    .books-section h2 {
        text-align: center;
        color: var(--purple);
        margin-bottom: 20px;
    }

    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }

    .book-card {
        background: var(--white);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px var(--shadow);
        transition: transform 0.3s;
        text-align: center;
        position: relative;
    }

    .book-card:hover {
        transform: translateY(-6px);
    }

    .book-card img {
        width: 100%;
        height: 240px;
        object-fit: cover;
    }

    .book-info {
        padding: 10px;
    }

    .book-info h3 {
        margin: 6px 0;
        font-size: 16px;
        color: var(--text-dark);
    }

    .book-info p {
        margin: 2px 0;
        color: #666;
        font-size: 14px;
    }

    .delete-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ff4d4d;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        cursor: pointer;
        font-size: 16px;
    }

    /* Right side - Add Book form */
    .add-book-form {
        flex: 1;
        background: #fff;
        padding: 25px;
        border-radius: 14px;
        box-shadow: 0 4px 14px var(--shadow);
        max-width: 400px;
        align-self: flex-start;
    }

    .add-book-form h2 {
        text-align: center;
        color: var(--purple);
        margin-bottom: 15px;
    }

    .add-book-form input,
    .add-book-form select,
    .add-book-form button {
        width: 100%;
        padding: 10px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
    }

    .add-book-form button {
        background: var(--purple);
        color: #fff;
        border: none;
        cursor: pointer;
        font-weight: 500;
    }

    .add-book-form button:hover {
        background: #4527a0;
    }

    .cover-preview {
        text-align: center;
        margin-bottom: 15px;
    }

    .cover-preview img {
        width: 150px;
        border-radius: 10px;
        box-shadow: 0 3px 10px var(--shadow);
    }

    @media (max-width: 992px) {
        .main-container {
            flex-direction: column;
            align-items: center;
        }

        .add-book-form {
            max-width: 100%;
        }
    }

    .chat-header {
        background: #392568ff;
        color: #fff !important;
        padding: 18px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: 'Cinzel Decorative', cursive;
        font-size: 1.2rem;
        letter-spacing: 0.5px;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="main-container">
        <!-- Left side (Books) -->
        <div class="books-section">
            <?php if ($role === 'author'): ?>
            <h2>Your Published Books</h2>
            <?php if (empty($my_books)): ?>
            <p style="text-align:center;">You haven’t published any books yet.</p>
            <?php else: ?>
            <div class="books-grid">
                <?php foreach ($my_books as $book): ?>
                <div class="book-card">
                    <img src="<?php echo "../" . htmlspecialchars($book['cover_image']); ?>" alt="Book">
                    <div class="book-info">
                        <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                        <p><?php echo htmlspecialchars($book['genre']); ?></p>
                        <p>Views: <?php echo htmlspecialchars($book['views']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php else: ?>
            <h2 class="chat-header">Your Reading Room</h2>
            <div class="books-grid">
                <?php foreach ($books as $book): ?>
                <div class="book-card" data-id="<?= $book['id'] ?>">
                    <button class="delete-btn" data-id="<?= $book['id'] ?>">×</button>
                    <img src="<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                    <div class="book-info">
                        <h3><?= htmlspecialchars($book['title']) ?></h3>
                        <p><?= htmlspecialchars($book['author']) ?></p>
                        <p>⭐ <?= htmlspecialchars($book['rating']) ?></p>
                        <a href="<?= htmlspecialchars($book['file_url']) ?>" class="btn btn-primary">View</a>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
            <?php endif; ?>

        </div>

        <?php if ($role === 'reader'): ?>
        <?php endif; ?>


        <script>
        document.getElementById('bookTitle')?.addEventListener('blur', function() {
            const title = this.value.trim();
            if (!title) return;
            const apiUrl = `https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(title)}`;
            fetch(apiUrl)
                .then(res => res.json())
                .then(data => {
                    if (data.items && data.items.length > 0) {
                        const book = data.items[0].volumeInfo;
                        const thumbnail = book.imageLinks ? book.imageLinks.thumbnail :
                            "https://via.placeholder.com/150x230?text=No+Cover";
                        const author = book.authors ? book.authors.join(', ') : "";
                        document.getElementById('bookCover').src = thumbnail;
                        document.getElementById('bookAuthor').value = author;
                        document.getElementById('coverUrl').value = thumbnail;
                    }
                })
                .catch(() => {
                    document.getElementById('bookCover').src =
                        "https://via.placeholder.com/150x230?text=Error";
                });
        });
        </script>
        <script>
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const bookId = this.dataset.id;

                if (!confirm("Are you sure you want to delete this book?")) return;

                fetch("../../controller/delete_book.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `book_id=${bookId}`
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert("Book deleted successfully!");
                            this.closest('.book-card').remove();
                        } else {
                            alert("Error deleting book: " + data.message);
                        }
                    })
                    .catch(() => alert("Server error, please try again."));
            });
        });
        </script>



</body>

</html>