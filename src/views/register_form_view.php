<h2>Rejestracja</h2>
<form action="/auth/register" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="file" id="fileToUpload"><br><br>
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Zarejestruj się</button>
</form>

<?php if (!empty($error)): ?>
<p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if (!empty($message)): ?>
<p style="color:green;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>
