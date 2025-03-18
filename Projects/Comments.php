<?php
session_start();

if (isset($_POST['articleId']) && isset($_POST['comment'])) {
    $articleId = intval($_POST['articleId']);
    $comment = $_POST['comment'];
    $userEmail = $_SESSION["email"];
} else {
    echo json_encode(["error" => "Dati mancanti"]);
    exit;
}

$host = "127.0.0.1";
$dbname = "users_registered";
$username = "root";
$dbPassword = "";

$conn = new mysqli($host, $username, $dbPassword, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Errore connessione"]);
    exit;
}

$sqlUser = "SELECT id FROM users WHERE email = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("s", $userEmail);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();

if (!$user) {
    echo json_encode(["error" => "Utente non trovato"]);
    exit;
}

$userId = $user["id"];

$sqlInsertComment = "INSERT INTO comments (user_id, article_id, comment, comment_date) VALUES (?, ?, ?, NOW())";
$stmtInsertComment = $conn->prepare($sqlInsertComment);
$stmtInsertComment->bind_param("iis", $userId, $articleId, $comment);

if (!$stmtInsertComment->execute()) {
    echo json_encode(["error" => "Errore durante l'aggiunta del commento"]);
    exit;
}

echo json_encode(["success" => true, "action" => "comment_added"]);

header("Location: http://127.0.0.1/Projects/SitoPrincipale/site.php");

$stmtInsertComment->close();
$conn->close();
?>
