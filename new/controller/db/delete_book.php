<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM bookshelf WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: ../../view/reader/bookshelf1.php");
exit;
?>