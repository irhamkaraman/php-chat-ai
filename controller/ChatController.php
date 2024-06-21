<?php
require '../env.php';
header('Content-Type: application/json');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $message = $_POST['message'] ?? '';
    
    if (empty($message)) {
        echo json_encode(["error" => "Message is empty"]);
        exit;
    }

    $chatHistory = $_SESSION['chatHistory'] ?? [];

    $chatHistory[] = [
        "role" => "user",
        "content" => $message
    ];

    $data = [
        "messages" => array_values($chatHistory), 
        "model" => "gemma-7b-it"
    ];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.groq.com/openai/v1/chat/completions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Bearer $groq_api"
        ],
    ]);

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo json_encode(["error" => "cURL Error #:" . $err]);
    } elseif ($httpcode !== 200) {
        echo json_encode(["error" => "API returned status code " . $httpcode, "response" => $response]);
    } else {
        $aiResponse = json_decode($response, true);
        $chatHistory[] = [
            "role" => "user",
            "content" => $aiResponse["choices"][0]["message"]["content"]
        ];

        $_SESSION['chatHistory'] = $chatHistory;

        echo $response;
    }
}
?>
