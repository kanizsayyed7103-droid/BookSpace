<?php
session_start();
require_once 'db/database.php'; // adjust if needed

// ✅ Optional: if you want only logged-in users to delete
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

if (!isset($_POST['book_id']) || empty($_POST['book_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Book ID missing']);
    exit;
}

$book_id = intval($_POST['book_id']);

try {
    $stmt = $pdo->prepare("DELETE FROM bookshelf WHERE id = ?");
    $stmt->execute([$book_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Book not found']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>