<?php
session_start();
require_once 'db/database.php';

// Only allow POST requests from logged-in users
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$book_id = $input['book_id'] ?? null;
$rating = $input['rating'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$book_id || !$rating || !is_numeric($book_id) || !is_numeric($rating) || $rating < 1 || $rating > 5) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit();
}

// --- NEW, MORE ROBUST RATING LOGIC ---
try {
    // For a professional system, we'll use a separate 'ratings' table
    // to prevent a user from rating the same book multiple times.
   
    // First, check if the user has already rated this book
    $stmt_check = $pdo->prepare("SELECT * FROM ratings WHERE book_id = ? AND user_id = ?");
    $stmt_check->execute([$book_id, $user_id]);
    if ($stmt_check->fetch()) {
        // User has already rated, send back an info message
        http_response_code(409); // 409 Conflict
        echo json_encode(['success' => false, 'message' => 'You have already rated this book.']);
        exit();
    }

    // If they haven't rated, insert their new rating
    $stmt_insert = $pdo->prepare("INSERT INTO ratings (book_id, user_id, rating) VALUES (?, ?, ?)");
    $stmt_insert->execute([$book_id, $user_id, $rating]);

    // Now, recalculate the new average rating for the 'books' table
    $stmt_avg = $pdo->prepare("
        SELECT AVG(rating) as avg_rating, COUNT(rating) as rating_count
        FROM ratings
        WHERE book_id = ?
    ");
    $stmt_avg->execute([$book_id]);
    $new_stats = $stmt_avg->fetch();
   
    // Update the main 'books' table with the new average and count
    $stmt_update_book = $pdo->prepare("UPDATE books SET rating = ?, rating_count = ? WHERE book_id = ?");
    $stmt_update_book->execute([$new_stats['avg_rating'], $new_stats['rating_count'], $book_id]);

    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'Thank you for rating!', 'new_average' => number_format($new_stats['avg_rating'], 2)]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>