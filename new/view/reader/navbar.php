<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../../controller/db/database.php');

// Security: Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    // header("Location: ../index.html");
    // exit();
}else{
$user_id = $_SESSION['user_id'];
 // Fetch user's data
$stmt = $pdo->prepare("SELECT username, profile_image FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$username = htmlspecialchars($user['username'] ?? 'Reader');
$profile_image = !empty($user['profile_image'])
    ? htmlspecialchars($user['profile_image'])
    : '/BookSpace_project/default.jpg';   
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace | Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Cinzel+Decorative:wght@700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
    :root {
        --color-deep-purple: #3a2d5c;
        --color-lavender: #a18cd1;
        --color-dusty-pink: #fbc2eb;
        --color-light-text: #f0f0f0;
        --color-highlight: #51407d;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--color-lavender);
        margin: 0;
        padding-top: 70px;
    }

    .navbar {
        background-color: var(--color-highlight);
        padding: 0.6rem 1.5rem;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--color-light-text);
    }

    .navbar-brand img {
        height: 55px;
        margin-right: 5px;
        border-radius: 50%;
    }

    .navbar-brand h4 {
        margin: 0;
        color: var(--color-light-text);
        font-family: 'Cinzel Decorative', cursive;
    }

    .navbar .nav-link {
        color: var(--color-light-text);
        font-weight: 500;
        padding: 0.5rem 1rem;
    }

    .navbar .nav-link.active,
    .navbar .nav-link:hover {
        color: #b899f1ff;
        font-weight: 600;
    }

    .form-control {
        border-radius: 25px;
        border: 1px solid #fbc2eb;
        padding: 0.4rem 1rem;
        width: 280px;
        font-size: 0.9rem;
    }

    .profile-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-container img {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        border: 2px solid var(--color-dusty-pink);
        object-fit: cover;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-container img:hover {
        transform: scale(1.08);
        box-shadow: 0 0 10px rgba(251, 194, 235, 0.6);
    }

    .username-text {
        color: var(--color-light-text);
        font-weight: 500;
        font-size: 1rem;
        margin-right: 15px;
        white-space: nowrap;
    }

    .btn-logout {
        background-color: var(--color-dusty-pink);
        color: var(--color-deep-purple);
        font-weight: bold;
        border-radius: 25px;
        padding: 0.4rem 1rem;
        font-size: 0.9rem;
        transition: background-color 0.3s ease;
    }

    .btn-logout:hover {
        background-color: #ec9ed6ff;
        color: var(--color-deep-purple);
    }

    @media (max-width: 992px) {
        .form-control {
            width: 180px;
        }

        .username-text {
            display: none;
        }
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="/BookSpace_project/new/view/reader/reader_dashboard.php">
                <img src="/BookSpace_project/new/view/reader/logo.JPEG" alt="BookSpace Logo">
                <h4>bookSpace</h4>
            </a>

            <button class="navbar-toggler text-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a href="/BookSpace_project/new/view/reader/reader_dashboard.php"
                            class="nav-link">Dashboard</a></li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/BookSpace_project/new/view/reader/bookshelf1.php" class="nav-link">Bookshelf</a>
                        <?php else: ?>
                        <a href="/BookSpace_project/new/index.php" onclick="confirmAction()"
                            class="nav-link">Bookshelf</a>
                        <?php endif; ?>
                    </li>

                    </li>
                    <li class="nav-item"><a href="/BookSpace_project/new/view/reader/contact.php"
                            class="nav-link">Contact</a></li>
                    <li class="nav-item"><a href="/BookSpace_project/new/view/reader/chatbot.php" class="nav-link">AI
                            Chatbot</a></li>
                </ul>

                <!-- Search Bar -->
                <form action="/BookSpace_project/new/view/reader/reader_dashboard.php" method="post"
                    class="d-flex align-items-center me-3">
                    <input type="text" class="form-control" name="search" placeholder="Search books..."
                        value="<?php echo htmlspecialchars($_POST['search'] ?? ''); ?>">
                </form>



                <!-- Logout Button -->
                <?php if (isset($_SESSION['user_id'])): ?>

                <!-- Profile + Username -->

                <div class="profile-container me-3">

                    <!-- <a href="/BookSpace_project/new/view/reader/profile.php" class="d-inline-block"> -->
                    <!-- <img src="<?php echo $profile_image; ?>" alt="Profile">
                    </a> -->

                    <?php
$profile_image = !empty($profile_image) && file_exists($_SERVER['DOCUMENT_ROOT'] . $user['profile_image'])
    ? $user['profile_image']
    : '/BookSpace_project/default.jpg';
?>

                    <a href="/BookSpace_project/new/view/reader/profile.php" class="d-inline-block">
                        <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile" class="rounded-circle"
                            width="50" height="50">
                    </a>
                    <span class="username-text"><?php echo $username; ?></span>
                </div>
                <form action="/BookSpace_project/new/logout.php" method="post" class="ms-2">
                    <button type="submit" class="btn btn-logout">LOGOUT</button>
                </form>
                <?php else: ?>
                <form action="/BookSpace_project/new/index.php" method="post" class="ms-2">
                    <button type="submit" class="btn btn-logout">LOGIN</button>
                </form>
                <?php endif; ?>





            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function confirmAction() {
        // Your JavaScript code here
        event.preventDefault();

        let result = confirm("Login to see your bookshelf?");
        // alert("Login to see your bookshelf")
        // If user clicks OK (true)
        if (result) {
            window.location.href = "/BookSpace_project/new/index.php"; // change link as needed
        }
        // If user clicks Cancel (false)
        else {
            // Redirect to another page
            // alert("You chose to stay on this page!");

        }
    }

    function confirmActionpt() {
        // Your JavaScript code here
        event.preventDefault();

        let result = confirm("Login to see your bookdetails?");
        // alert("Login to see your bookshelf")
        // If user clicks OK (true)
        if (result) {
            window.location.href = "/BookSpace_project/new/index.php"; // change link as needed
        }
        // If user clicks Cancel (false)
        else {
            // Redirect to another page
            // alert("You chose to stay on this page!");

        }
    }
    </script>


</body>

</html>