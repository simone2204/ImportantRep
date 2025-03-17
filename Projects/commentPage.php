<?php
session_start();

if (isset($_GET['articleId'])) {
    $articleId = intval($_GET['articleId']);
} else {
    echo "ID articolo mancante!";
    exit;
}

$host = "127.0.0.1";
$dbname = "users_registered";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Errore di connessione al database: " . $conn->connect_error);
}

$sql = "SELECT comments.comment, users.email, comments.comment_date
        FROM comments
        JOIN users ON comments.user_id = users.id
        WHERE comments.article_id = ? ORDER BY comments.comment_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $articleId);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="commentPageCSS.css">
    <title>Comment Articles Page</title>
</head>

<body>
<div id="title"><a href="https://127.0.0.1/Projects/SitoPrincipale/site.php">World Street Journal</a></div><hr>

<form name="Form" id="login-form" action="Comments.php" method="POST">
        <input type="hidden" name="articleId" value="<?php echo $articleId; ?>">

        <div id="comment-below">
            <label for="comment"><strong>Leave a comment below</strong></label>
        </div>

        <div class="form-group">
            <textarea id="comment-text" name="comment" placeholder="Write your comment here" required></textarea>
        </div>

        <div class="form-group">
            <button type="submit" id="submit-comment">Submit Comment</button>
        </div>
    </form>
    <hr>

<?php if (!empty($comments)): ?>
    <div id="comments-section">
        <h3>Users Comments</h3>
        <?php foreach ($comments as $comment): ?>
            <div>
                <strong><?php echo htmlspecialchars($comment['email']); ?></strong> <em>at <?php echo $comment['comment_date']; ?></em><br>
                <p><?php echo htmlspecialchars($comment['comment']); ?></p><br>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No comments yet. Be the first to comment!</p>
<?php endif; ?>
</body>