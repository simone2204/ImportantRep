<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_address = $_POST["email_address"];
    $password = $_POST["password"];

    if (empty($email_address) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Inserisci email e password"]);
        exit;
    }

    $host = "127.0.0.1";
    $dbname = "users_registered";
    $username = "root";
    $dbPassword = "";

    $conn = new mysqli($host, $username, $dbPassword, $dbname);
    if ($conn->connect_error) {
        echo json_encode(["status" => "error", "message" => "Errore di connessione"]);
        exit;
    }

    $email_address = mysqli_real_escape_string($conn, $email_address);
    $query = "SELECT id, email, password FROM users WHERE email = '$email_address'";
    $res = mysqli_query($conn, $query);

    if (mysqli_num_rows($res) == 0) {
        echo json_encode(["status" => "error", "message" => "Email non trovata"]);
        mysqli_free_result($res);
        $conn->close();
        exit;
    }

    $user = mysqli_fetch_assoc($res);
    $stored_password = $user['password'];
    $user_id = $user['id'];

    
    if (password_verify($password, $stored_password)) {
        $_SESSION['email'] = $email_address;
        $_SESSION['id'] = $user_id;
        header("Location: https://127.0.0.1/Projects/SitoPrincipale/site.php");
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: incorrect password']);
    }
    mysqli_free_result($res);
    $conn->close();
}
?>