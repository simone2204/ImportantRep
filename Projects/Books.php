<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $apiKey = 'dzDLiEg8iKpCKSSRwL384dCeSSkdqGLB';
    $url = "https://api.nytimes.com/svc/books/v3/lists/current/hardcover-fiction.json?api-key=$apiKey";

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);

    if ($result === false) {
        echo json_encode(['error' => 'cURL error: ' . curl_error($curl)]);
        exit();
    } else {
        $data = json_decode($result, true);
        
        if (isset($data['results']['books'])) {
            $books = $data['results']['books'];
            $bookTitles = [];
            
                foreach ($books as $book) {
                    $bookTitles[] = [
                    'title' => $book['title'], 
                    'author' => $book['author'], 
                    'book_image' => isset($book['book_image']) ? $book['book_image'] : "cover not available"];
                }

            echo json_encode($bookTitles);
        } else {
            echo json_encode(['error' => 'No book found']);
        }
    }
    curl_close($curl);
}
?>