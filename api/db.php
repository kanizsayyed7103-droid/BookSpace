<?php
// api/db.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit; // preflight

$mysqli = new mysqli('localhost', 'root', '', 'bookspace');
if ($mysqli->connect_errno) {
  http_response_code(500);
  echo json_encode(['error' => 'DB connect failed', 'msg' => $mysqli->connect_error]);
  exit;
}
$mysqli->set_charset('utf8mb4');

function json_out($data, int $code = 200) {
  http_response_code($code);
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  exit;
}
