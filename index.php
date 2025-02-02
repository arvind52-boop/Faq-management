<?php
include 'db.php';

$language = $_GET['lang'] ?? 'en';
$query = "SELECT id, question, answer FROM faqs"; // Fetch only original data
$result = $conn->query($query);

function translateText($text, $targetLanguage) {
    $apiKey = 'API_KEY'; 
    $url = "https://translation.googleapis.com/language/translate/v2?key=$apiKey";

    $data = [
        'q' => $text,
        'target' => $targetLanguage
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json",
            'method'  => 'POST',
            'content' => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        return $text; // Return original text if translation fails
    }

    $responseData = json_decode($response, true);
    return $responseData['data']['translations'][0]['translatedText'] ?? $text;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FAQ Management</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <h1>Frequently Asked Questions</h1>

  <div id="language-switcher">
    <h5>Translate FAQs to different languages :</h5>
    <select onchange="changeLanguage(this.value)">
      <option value="en" <?= $language == 'en' ? 'selected' : '' ?>>English</option>
      <option value="hi" <?= $language == 'hi' ? 'selected' : '' ?>>Hindi</option>
      <option value="fr" <?= $language == 'fr' ? 'selected' : '' ?>>French</option>
      <option value="es" <?= $language == 'es' ? 'selected' : '' ?>>Spanish</option>
      <option value="de" <?= $language == 'de' ? 'selected' : '' ?>>German</option>
      <option value="zh" <?= $language == 'zh' ? 'selected' : '' ?>>Chinese</option>
      <option value="ja" <?= $language == 'ja' ? 'selected' : '' ?>>Japanese</option>
      <option value="ru" <?= $language == 'ru' ? 'selected' : '' ?>>Russian</option>
      <option value="ar" <?= $language == 'ar' ? 'selected' : '' ?>>Arabic</option>
      <option value="pt" <?= $language == 'pt' ? 'selected' : '' ?>>Portuguese</option>
    </select>
  </div>

  <button id="add-faq-btn" onclick="window.location.href='richtext/wysiwyg.php'">Add FAQ</button>

  <div id="faq-container">
    <?php while ($row = $result->fetch_assoc()) : ?>
      <div class="faq-item">
        <h2>
          <?= translateText($row['question'], $language); ?>
        </h2>
        <p>
          <?= translateText($row['answer'], $language); ?>
        </p>
      </div>
    <?php endwhile; ?>
  </div>

  <script>
    function changeLanguage(lang) {
      window.location.href = '?lang=' + lang;
    }
  </script>
  <script src="js/app.js"></script>
</body>
</html>
