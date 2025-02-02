<!DOCTYPE html>
<html>
<head>
  <title>Add FAQ</title>
  <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
  <link rel="stylesheet" href="../css/styles.css">

</head>
<body>
  <h2>Add a New FAQ</h2>
  <form action="../admin.php" method="post">
    <label for="question">Question:</label><br>
    <input type="text" name="question" id="question" required><br><br>

    <label for="language">Language:</label><br>
    <select name="language" id="language" required>
      <option value="en">English</option>
      <option value="hi">Hindi</option>
      <option value="bn">Bengali</option>
    </select><br><br>

    <label for="editor">Answer:</label><br>
    <textarea name="answer" id="editor" required></textarea>
    <script>CKEDITOR.replace('editor');</script><br><br>

    <button type="submit">Save FAQ</button>
  </form>
</body>
</html>
