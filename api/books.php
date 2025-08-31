<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "bookspace";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// ✅ If ID is passed → fetch single book
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM bookshelf WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Book not found"]);
    }
    exit;
}

// ✅ Fetch all books
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $sql = "SELECT * FROM bookshelf";
    $result = $conn->query($sql);
    $books = [];

    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }

    echo json_encode($books);
    exit;
}

// ✅ Add new book (POST via FormData)
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $rating = $_POST['rating'] ?? 0;
    $cover = $_POST['cover'] ?? '';

    if (empty($title) || empty($author)) {
        echo json_encode(["status" => "error", "error" => "Missing fields"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO bookshelf (title, author, rating, cover) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $title, $author, $rating, $cover);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["status" => "error", "error" => $stmt->error]);
    }
    $stmt->close();
    exit;
}

// ✅ Delete book (DELETE)
if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = intval($_DELETE['id'] ?? 0);

    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM bookshelf WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Book deleted"]);
        } else {
            echo json_encode(["status" => "error", "error" => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "error" => "Invalid ID"]);
    }
    exit;
}
?>
