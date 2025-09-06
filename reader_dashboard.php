<!DOCTYPE html>
<html lang="en">
<?php
$q = urlencode($_POST['search'] ?? 'harry potter');  // search query
$key = 'AIzaSyCOCuStWqupRkpuhuYgeG4tqGYUDIsizns';    // Google API key
$url = "https://www.googleapis.com/books/v1/volumes?q={$q}&key={$key}&maxResults=10";

$json = file_get_contents($url);
$data = json_decode($json, true);
session_start();
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookSpace</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Cinzel+Decorative:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="reader.css">
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column">
    <!-- Logo -->
    <div class="logo">
      <img src="logo.JPEG" alt="BookSpace Logo">
      <h4>bookSpace</h4>
    </div>

    <!-- Profile -->
    <div class="profile">
      <img src="kaniz.jpg" alt="Profile">
      <p>Welcome, <b><?php echo $_SESSION['role'] ?? 'Reader'; ?></b></p>
    </div>

    <!-- Search -->
    <form action="reader_dashboard.php" method="post" class="mb-3">
      <input type="text" class="form-control" name="search" placeholder="Search books...">
    </form>

    <!-- Navigation -->
    <ul class="nav flex-column mb-auto">
      <li class="nav-item"><a href="reader_dashboard.php" class="nav-link">Dashboard</a></li>
      <li><a href="bookshelf.html" class="nav-link">Bookshelf</a></li>
      <li><a href="cost.html" class="nav-link">Cost</a></li>
      <li><a href="contact.html" class="nav-link">Contact</a></li>
      <li><a href="chatbot.html" class="nav-link">AI Chatbot</a></li>
      <li><a href="authors.html" class="nav-link">Authors</a></li>
    </ul>

    <!-- Logout -->
    <button class="btn btn-logout mt-3">LOGOUT</button>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="books d-flex flex-wrap gap-3">
      <?php
      if (!empty($data['items']))  foreach ($data['items'] as $item): ?>
        <div class="card" style="width: 14rem;">
          <img src="<?php echo $item['volumeInfo']['imageLinks']['thumbnail'] ?? 'https://via.placeholder.com/150'; ?>" 
               class="card-img-top" alt="Book Cover">
          <div class="card-body">
            <h5 class="card-title"><?php echo $item['volumeInfo']['title'] ?? 'No Title'; ?></h5>
            <p class="card-text"><?php echo isset($item['volumeInfo']['authors']) ? implode(', ', $item['volumeInfo']['authors']) : 'Unknown Author'; ?></p>
            <p class="text-warning">⭐ <?php echo $item['volumeInfo']['averageRating'] ?? 'N/A'; ?></p>
            <a href="<?php echo $item['volumeInfo']['infoLink'] ?? '#'; ?>" class="btn btn-primary btn-sm">✨ AI Summary</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
