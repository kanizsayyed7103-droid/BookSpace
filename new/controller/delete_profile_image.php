<?php
session_start();
require_once '../../controller/db/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /BookSpace_project/new/index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current profile image
$stmt = $pdo->prepare("SELECT profile_image FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && !empty($user['profile_image'])) {
    $image_path = $_SERVER['DOCUMENT_ROOT'] . $user['profile_image'];

    // Delete old image file if it exists and is not the default one
    if (file_exists($image_path) && basename($user['profile_image']) !== 'default.jpg') {
        unlink($image_path);
    }
}

// Set default image in DB
$default_image = '/BookSpace_project/default.jpg';
$update = $pdo->prepare("UPDATE users SET profile_image = ? WHERE user_id = ?");
$update->execute([$default_image, $user_id]);

// Update session value
$_SESSION['profile_image'] = $default_image;

// Redirect back with success message
header("Location: /BookSpace_project/new/view/reader/profile.php?deleted=1");
exit();
?>