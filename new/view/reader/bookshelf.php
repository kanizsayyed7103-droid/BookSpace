<?php
$host = "localhost";   // XAMPP default
$user = "root";        // XAMPP default user
$pass = "";            // XAMPP default password
$db   = "bookspace";

// Connect to DB
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If POST request (Add Book)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $rating = $_POST['rating'];
    $cover = $_POST['cover'];

    $stmt = $conn->prepare("INSERT INTO books (title, author, rating, cover) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $title, $author, $rating, $cover);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
}

// If GET request (Fetch Books)
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $result = $conn->query("SELECT * FROM books ORDER BY book_id");
    $books = [];
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    echo json_encode($books);
}

$conn->close();
?>
<div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <h3>Genres</h3>
        <label><input type="checkbox"> Fantasy</label>
        <label><input type="checkbox"> Sci-Fi</label>
        <label><input type="checkbox"> History</label>
        <label><input type="checkbox"> Cookbooks</label>

        <h3>Authors</h3>
        <label><input type="checkbox"> Khaled Hosseini</label>
        <label><input type="checkbox"> Dan Brown</label>

        <h3>Rating</h3>
        <label><input type="checkbox"> 4★ & above</label>
        <label><input type="checkbox"> 3★ & above</label>
    </aside>

    <!-- Bookshelf -->
    <main class="bookshelf">
        <h2>Explore the Bookshelf</h2>
        <?php ?>
        <div class="book-grid" id="bookGrid">
            <!-- Book Card -->
            <?php if ($id!=""): ?>
            <?php foreach ($my_books as $book): ?>


            <div class="book-card">
                <img src="<?php echo "../".$book['cover_image']; ?>" alt="Book">
                <div class="book-title"><?php echo $book['title']; ?></div>
                <div class="book-author"><?php echo $book['username']; ?></div>
                <div class="book-rating"><?php echo $book['genre']; ?></div>
                <button class="summary-btn"><?php echo $book['views']; ?></button>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="book-card">
                <img src="https://covers.openlibrary.org/b/id/8228691-L.jpg" alt="Book">
                <div class="book-title">The Kite Runner</div>
                <div class="book-author">Khaled Hosseini</div>
                <div class="book-rating">⭐ 4.5</div>
                <button class="summary-btn">AI Summary</button>
            </div>
            <div class="book-card">
                <img src="https://covers.openlibrary.org/b/id/10594740-L.jpg" alt="Book">
                <div class="book-title">Infernal Devices</div>
                <div class="book-author">K.W. Jeter</div>
                <div class="book-rating">⭐ 4.0</div>
                <button class="summary-btn">AI Summary</button>
            </div>
            <?php endif; ?>

        </div>

        <!-- Add Book Form -->
        <div class="add-book-form">
            <h3>Add Your Book</h3>
            <input type="text" id="title" placeholder="Book Title" required>
            <input type="text" id="author" placeholder="Author Name" required>
            <input type="number" step="0.1" min="0" max="5" id="rating" placeholder="Rating (0-5)" required>
            <input type="text" id="cover" placeholder="Cover Image URL" required>
            <button onclick="addBook()">Add Book</button>
        </div>
    </main>
</div>

<script>
// Fetch books from backend when page loads
window.onload = function() {
    fetch("backend.php")
        .then(res => res.json())
        .then(data => {
            const grid = document.getElementById("bookGrid");
            data.forEach(book => {
                const card = document.createElement("div");
                card.classList.add("book-card");
                card.innerHTML = `
                    <img src="${book.cover}" alt="Book">
                    <div class="book-title">${book.title}</div>
                    <div class="book-author">${book.author}</div>
                    <div class="book-rating">⭐ ${book.rating}</div>
                    <button class="summary-btn">AI Summary</button>
                `;
                grid.appendChild(card);
            });
        });
};

// Add book via backend
function addBook() {
    const title = document.getElementById("title").value;
    const author = document.getElementById("author").value;
    const rating = document.getElementById("rating").value;
    const cover = document.getElementById("cover").value;
    if (title && author && rating && cover) {
        const formData = new FormData();
        formData.append("title", title);
        formData.append("author", author);
        formData.append("rating", rating);
        formData.append("cover", cover);

        fetch("backend.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(response => {
                if (response === "success") {
                    alert("Book added successfully!");
                    location.reload(); // reload to fetch new book
                } else {
                    alert("Error adding book.");
                }
            });
    } else {
        alert("Please fill all fields!");
    }
}
</script>
</body>

</html>