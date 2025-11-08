<?php
session_start();
require_once('../../controller/db/database.php');

// Get the author ID from the URL
$author_id = $_GET['id'] ?? null;
if (!$author_id || !is_numeric($author_id)) {
    // If no valid ID is provided, redirect to the main authors page
    header("Location: authors_book.php");
    exit();
}

// --- DATA FETCHING ---
// 1. Fetch the details for this specific author
$stmt_author = $pdo->prepare("SELECT user_id, username, profile_image FROM users WHERE user_id = ? AND role = 'author'");
$stmt_author->execute([$author_id]);
$author = $stmt_author->fetch();

// If no author is found with that ID, redirect away
if (!$author) {
    header("Location: authors.php");
    exit();
}

// 2. Fetch all "Published" books by this specific author
$stmt_books = $pdo->prepare("
    SELECT * FROM books
    WHERE author_id = ? AND status = 'Published'
    ORDER BY created_at DESC
");
$stmt_books->execute([$author_id]);
$books = $stmt_books->fetchAll();

// Fetch logged-in user data for the sidebar
if (isset($_SESSION['user_id'])) {
    $stmt_user = $pdo->prepare("SELECT username, profile_image FROM users WHERE user_id = ?");
    $stmt_user->execute([$_SESSION['user_id']]);
    $user = $stmt_user->fetch();
    $username = $user['username'] ?? 'User';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile of <?php echo htmlspecialchars($author['username']); ?> | bookSpace</title>
    <!-- Your standard Bootstrap, Fonts, and CSS links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../../asst/css/style.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="d-flex" style="min-height: 100vh;">

        <main class="flex-grow-1 p-4">
            <!-- Author Profile Header -->
            <div class="text-center border-bottom pb-4 mb-4">
                <img src="../../uploads/<?php echo htmlspecialchars($author['profile_image'] ?? 'default-avatar.png'); ?>"
                    alt="Author Avatar" class="profile-avatar" style="width: 120px; height: 120px;">
                <h1 class="main-title mt-3"><?php echo htmlspecialchars($author['username']); ?></h1>
                <p class="page-subtitle">Author on bookSpace</p>
            </div>

            <h2 class="h4 card-section-title mb-4">Published Works</h2>

            <!-- Grid of the author's books -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php if (empty($books)): ?>
                <div class="col">
                    <p><?php echo htmlspecialchars($author['username']); ?> has not published any books yet.</p>
                </div>
                <?php else: ?>
                <?php foreach ($books as $book): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 book-card">
                        <a href="book_details.php?id=<?php echo $book['book_id']; ?>">
                            <img src="../../uploads/<?php echo htmlspecialchars($book['cover_image'] ?? 'default-cover.png'); ?>"
                                class="card-img-top" style="height: 300px; object-fit: cover;" alt="Cover">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title" style="font-family: 'Lora', serif;">
                                <?php echo htmlspecialchars($book['title']); ?></h5>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>

</html>