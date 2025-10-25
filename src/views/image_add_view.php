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
  <input type="submit" value="Upload Image" name="submit">
</form>



</body>
</html>
