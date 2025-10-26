<!DOCTYPE html>
<html>
<head>
    <title>Produkty</title>
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>
<?php if (!empty($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form action="/upload" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="file" id="fileToUpload">
  <input type="text" name="title" placeholder="Tytuł zdjęcia">
  <input type="text" name="author" placeholder="Autor">
  <input type="submit" value="Wyślij zdjęcie" name="submit">
</form>



</body>
</html>
