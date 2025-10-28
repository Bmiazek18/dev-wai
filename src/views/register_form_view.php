<link rel="stylesheet" href="static/css/upload.css"/>

<div class="upload-form-container">

    <form action="/auth/register" method="post" enctype="multipart/form-data">
        <h2>🧑‍💻 Rejestracja</h2>

        <label for="fileToUpload">Wybierz zdjęcie profilowe:</label>
        <input type="file" name="file" id="fileToUpload" accept="image/*" required>

        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Zarejestruj się">
    </form>

    <?php if (!empty($error)): ?>
        <p class="upload-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($message)): ?>
        <p class="upload-success"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

</div>