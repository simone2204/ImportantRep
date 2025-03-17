<?php
session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://127.0.0.1");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");


$host = "127.0.0.1";
$dbname = "users_registered";
$username = "root";
$dbPassword = "";

$conn = new mysqli($host, $username, $dbPassword, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Errore connessione database"]);
    exit;
}

$sqlUser = "SELECT id FROM users WHERE email = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("s", $_SESSION["email"]);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();
$stmtUser->close();

$userId = $user["id"];

$sqlLikes = "SELECT article_id FROM likes WHERE user_id = ?";
$stmtLikes = $conn->prepare($sqlLikes);
$stmtLikes->bind_param("i", $userId);
$stmtLikes->execute();
$resultLikes = $stmtLikes->get_result();

$likedArticles = [];
while ($row = $resultLikes->fetch_assoc()) {
    $likedArticles[] = $row["article_id"];
}
$stmtLikes->close();

$sqlLikeCounts = "SELECT article_id, COUNT(*) AS like_count FROM likes GROUP BY article_id";
$resultLikeCounts = $conn->query($sqlLikeCounts);

$likeCounts = [];
while ($row = $resultLikeCounts->fetch_assoc()) {
    $likeCounts[$row["article_id"]] = $row["like_count"];
}

$conn->close();

echo json_encode(["success" => true, "likedArticles" => $likedArticles, "likeCounts" => $likeCounts]);
?>
