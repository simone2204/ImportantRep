<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $apiKey = 'dzDLiEg8iKpCKSSRwL384dCeSSkdqGLB';
    $url = "https://api.nytimes.com/svc/search/v2/articlesearch.json?q=news&sort=newest&page=1&api-key=$apiKey";

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);

    if ($result === false) {
        echo json_encode(['error' => 'cURL error: ' . curl_error($curl)]);
        exit();
    } 

    $data = json_decode($result, true);
    if (!isset($data['response']['docs'])) {
        echo json_encode(['success' => false, 'error' => 'No articles found']);
        exit();
    }

    $article = $data['response']['docs'][0];

    $response = [
        "title" => $article['headline']['main'] ?? "No title",
        "abstract" => $article['abstract'] ?? "No abstract",
        "lead_paragraph" => $article['lead_paragraph'] ?? "No content",
        "img" => isset($article['multimedia'][0]['url']) ? 'https://static01.nyt.com/' . $article['multimedia'][0]['url'] : null
    ];

    echo json_encode($response);

    curl_close($curl);
}
?>