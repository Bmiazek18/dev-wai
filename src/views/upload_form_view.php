<?php
$user = $_SESSION['user'] ?? null; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Dodaj zdjęcie</title>
    <link rel="stylesheet" href="static/css/upload.css"/>
</head>
<body>

<?php if (!empty($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<div class="upload-form-container">
  <form action="/upload" method="post" enctype="multipart/form-data">
    <h2>📷 Dodaj nowe zdjęcie</h2>

    <label for="fileToUpload">Wybierz zdjęcie:</label>
    <input type="file" name="file" id="fileToUpload" accept="image/*" required>

    <input type="text" name="title" placeholder="Tytuł zdjęcia" required>

    <!-- Jeśli użytkownik zalogowany, wypełniamy pole autora -->
    <input type="text" name="author" placeholder="Autor" 
           value="<?= htmlspecialchars($user['username'] ?? '') ?>" 
           <?= $user ? 'readonly' : '' ?> required>

    <input type="submit" value="Wyślij zdjęcie" name="submit">
  </form>
</div>

</body>
</html>
