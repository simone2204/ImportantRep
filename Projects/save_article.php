<?php
session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://127.0.0.1");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$host = "127.0.0.1";
$database = "users_registered";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if (isset($data['articleTitle'])) {
    $title = $conn->real_escape_string($data['articleTitle']);

    $checkSql = "SELECT id FROM articles WHERE title = '$title'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        
        $existingArticle = $checkResult->fetch_assoc();
        echo json_encode([
            "success" => true,
            "message" => "Articolo già presente nel database.",
            "article_id" => $existingArticle['id']
        ]);
    } else {
        
        $sql = "INSERT INTO articles (title) VALUES ('$title')";

        if ($conn->query($sql) === TRUE) {
            $article_id = $conn->insert_id;
            echo json_encode([
                "success" => true,
                "message" => "Articolo salvato con successo!",
                "article_id" => $article_id
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Errore nell'inserimento dell'articolo: " . $conn->error]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati mancanti: 'articleTitle'"]);
}

$conn->close();
?>