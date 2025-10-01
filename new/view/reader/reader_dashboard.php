<!DOCTYPE html>
<html lang="en">
<?php
// PHP logic to fetch books from Google Books API
$q = urlencode($_POST['search'] ?? 'harry potter'); // Your search query
// NOTE: For security, never hardcode API keys in public code. Use environment variables.
$key = 'AIzaSyCOCuStWqupRkpuhuYgeG4tqGYUDIsizns'; // Replace with your actual key
$url = "https://www.googleapis.com/books/v1/volumes?q={$q}&key={$key}&maxResults=10";

// Fetch and decode the JSON data
$json = file_get_contents($url);
$data = json_decode($json, true);

// Start the session
session_start();
// Set a placeholder role if session isn't set (for testing)
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'Reader';
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Cinzel+Decorative:wght@700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Lora:wght@400;600&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    :root {
        --color-deep-purple: #3a2d5c;
        --color-lavender: #a18cd1;
        --color-dusty-pink: #fbc2eb;
        --color-text: #2c2c2c;
        --color-light-text: #f0f0f0;
        --color-highlight: #51407d;
    }

    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: var(--color-lavender);
        color: var(--color-text);
    }

    .books {
        padding: 30px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        justify-items: center;
    }

    /* bookcard style */

    .book-card {
        background-color: #ddcffeff;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        text-align: center;
        width: 100%;
        max-width: 230px;
        transition: transform 0.2s,
            box-shadow 0.2s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.7);
    }

    .book-card img {
        width: 100%;
        height: auto;
        max-height: 250px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    }

    .book-info {
        text-align: left;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .book-info h3 {
        margin: 0 0 5px 0;
        font-size: 1em;
        font-weight: 600;
        line-height: 1.2;
        color: var(--text-light);
    }

    .book-info p {
        font-size: 0.85em;
        color: var(--text-secondary);
        margin: 0 0 10px 0;
        flex-grow: 1;
    }

    /* Rating Style */
    .rating {
        display: flex;
        align-items: center;
        font-size: 0.9em;
        color: var(--rating-color);
        margin-bottom: 10px;
    }

    /* AI Summary Button */
    .btn {
        display: block;
        background-color: var(--primary-color);
        color: white !important;
        border: none;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.85em;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 10px;
    }

    .btn:hover {
        background-color: #af52c0;
    }

    /* Optional: Basic responsiveness */
    @media (max-width: 768px) {
        .header {
            padding: 10px 15px;
        }

        .books {
            padding: 15px;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }
    }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="books">

        <?php
        // Loop through the books fetched from the Google Books API
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) { 
                // Extract necessary information, using null coalescing (??) for safety
                $title = $item['volumeInfo']['title'] ?? 'No Title';
                $authors = isset($item['volumeInfo']['authors']) ? implode(', ', $item['volumeInfo']['authors']) : 'Unknown Author';
                $cover = $item['volumeInfo']['imageLinks']['thumbnail'] ?? 'https://via.placeholder.com/150';
                $rating = $item['volumeInfo']['averageRating'] ?? 'N/A';
                $infoLink = $item['volumeInfo']['infoLink'] ?? '#';
                
                // Display the book card using the PHP Heredoc syntax
                echo <<<HTML
                <div class="book-card">
                    <img src="{$cover}" alt="Book Cover">
                    <div class="book-info">
                        <h3>{$title}</h3>
                        <p>{$authors}</p>
                        <div class="rating">⭐ {$rating}</div>
                        <a href="{$infoLink}" class="btn">✨ AI Summary</a>
                    </div>
                </div>
                HTML;
            }
        }
        ?>

        <div class="book-card">
            <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1733931824i/221228045.jpg"
                alt="Book Cover">
            <div class="book-info">
                <h3>A Study in Drowning #2 A Theory of Dreaming</h3>
                <p>Ava Reid</p>
                <div class="rating">⭐ 3.84</div>
                <a href="#" class="btn">✨ AI Summary</a>
            </div>
        </div>

        <div class="book-card">
            <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1541428344i/17165596.jpg"
                alt="Book Cover">
            <div class="book-info">
                <h3>The Kite Runner</h3>
                <p>Khaled Hosseini</p>
                <div class="rating">⭐ 4.35</div>
                <a href="#" class="btn">✨ AI Summary</a>
            </div>
        </div>
    </div>
</body>

</html>