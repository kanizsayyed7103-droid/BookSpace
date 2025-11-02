<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../controller/db/database.php');

$current_user_id = $_SESSION['user_id'] ?? 0;

// ✅ Fetch all users except the logged-in one
$query = "SELECT user_id, username, role, first_name, last_name, profile_image 
          FROM users";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Get the following list for current user
$follow_query = "SELECT following_id FROM follows WHERE follower_id = ?";
$stmt2 = $pdo->prepare($follow_query);
$stmt2->execute([$current_user_id]);
$following_ids = array_column($stmt2->fetchAll(PDO::FETCH_ASSOC), 'following_id');

// ✅ Function to count followers & following
function getFollowStats($pdo, $user_id) {
    $followers = $pdo->prepare("SELECT COUNT(*) FROM follows WHERE following_id = ?");
    $followers->execute([$user_id]);
    $followers_count = $followers->fetchColumn();

    $following = $pdo->prepare("SELECT COUNT(*) FROM follows WHERE follower_id = ?");
    $following->execute([$user_id]);
    $following_count = $following->fetchColumn();

    return ['followers' => $followers_count, 'following' => $following_count];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect & Follow | BookSpace - Your Intelligent Reading Companion</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Cinzel+Decorative:wght@700&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
    :root {
        --color-deep-purple: #3a2d5c;
        --color-lavender: #a18cd1;
        --color-dusty-pink: #fbc2eb;
        --color-highlight: #51407d;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
        min-height: 100vh;
        margin: 0;
        padding-top: 100px;
    }

    h1 {
        font-family: 'Cinzel Decorative', cursive;
        font-weight: 600;
        text-align: center;
        margin: 10px auto 25px auto;
        font-size: 2.3rem;
        background: linear-gradient(90deg, #3a2d5c, #3a2d5c, #3a2d5c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        width: fit-content;
    }

    h1::after {
        content: "";
        display: block;
        width: 60%;
        height: 3px;
        margin: 8px auto 0;
        background: linear-gradient(90deg, #7b2ff7, #f107a3);
        border-radius: 2px;
        transition: width 0.4s ease;
    }

    h1:hover::after {
        width: 80%;
    }

    .text-center {
        color: #51407d;
        font-weight: 500;
        font-size: 1.1rem;
    }

    .user-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 35px;
        padding: 20px 0;
    }

    .user-card {
        background: linear-gradient(180deg, #ffffff 0%, #f8f6ff 100%);
        border-radius: 22px;
        width: 250px;
        box-shadow: 0 6px 20px rgba(58, 45, 92, 0.15);
        text-align: center;
        transition: all 0.35s ease;
        overflow: hidden;
        padding: 25px 18px;
        border: 1px solid rgba(161, 140, 209, 0.2);
        position: relative;
    }

    .user-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, #7b2ff7, #f107a3);
        border-top-left-radius: 22px;
        border-top-right-radius: 22px;
    }

    .user-card img {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        padding: 4px;
        background: linear-gradient(135deg, #a18cd1, #fbc2eb);
        border: 3px solid #fff;
        box-shadow: 0 5px 15px rgba(81, 64, 125, 0.25);
        transition: all 0.4s ease;
        display: block;
        margin: 0 auto 15px;
    }

    .user-card:hover img {
        transform: scale(1.08);
        box-shadow: 0 8px 25px rgba(161, 140, 209, 0.45);
        background: linear-gradient(135deg, #c7a4ff, #f9c6ea);
        border-color: #f9c6ea;
    }

    .user-card h5 {
        color: var(--color-deep-purple);
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 1.1rem;
    }

    .user-card p {
        color: #555;
        font-size: 0.9rem;
        margin: 3px 0;
        line-height: 1.4;
    }

    .follow-stats {
        display: flex;
        justify-content: center;
        gap: 15px;
        font-size: 0.85rem;
        color: #555;
    }

    .follow-btn {
        background: linear-gradient(90deg, #7b2ff7, #f107a3);
        color: #fff;
        border: none;
        border-radius: 25px;
        padding: 8px 16px;
        font-weight: 500;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.3s ease;
    }

    .follow-btn:hover {
        opacity: 0.9;
    }

    .follow-btn.following {
        background: #ccc;
        color: #333;
    }

    /* ✅ Change Profile Button */
    .btn-change-profile {
        display: inline-block;
        background: linear-gradient(90deg, #7b2ff7, #f107a3);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 8px 16px;
        font-weight: 500;
        cursor: pointer;
        margin-top: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-change-profile:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(81, 64, 125, 0.25);
    }
    </style>
</head>
<!-- Upload Profile Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 text-center">
            <h5 class="mb-3" style="color:#3a2d5c;">Update Profile Picture</h5>
            <form id="uploadForm" enctype="multipart/form-data">
                <input type="file" name="profile_image" accept="image/*" class="form-control mb-3" required>
                <button type="submit" class="btn-change-profile w-100">Upload</button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Open modal when clicking "Change Profile Picture"
    $(".btn-change-profile").click(function(e) {
        e.preventDefault();
        $("#uploadModal").modal("show");
    });

    // Handle file upload
    $("#uploadForm").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "upload_profile.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                const res = JSON.parse(response);
                if (res.success) {
                    $("#uploadModal").modal("hide");
                    $(".user-card img[src*='<?php echo $current_user_id; ?>']").attr("src",
                        res.image);
                    alert("Profile picture updated successfully!");
                    location.reload(); // Optional: to refresh all cards
                } else {
                    alert(res.message);
                }
            }
        });
    });
});
</script>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Connect with Readers & Authors</h1>
        <p class="text-center">
            Build your literary circle — follow, engage, and grow together on BookSpace.
        </p>

        <div class="user-grid">
            <?php foreach ($users as $user): 
                $stats = getFollowStats($pdo, $user['user_id']);
                $is_current_user = ($user['user_id'] == $current_user_id);
            ?>
            <div class="user-card">
                <img src="<?php echo !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : 'https://cdn-icons-png.flaticon.com/512/149/149071.png'; ?>"
                    alt="Profile">
                <h5><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
                <p class="mb-1"><i class="bi bi-person-circle"></i>
                    <?php echo ucfirst($user['role']); ?></p>

                <div class="follow-stats">
                    <span><b><?php echo $stats['followers']; ?></b> Followers</span>
                    <span><b><?php echo $stats['following']; ?></b> Following</span>
                </div>

                <?php if ($is_current_user): ?>
                <a href="upload_profile.php" class="btn-change-profile">Change Profile Picture</a>
                <?php else: ?>
                <button class="follow-btn <?php echo in_array($user['user_id'], $following_ids) ? 'following' : ''; ?>"
                    id="btn-<?php echo $user['user_id']; ?>" data-id="<?php echo $user['user_id']; ?>">
                    <?php echo in_array($user['user_id'], $following_ids) ? 'Following' : 'Follow'; ?>
                </button>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $(".follow-btn").click(function() {
            var btn = $(this);
            var id = btn.data("id");
            var action = btn.hasClass("following") ? "unfollow" : "follow";

            $.post("follow_action.php", {
                action: action,
                following_id: id
            }, function(response) {
                if (response.trim() === "followed") {
                    btn.addClass("following").text("Following");
                    let count = btn.closest(".user-card").find(".follow-stats span:first b");
                    count.text(parseInt(count.text()) + 1);
                } else if (response.trim() === "unfollowed") {
                    btn.removeClass("following").text("Follow");
                    let count = btn.closest(".user-card").find(".follow-stats span:first b");
                    count.text(Math.max(0, parseInt(count.text()) - 1));
                }
            });
        });
    });
    </script>
</body>

</html>