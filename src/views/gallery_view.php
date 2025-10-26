<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Galeria zdjęć</title>
<link rel="stylesheet" href="static/css/gallery.css">


</head>
<body>

<h1>Galeria zdjęć</h1>

<div class="gallery">
<?php if (!empty($thumbs)): ?>
    <?php foreach ($thumbs as $thumb): ?>
        <?php $filename = basename($thumb); ?>
        
            <img src="uploads/thumbs/<?php echo $filename; ?>" alt="">
        
    <?php endforeach; ?>
<?php else: ?>
    <p>Brak zdjęć w galerii.</p>
<?php endif; ?>
</div>

</body>
</html>