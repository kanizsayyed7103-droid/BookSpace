<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $rating = $_POST['rating'] ?? 0;

    // Fetch from Google Books API
    $apiUrl = "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($title);
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    $cover = '';
    if (!empty($data['items'][0]['volumeInfo']['imageLinks']['thumbnail'])) {
        $cover = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
    } else {
        $cover = 'https://via.placeholder.com/150x230?text=No+Cover';
    }

    $stmt = $pdo->prepare("INSERT INTO bookshelf (title, author, rating, cover) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $author, $rating, $cover]);

    header("Location: ../../view/reader/bookshelf1.php");
    exit;
}
?>