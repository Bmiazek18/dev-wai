
<link rel="stylesheet" href="static/css/gallery.css">

<div class="gallery-container">
    <?php include 'partials/favorites.php'; ?>
   
<div class="gallery">
<?php if (!empty($images)): ?>
    <?php foreach ($images as $img): ?>
        <?php $id = (string) $img['_id']; ?>
        <div class="image-item">
            <input type="checkbox" name="remove[]" value="<?php echo $id; ?>">
            <img src="uploads/<?php echo htmlspecialchars($img['filename']); ?>" alt="">
            <p><?php echo htmlspecialchars($img['author']); ?> – <?php echo htmlspecialchars(
     $img['title'],
 ); ?></p>

            <form method="POST" action="/aktualizuj_ilosc">
                Ilość: <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $favorites[
    $id
]['quantity'] ?? 1; ?>" min="1">
                <button type="submit">Zmień</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Brak zapamiętanych zdjęć.</p>
<?php endif; ?>
</div>

<button type="submit">🗑️ Usuń zaznaczone z zapamiętanych</button>


<div class="cart-status">
    🧺 Razem elementów: <?php echo $cartCount ?? 0; ?>
    <a href="/">Powrót do galerii</a>
</div>
</div>
    
</div>