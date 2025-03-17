<?php
session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://127.0.0.1");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if (!isset($_SESSION["email"])) {
    echo json_encode(["error" => "Devi essere loggato per mettere like"]);
    exit;
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (!$data || !isset($data["articleId"])) {
    echo json_encode(["error" => "Dati mancanti"]);
    exit;
}

$articleId = intval($data["articleId"]);
$userEmail = $_SESSION["email"];

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
$stmtUser->bind_param("s", $userEmail);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();
$stmtUser->close();

if (!$user) {
    echo json_encode(["error" => "Utente non trovato"]);
    exit;
}

$userId = $user["id"];

$sqlCheck = "SELECT * FROM likes WHERE user_id = ? AND article_id = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("ii", $userId, $articleId);
$stmtCheck->execute();
$result = $stmtCheck->get_result();
$stmtCheck->close();

if ($result->num_rows > 0) {
    
    $sqlDelete = "DELETE FROM likes WHERE user_id = ? AND article_id = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("ii", $userId, $articleId);
    
    if (!$stmtDelete->execute()) {
        echo json_encode(["error" => "Errore durante la rimozione del like"]);
        exit;
    }
    
    $stmtDelete->close();
    $action = "unliked";
} else {
    
    $sqlInsertLike = "INSERT INTO likes (user_id, article_id, created_at) VALUES (?, ?, NOW())";
    $stmtInsertLike = $conn->prepare($sqlInsertLike);
    $stmtInsertLike->bind_param("ii", $userId, $articleId);
    
    if (!$stmtInsertLike->execute()) {
        echo json_encode(["error" => "Errore durante l'aggiunta del like"]);
        exit;
    }
    
    $stmtInsertLike->close();
    $action = "liked";
}

$sqlCountLikes = "SELECT COUNT(*) AS like_count FROM likes WHERE article_id = ?";
$stmtCountLikes = $conn->prepare($sqlCountLikes);
$stmtCountLikes->bind_param("i", $articleId);
$stmtCountLikes->execute();
$resultCount = $stmtCountLikes->get_result();
$likeCount = $resultCount->fetch_assoc()['like_count'];
$stmtCountLikes->close();

$conn->close();

echo json_encode(["success" => true, "action" => $action, "likeCount" => $likeCount]);
?>