<?php
require_once '../../controller/db/database.php';

// Fetch books from DB
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

    .dashboard-container {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 40px 60px;
        gap: 50px;
    }

    /* ===== BOOKS SECTION ===== */
    .books-section {
        flex: 3;
    }

    .books-section h2 {
        color: #5e35b1;
        margin-bottom: 25px;
        font-size: 24px;
        font-weight: 600;
    }

    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 25px;
    }

    .book-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
    }

    .book-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .book-card img {
        width: 100%;
        height: 240px;
        object-fit: cover;
    }

    .book-info {
        padding: 12px;
    }

    .book-info h3 {
        font-size: 16px;
        color: #333;
        margin: 8px 0 5px;
    }

    .book-info p {
        color: #666;
        font-size: 14px;
        margin: 0;
    }

    .delete-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ff4d4d;
        border: none;
        color: white;
        font-size: 13px;
        padding: 6px 9px;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.3s;
    }

    .delete-btn:hover {
        background: #e53935;
    }

    /* ===== ADD BOOK FORM ===== */
    .add-book-form {
        flex: 1;
        max-width: 380px;
        background: #ffffff;
        padding: 30px 25px;
        border-radius: 16px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        align-self: flex-start;
    }

    .add-book-form h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #5e35b1;
        font-size: 22px;
    }

    .add-book-form input,
    .add-book-form select,
    .add-book-form button {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 15px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 15px;
    }

    .add-book-form input:focus,
    .add-book-form select:focus {
        border-color: #7e57c2;
        outline: none;
    }

    .add-book-form button {
        background-color: #5e35b1;
        color: white;
        border: none;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.3s;
    }

    .add-book-form button:hover {
        background-color: #4527a0;
    }

    .cover-preview {
        text-align: center;
        margin-bottom: 15px;
    }

    .cover-preview img {
        width: 150px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 900px) {
        .dashboard-container {
            flex-direction: column;
            padding: 25px;
        }

        .add-book-form {
            max-width: 100%;
        }
    }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="dashboard-container">

        <!-- BOOK LIST -->
        <div class="books-section">
            <h2>Recommended Books</h2>
            <div class="books-grid">
                <?php
            $count = 0;
            foreach ($books as $book):
                if ($count >= 4) break; // Limit to 4 books
            ?>
                <div class="book-card">
                    <form action="../../controller/db/delete_book.php" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this book?');">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
                        <button class="delete-btn" title="Delete Book">&times;</button>
                    </form>
                    <img src="<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                    <div class="book-info">
                        <h3><?= htmlspecialchars($book['title']) ?></h3>
                        <p><?= htmlspecialchars($book['author']) ?></p>
                        <p>⭐ <?= htmlspecialchars($book['rating']) ?></p>
                    </div>
                </div>
                <?php
                $count++;
            endforeach;
            ?>
            </div>
        </div>

        <!-- ADD BOOK FORM -->
        <div class="add-book-form">
            <h2>Add a New Book</h2>
            <div class="cover-preview">
                <img id="bookCover" src="https://via.placeholder.com/150x230?text=Preview" alt="Book cover preview">
            </div>
            <form action="../../controller/db/add_book.php" method="POST" id="bookForm">
                <input type="text" name="title" id="bookTitle" placeholder="Enter book title" required>
                <input type="text" name="author" id="bookAuthor" placeholder="Author name" required>
                <select name="rating" required>
                    <option value="" disabled selected>Rating</option>
                    <option value="5">5</option>
                    <option value="4.5">4.5</option>
                    <option value="4">4</option>
                    <option value="3.5">3.5</option>
                    <option value="3">3</option>
                </select>
                <input type="hidden" name="cover" id="coverUrl">
                <button type="submit">Add Book</button>
            </form>
        </div>

    </div>

    <!-- GOOGLE BOOKS API SCRIPT -->
    <script>
    document.getElementById('bookTitle').addEventListener('blur', function() {
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
                } else {
                    document.getElementById('bookCover').src =
                        "https://via.placeholder.com/150x230?text=No+Cover";
                }
            })
            .catch(() => {
                document.getElementById('bookCover').src = "https://via.placeholder.com/150x230?text=Error";
            });
    });
    </script>

</body>

</html>