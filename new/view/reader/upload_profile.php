<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../controller/db/database.php');

$current_user_id = $_SESSION['user_id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];
    $upload_dir = '../../uploads/profile_pics/';

    // Create folder if not exists
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_name = time() . '_' . basename($file['name']);
    $target_path = $upload_dir . $file_name;
    $db_path = 'uploads/profile_pics/' . $file_name;

    // Move file and update DB
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        $stmt = $pdo->prepare("UPDATE users SET profile_image = ? WHERE user_id = ?");
        $stmt->execute([$db_path, $current_user_id]);
        echo json_encode(['success' => true, 'image' => $db_path]);
    } else {
        echo json_encode(['success' => false, 'message' => 'File upload failed.']);
    }
    exit;
}
?>