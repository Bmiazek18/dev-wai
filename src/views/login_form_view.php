<link rel="stylesheet" href="static/css/upload.css"/>

<div class="upload-form-container">

    <form action="/auth/login" method="post">
        <h2>🔐 Logowanie</h2>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Zaloguj się">
    </form>

    <?php if (!empty($error)): ?>
        <p class="upload-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

</div>
