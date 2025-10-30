<!DOCTYPE html>
<html lang="en">
<?php
$q = urlencode($_POST['search'] ?? 'harry potter'); 
$key = 'AIzaSyCOCuStWqupRkpuhuYgeG4tqGYUDIsizns';  
$url = "https://www.googleapis.com/books/v1/volumes?q={$q}&key={$key}&maxResults=12";

$json = file_get_contents($url);
$data = json_decode($json, true);
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace | My Bookshelf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Cinzel+Decorative:wght@700&display=swap"
        rel="stylesheet">

    <style>
    :root {
        --color-deep-purple: #3a2d5c;
        --color-lavender: #a18cd1;
        --color-dusty-pink: #fbc2eb;
        --color-highlight: #51407d;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, var(--color-lavender), var(--color-dusty-pink));
        margin: 0;
        padding-top: 70px;
    }

    .page-heading {
        font-family: 'Cinzel Decorative', cursive;
        font-size: 2.3rem;
        background: linear-gradient(90deg, var(--color-deep-purple), var(--color-highlight));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Section heading (left accent line - style D) */
    .section-heading {
        font-weight: 600;
        font-size: 1.35rem;
        color: var(--color-deep-purple);
        position: relative;
        padding-left: 15px;
    }

    .section-heading::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 70%;
        background: var(--color-highlight);
        border-radius: 4px;
    }

    .book-card {
        background: #fff;
        border-radius: 14px;
        padding: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        transition: .25s ease-in-out;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .book-card img {
        border-radius: 10px;
        width: 100%;
        aspect-ratio: 2 / 3;
        object-fit: cover;
    }

    .book-title {
        font-weight: 600;
        color: var(--color-deep-purple);
        margin-top: 6px;
        font-size: 0.95rem;
    }

    .book-author,
    .book-category,
    .book-rating {
        font-size: 0.8rem;
        color: #555;
    }

    .book-rating i {
        color: #e6b800;
    }

    .btn-add-shelf {
        margin-top: auto;
        background: var(--color-deep-purple);
        color: #fff;
        width: 100%;
        border-radius: 25px;
        padding: 6px 0;
        font-size: 0.85rem;
        border: none;
    }

    .btn-add-shelf:hover {
        background: var(--color-highlight);
    }

    .col-lg-1-4 {
        flex: 0 0 auto;
        width: 25%;
    }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <div class="text-center mb-4">
            <h2 class="page-heading">Explore My Bookshelf</h2>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <h4 class="section-heading mb-3">Recommended Books</h4>
                <div class="row g-3">

                    <?php if(!empty($data['items'])): ?>
                    <?php foreach($data['items'] as $book):
                        $info = $book['volumeInfo'] ?? [];
                        $title = $info['title'] ?? 'No Title';
                        $authors = $info['authors'][0] ?? 'Unknown Author';
                        $category = $info['categories'][0] ?? 'General';
                        $rating = $info['averageRating'] ?? null;
                        $img = $info['imageLinks']['thumbnail'] ?? 'https://placehold.co/300x450/a18cd1/3a2d5c?text=No+Cover';
                    ?>
                    <div class="col-6 col-md-4 col-lg-1-4">
                        <div class="book-card">
                            <img src="<?= $img ?>" alt="Book Cover">
                            <div class="book-title"><?= htmlspecialchars($title) ?></div>
                            <div class="book-author"><?= htmlspecialchars($authors) ?></div>
                            <div class="book-category"><?= htmlspecialchars($category) ?></div>
                            <?php if($rating): ?>
                            <div class="book-rating">
                                <?php for($i=0;$i<round($rating);$i++) echo "<i class='bi bi-star-fill'></i> "; ?>
                            </div>
                            <?php endif; ?>
                            <button class="btn-add-shelf">Add to Shelf</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>

            <!-- UPDATED PROFESSIONAL FORM START -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-lg p-4" style="
                        border-radius: 20px;
                        background: rgba(255, 255, 255, 0.82);
                        backdrop-filter: blur(12px);
                        border: 1px solid rgba(255, 255, 255, 0.35);
                    ">

                    <h4 class="mb-4" style="
                            font-weight: 700;
                            color: var(--color-deep-purple);
                            text-align: center;
                            padding-bottom: 8px;
                            border-bottom: 2px solid rgba(58, 45, 92, 0.15);
                        ">
                        Add a New Book
                    </h4>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label" style="font-weight:600; color:#333;">Book Title</label>
                            <input type="text" class="form-control" placeholder="Enter book title"
                                style="border-radius:12px;padding:10px;border:1px solid #ddd;transition:.3s"
                                onfocus="this.style.borderColor='var(--color-deep-purple)'"
                                onblur="this.style.borderColor='#ddd'">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight:600; color:#333;">Author Name</label>
                            <input type="text" class="form-control" placeholder="Enter author name"
                                style="border-radius:12px;padding:10px;border:1px solid #ddd;transition:.3s"
                                onfocus="this.style.borderColor='var(--color-deep-purple)'"
                                onblur="this.style.borderColor='#ddd'">
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="font-weight:600; color:#333;">Cover URL (Optional)</label>
                            <input type="text" class="form-control" placeholder="Paste image URL"
                                style="border-radius:12px;padding:10px;border:1px solid #ddd;transition:.3s"
                                onfocus="this.style.borderColor='var(--color-deep-purple)'"
                                onblur="this.style.borderColor='#ddd'">
                        </div>

                        <button type="submit" class="btn w-100" style="
                                background: linear-gradient(135deg, var(--color-deep-purple), var(--color-highlight));
                                border:none;color:white;border-radius:35px;
                                padding:12px 0;font-size:1rem;font-weight:600;
                                box-shadow:0 4px 14px rgba(0,0,0,0.15);
                                transition:0.3s;
                            " onmouseover="this.style.transform='scale(1.03)'"
                            onmouseout="this.style.transform='scale(1)'">
                            + Add Book
                        </button>

                    </form>
                </div>
            </div>
            <!-- UPDATED PROFESSIONAL FORM END -->

        </div>
    </div>
</body>

</html>