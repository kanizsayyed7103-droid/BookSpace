<?php
session_start();
require_once './db/database.php'; // Adjust path if needed

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Fetch current user data
    $stmt = $pdo->prepare("SELECT username, email, first_name, last_name, profile_image FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$currentUser) {
        throw new Exception("User not found.");
    }
} catch (PDOException $e) {
    die("❌ Database error fetching user: " . $e->getMessage());
}

// Collect new values from form
$newUsername   = $_POST['username'] ?? '';
$newEmail      = $_POST['email'] ?? '';
$newFirstName  = $_POST['first_name'] ?? '';
$newLastName   = $_POST['last_name'] ?? '';
$newProfileImagePath = $currentUser['profile_image']; // default (keep existing)

// Flag to check if a new image was uploaded
$imageUploaded = false;

// ---------- HANDLE IMAGE UPLOAD ----------
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "../view/reader/uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = uniqid('profile_', true) . '.' . pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
    $targetFilePath = $targetDir . $fileName;

    // Allow only image formats
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFilePath)) {
            $newProfileImagePath = "/BookSpace_project/new/view/reader/uploads/" . $fileName;
            $imageUploaded = true;
        } else {
            die("❌ Failed to upload the image. Please try again.");
        }
    } else {
        die("❌ Invalid file type. Only JPG, PNG, and GIF are allowed.");
    }
}

// ---------- CHECK IF CHANGES WERE MADE ----------
if (
    $currentUser['username'] !== $newUsername ||
    $currentUser['email'] !== $newEmail ||
    $currentUser['first_name'] !== $newFirstName ||
    $currentUser['last_name'] !== $newLastName ||
    $imageUploaded
) {
    // ---------- UPDATE DATABASE ----------
    try {
        $sql = "UPDATE users 
                SET username = ?, email = ?, first_name = ?, last_name = ?, profile_image = ? 
                WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $newUsername,
            $newEmail,
            $newFirstName,
            $newLastName,
            $newProfileImagePath,
            $user_id
        ]);

        // Update session variables
        $_SESSION['username'] = $newUsername;
        $_SESSION['email'] = $newEmail;
        $_SESSION['first_name'] = $newFirstName;
        $_SESSION['last_name'] = $newLastName;
        $_SESSION['profile_image'] = $newProfileImagePath;

        // Redirect back to profile with success message
        header("Location: ../view/reader/profile.php?status=success");
        exit();

    } catch (PDOException $e) {
        die("❌ Database error updating user: " . $e->getMessage());
    }
} else {
    // No changes detected
    header("Location: ../view/reader/profile.php?status=nochange");
    exit();
}
?>