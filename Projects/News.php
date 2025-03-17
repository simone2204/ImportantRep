<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $apiKey = 'VDe8iqmWktTwFpnNaQr6Skrz7pagFTSY';
    $url = "https://api.nytimes.com/svc/topstories/v2/world.json?api-key=$apiKey";

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);

    if ($result === false) {
        echo json_encode(['error' => 'cURL error: ' . curl_error($curl)]);
        exit();
    }

    $data = json_decode($result, true);

    if (!isset($data['results']) || count($data['results']) == 0) {
        echo json_encode(['success' => false, 'error' => 'No articles found']);
        exit();
    }

    $articles = [];

    foreach (array_slice($data['results'], 0, 10) as $article) {
        $articles[] = [
            "title" => $article['title'] ?? "No title",
            "abstract" => $article['abstract'] ?? "No abstract",
            "img" => isset($article['multimedia'][1]['url']) ? $article['multimedia'][1]['url'] : null
        ];
    }

    echo json_encode($articles);

    curl_close($curl);
}
?>