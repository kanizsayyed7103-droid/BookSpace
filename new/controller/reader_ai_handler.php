<?php
header('Content-Type: application/json');

// === READ USER MESSAGE ===
$data = json_decode(file_get_contents('php://input'), true);
$userMessage = trim($data['message'] ?? '');

if (!$userMessage) {
    echo json_encode(['reply' => "Please type something first!"]);
    exit;
}

// === OPENAI API KEY ===
$apiKey = 'AIzaSyCRooi63goFV3iTjxXnqEMK-feJnjaCDe0'; // <-- PASTE YOUR GEMINI API KEY HERE
$apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey;
$apiUrl = "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($title);
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);



// === SYSTEM PROMPT ===
$systemPrompt = "You are 'BookSpace AI' — a friendly book assistant.
You recommend books, show authors, summaries, and use Google Books data.
When suggesting a book, always give its title, author, and a one-line summary.";

// === CALL OPENAI API ===
$payload = [
    "model" => "gpt-4o-mini",
    "messages" => [
        ["role" => "system", "content" => $systemPrompt],
        ["role" => "user", "content" => $userMessage]
    ],
    "temperature" => 0.8
];

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($payload)
]);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo json_encode(['reply' => "Error: $error"]);
    exit;
}

$result = json_decode($response, true);
$aiReply = $result['choices'][0]['message']['content'] ?? "Sorry, I couldn’t get a response.";

// === GET BOOK DETAILS FROM GOOGLE BOOKS ===
$encodedQuery = urlencode($userMessage);
$googleApiUrl = "https://www.googleapis.com/books/v1/volumes?q=$encodedQuery&maxResults=1";

$googleResponse = file_get_contents($googleApiUrl);
$bookData = json_decode($googleResponse, true);

$bookInfo = $bookData['items'][0]['volumeInfo'] ?? null;

if ($bookInfo) {
    $title = $bookInfo['title'] ?? '';
    $authors = implode(', ', $bookInfo['authors'] ?? []);
    $thumbnail = $bookInfo['imageLinks']['thumbnail'] ?? '';
    $description = $bookInfo['description'] ?? '';
    $rating = $bookInfo['averageRating'] ?? 'N/A';

    $extra = [
        'title' => $title,
        'author' => $authors,
        'cover' => $thumbnail,
        'rating' => $rating,
        'description' => $description
    ];
} else {
    $extra = null;
}

echo json_encode(['reply' => $aiReply, 'book' => $extra]);
?>