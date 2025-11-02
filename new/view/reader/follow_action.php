<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Include your database connection
require_once('../../controller/db/database.php');

// ✅ Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "not_logged_in";
    exit;
}

$current_user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';
$following_id = $_POST['following_id'] ?? 0;

// ✅ Validate input
if (!$following_id || !in_array($action, ['follow', 'unfollow'])) {
    echo "invalid_request";
    exit;
}

try {
    if ($action === 'follow') {
        // 🔹 Check if already following
        $check = $pdo->prepare("SELECT * FROM follows WHERE follower_id = ? AND following_id = ?");
        $check->execute([$current_user_id, $following_id]);

        if ($check->rowCount() === 0) {
            // 🔹 Add new follow record
            $insert = $pdo->prepare("INSERT INTO follows (follower_id, following_id) VALUES (?, ?)");
            $insert->execute([$current_user_id, $following_id]);
        }

        echo "followed";
    } 
    elseif ($action === 'unfollow') {
        // 🔹 Remove follow record
        $delete = $pdo->prepare("DELETE FROM follows WHERE follower_id = ? AND following_id = ?");
        $delete->execute([$current_user_id, $following_id]);

        echo "unfollowed";
    }
} catch (PDOException $e) {
    echo "error: " . $e->getMessage();
}
?>