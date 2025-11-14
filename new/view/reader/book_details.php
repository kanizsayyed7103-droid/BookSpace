<?php
session_start();
// --- (Your PHP code at the top for fetching data remains exactly the same) ---
require_once('../../controller/db/database.php');
$book_id = $_GET['id'] ?? null;
if (!$book_id || !is_numeric($book_id)) { header("Location: authors_book.php"); exit(); }
if (isset($_SESSION['user_id'])) {
    try {
        $pdo->prepare("UPDATE books SET views = views + 1 WHERE book_id = ?")->execute([$book_id]);
    } catch (PDOException $e) { /* Fail silently */ }
}
$stmt_book = $pdo->prepare("SELECT books.*, users.username FROM books JOIN users ON books.author_id = users.user_id WHERE books.book_id = ? AND books.status = 'Published'");
$stmt_book->execute([$book_id]);
$book = $stmt_book->fetch();
if (!$book) { header("Location: authors_book.php"); exit(); }
if (isset($_SESSION['user_id'])) {
    $stmt_user = $pdo->prepare("SELECT username, profile_image FROM users WHERE user_id = ?");
    $stmt_user->execute([$_SESSION['user_id']]);
    $user = $stmt_user->fetch();
    $username = $user['username'] ?? 'User';

    $stmt_ratings = $pdo->prepare("SELECT * FROM ratings WHERE ratings.book_id = ? AND ratings.user_id = ?");
    $stmt_ratings->execute([$book_id,$_SESSION['user_id']]);
    $ratings = $stmt_ratings->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?> | bookSpace</title>
    <!-- Your standard Bootstrap, Fonts, and CSS links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../../../asst/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    .star-rating i {
        font-size: 24px;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s;
    }

    .star-rating i.hovered,
    .star-rating i.active {
        color: gold;
    }
    </style>
</head>

<body>
    <div class="d-flex">
        <?php include 'navbar.php'; ?>

        <main class="flex-grow-1 p-4 p-md-5">
            <a href="reader_dashboard.php" class="text-decoration-none mb-4 d-inline-block">&larr; Back to Dashboard</a>

            <div class="card p-4 border-0 shadow-sm">
                <div class="row g-4">
                    <!-- Left Column: Book Cover -->
                    <div class="col-lg-4 text-center">
                        <!-- THE CORRECTED IMAGE PATH -->
                        <img src="../../uploads/<?php echo htmlspecialchars($book['cover_image'] ?? 'default-cover.png'); ?>"
                            class="img-fluid rounded shadow" alt="Cover" style="max-height: 500px;">
                    </div>

                    <!-- Right Column: Book Details -->
                    <div class="col-lg-8">
                        <h1 class="display-5 fw-bold" style="font-family: 'Lora', serif;">
                            <?php echo htmlspecialchars($book['title']); ?></h1>
                        <p class="lead fs-5 text-muted" style="font-family: 'Lora', serif;"> by
                            <?php echo htmlspecialchars($book['username']); ?></a>
                        </p>

                        <!-- Displaying Stats -->
                        <div class="d-flex flex-wrap gap-4 text-muted border-top border-bottom py-3 my-4">
                            <span><i class="fas fa-eye me-2"></i> <?php echo htmlspecialchars($book['views']); ?>
                                Views</span>
                            <span><i class="fas fa-star me-2" style='color:#e4e407'></i> <span
                                    id="average-rating"><?php echo htmlspecialchars(number_format((float)($book['rating'] ?? 0), 2)); ?></span>
                                Average Rating</span>

                            <span><i class="fas fa-calendar-alt me-2"></i> Published:
                                <?php echo date('M d, Y', strtotime($book['created_at'])); ?></span>
                        </div>

                        <h2 class="h4" style="font-family: 'Lora', serif;">Description</h2>
                        <p>
                            <?php echo htmlspecialchars($book['description'] ?? 'No synopsis has been provided for this book yet.'); ?>
                        </p>

                        <!-- Rating Feature (remains the same) -->
                        <div class="mt-4">
                            <h3 class="h5" style="font-family: 'Lora', serif;">Rate this Book</h3>
                            <div class="star-rating" data-book-id="<?php echo $book['book_id']; ?>"
                                data-user-rating="<?php echo $ratings['rating'] ?? 0; ?>">
                                <i class="fas fa-star" data-value="1"></i>
                                <i class="fas fa-star" data-value="2"></i>
                                <i class="fas fa-star" data-value="3"></i>
                                <i class="fas fa-star" data-value="4"></i>
                                <i class="fas fa-star" data-value="5"></i>
                            </div>
                            <small id="rating-feedback" class="form-text text-muted"></small>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- The rating JavaScript remains exactly the same -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-rating .fas');
        const ratingContainer = document.querySelector('.star-rating');
        const feedbackEl = document.getElementById('rating-feedback');
        const averageRatingEl = document.getElementById('average-rating');

        if (!ratingContainer) return;

        // --- NEW: A function to permanently fill the stars to a certain value ---
        function setStars(value) {
            resetStars();
            for (let i = 0; i < value; i++) {
                stars[i].classList.add('selected');
            }
        }

        stars.forEach(star => {
            // Hover effect (no changes here)
            star.addEventListener('mouseover', function() {
                resetStars();
                for (let i = 0; i < this.dataset.value; i++) {
                    stars[i].classList.add('selected');
                }
            });

            ratingContainer.addEventListener('mouseleave', resetStars);

            // Click to submit rating (THIS IS THE MAINLY UPDATED PART)
            star.addEventListener('click', async function() {
                const rating = this.dataset.value;
                const bookId = ratingContainer.dataset.bookId;

                feedbackEl.textContent = 'Submitting your rating...';
                ratingContainer.style.pointerEvents = 'none'; // Disable while processing

                try {
                    const response = await fetch('../../controller/rate_book.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            book_id: bookId,
                            rating: rating
                        })
                    });

                    const result = await response.json();

                    // Check if the server responded with an OK status (2xx)
                    if (response.ok) {
                        feedbackEl.textContent = result.message;
                        if (result.new_average) {
                            averageRatingEl.textContent = result.new_average;
                        }
                        // SUCCESS: Permanently set the stars to the user's rating
                        setStars(rating);
                        // We DO NOT re-enable pointerEvents, this is now permanent.
                        location.reload();

                    } else {
                        // Handle errors like "409 Conflict" (already rated)
                        feedbackEl.textContent = `Info: ${result.message}`;
                        // In this case, we re-enable the stars but don't set them,
                        // as they haven't made a new rating.
                        ratingContainer.style.pointerEvents = 'auto';
                    }
                } catch (error) {
                    feedbackEl.textContent =
                        `Error: Could not submit rating. Please try again.`;
                    ratingContainer.style.pointerEvents = 'auto'; // Re-enable on failure
                }
            });
        });

        function resetStars() {
            stars.forEach(s => s.classList.remove('selected'));
        }
    });



    document.addEventListener('DOMContentLoaded', function() {
        const ratingContainers = document.querySelectorAll('.star-rating');

        ratingContainers.forEach(container => {
            const stars = container.querySelectorAll('i');
            const userRating = parseInt(container.dataset.userRating) || 0;

            // 1️⃣ Pre-fill stars if user already rated
            if (userRating > 0) {
                highlightStars(stars, userRating);
            }

            // 2️⃣ Hover effect
            stars.forEach(star => {
                star.addEventListener('mouseover', () => {
                    highlightStars(stars, star.dataset.value);
                });

                star.addEventListener('mouseout', () => {
                    highlightStars(stars, userRating); // Reset to saved rating
                });

                // 3️⃣ Click (set rating)
                star.addEventListener('click', () => {
                    const rating = parseInt(star.dataset.value);
                    highlightStars(stars, rating);
                    container.dataset.userRating = rating; // Update locally
                    document.getElementById('rating-feedback').textContent =
                        `You rated this book ${rating} star${rating > 1 ? 's' : ''}.`;

                    // Optional: send rating to server
                    // saveRating(container.dataset.bookId, rating);
                });
            });
        });

        // Helper function: color up to the selected star
        function highlightStars(stars, value) {
            stars.forEach(star => {
                star.classList.toggle('active', star.dataset.value <= value);
            });
        }
    })
    </script>
</body>

</html>