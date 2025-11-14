<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $rating = $_POST['rating'] ?? 0;
    $file_url = trim($_POST['file_url']);
$flag = trim($_POST['flag']);
    // Fetch from Google Books API
    if($flag==='api')
    {
    $apiUrl = "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($title);
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    $cover = '';
    if (!empty($data['items'][0]['volumeInfo']['imageLinks']['thumbnail'])) {
        $cover = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
    } else {
        $cover = 'https://via.placeholder.com/150x230?text=No+Cover';
    }
}
else{
        $cover = trim($_POST['coverURL']);

}

    // $stmt = $pdo->prepare("INSERT INTO bookshelf (title, author, rating, cover) VALUES (?, ?, ?, ?)");
    // $stmt->execute([$title, $author, $rating, $cover]);
// Check if book already exists
$check = $pdo->prepare("SELECT COUNT(*) FROM bookshelf WHERE title = ? AND author = ?");
$check->execute([$title, $author]);
$exists = $check->fetchColumn();

if ($exists == 0) {
    // Insert new book
    $stmt = $pdo->prepare("INSERT INTO bookshelf (title, author, rating, cover,file_url) VALUES (?, ?, ?, ?,?)");
    $stmt->execute([$title, $author, $rating, $cover,$file_url]);
} else {
   // echo "This book already exists!";
}


    header("Location: ../../view/reader/bookshelf1.php");
    exit;
}
?>