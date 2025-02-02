<?php
include 'db.php';

function translateText($text, $targetLang, $apiKey) {
    $url = "https://translation.googleapis.com/language/translate/v2?key=$apiKey";

    $data = [
        'q' => $text,
        'target' => $targetLang,
        'format' => 'text'
    ];

    $headers = [
        'Content-Type: application/json',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        return $text; // Fallback if translation fails
    }

    $responseData = json_decode($response, true);
    return $responseData['data']['translations'][0]['translatedText'] ?? $text;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $lang = $_POST['language'];

    // API Key for Google Translate
    $apiKey = 'AIzaSyAnn3XgNyEMWG9SUjTD2dh8Xl2JZJSJVLI';  

    // Use Prepared Statements for Security
    $stmt = $conn->prepare("INSERT INTO faqs (question, answer, language) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $question, $answer, $lang);

    if ($stmt->execute()) {
        echo "FAQ added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FAQ Successfully added</title>
</head>
<body>

 <!-- Button to open the modal index.php-->
 <button id="add-faq-btn" onclick="window.location.href='index.php'">Access FAQ</button>

</body>
</html>



</body>
</html>
