<?php
session_start();
// CORRECT PATH: Go up two levels
require_once('../../controller/db/database.php');

// --- DATA FETCHING ---
// Fetch all users who are 'authors' AND have at least one 'Published' book.
// The DISTINCT keyword ensures each author is only listed once.
$stmt = $pdo->query("
    SELECT DISTINCT u.user_id, u.username, u.profile_image
    FROM users u
    JOIN books b ON u.user_id = b.author_id
    WHERE u.role = 'author' AND b.status = 'Published'
    ORDER BY u.username ASC
");
$authors = $stmt->fetchAll();

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
    <title>Discover Authors | bookSpace</title>
    <!-- Your standard Bootstrap, Fonts, and Icons links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../../asst/css/style.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="d-flex" style="min-height: 100vh;">

        <main class="flex-grow-1 p-4">
            <h1 class="main-title">Discover Authors</h1>
            <p class="page-subtitle">Browse our community of talented writers.</p>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 mt-3">
                <?php if (empty($authors)): ?>
                <div class="col">
                    <p>No authors have published books yet. Check back soon!</p>
                </div>
                <?php else: ?>
                <?php foreach ($authors as $author): ?>
                <div class="col">
                    <a href="author_profile.php?id=<?php echo $author['user_id']; ?>" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 text-center author-card">
                            <div class="card-body">
                                <img src="../../uploads/<?php echo htmlspecialchars($author['profile_image'] ?? 'default-avatar.png'); ?>"
                                    alt="Author Avatar" class="profile-avatar mb-3">
                                <h5 class="card-title fw-bold" style="font-family: 'Lora', serif;">
                                    <?php echo htmlspecialchars($author['username']); ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>

</html>