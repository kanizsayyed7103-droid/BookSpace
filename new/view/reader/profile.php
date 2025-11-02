<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../controller/db/database.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, email, first_name, last_name, profile_image FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
$status = $_GET['status'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | BookSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #f6ecf9;
        font-family: 'Poppins', sans-serif;
        padding-top: 80px;
    }

    nav.navbar {
        margin-bottom: 5 !important;
        padding: 5 !important;
    }

    /* --- Compact Container --- */
    .main-container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
    }

    .profile-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        padding: 25px 20px;
        transition: 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
        background-color: #6a11cb;
        color: white;
        text-align: center;
        border-radius: 12px;
        padding: 8px 0;
        margin-bottom: 18px;
        font-size: 1.2rem;
        font-weight: 600;
    }

    /* Profile Image */
    .profile-avatar {
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        width: 90px;
        height: 90px;
        box-shadow: 0 0 8px rgba(162, 93, 255, 0.4);
        background: linear-gradient(135deg, #c4a1ff, #7a49ff);
        padding: 3px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.06);
        box-shadow: 0 0 14px rgba(162, 93, 255, 0.7);
    }

    .form-label {
        font-weight: 500;
        color: #333;
        font-size: 0.9rem;
        margin-bottom: 2px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 7px 10px;
        font-size: 0.9rem;
        height: 34px;
    }

    .form-control:focus {
        border-color: #6a11cb;
        box-shadow: 0 0 0 0.15rem rgba(106, 17, 203, 0.25);
    }

    .btn-primary {
        background: linear-gradient(90deg, #6a11cb, #2575fc);
        border: none;
        font-weight: 500;
        padding: 7px 18px;
        border-radius: 8px;
        transition: 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        opacity: 0.9;
    }

    .alert {
        max-width: 500px;
        margin: 10px auto;
        border-radius: 8px;
        text-align: center;
        font-size: 0.9rem;
        padding: 8px;
    }

    /* Reduce space between fields */
    form .mb-3,
    form .mb-4 {
        margin-bottom: 10px !important;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <?php if ($status === 'success'): ?>
    <div class="alert alert-success">✅ Profile updated successfully!</div>
    <?php elseif ($status === 'nochange'): ?>
    <div class="alert alert-warning">⚠️ No changes were made.</div>
    <?php endif; ?>

    <div class="main-container">
        <div class="profile-card">
            <div class="profile-header">My Profile</div>

            <form action="../../controller/reader_update_profile.php" method="POST" enctype="multipart/form-data">
                <div class="text-center mb-3">
                    <img id="profilePreview"
                        src="<?php echo !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : '../asst/img/default.png'; ?>"
                        alt="Profile Image" class="profile-avatar">
                </div>

                <div class="mb-2">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="profile_image" class="form-control" accept="image/*"
                        id="profileImageInput">
                </div>

                <div class="mb-2">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control"
                        value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control"
                        value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control"
                        value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    const profileImageInput = document.getElementById('profileImageInput');
    const profilePreview = document.getElementById('profilePreview');

    profileImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    function logout() {
        if (confirm("Are you sure you want to log out?")) {
            window.location.href = "../../controller/logout.php";
        }
    }
    </script>
    <script>
    // Auto-hide alert after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500); // remove completely after fade out
            }, 3000); // 3 seconds
        }
    });
    </script>

</body>

</html>