<form method="POST" action="/zapamietaj">
<div class="gallery">
<?php if (!empty($images)): ?>
    <?php foreach ($images as $img): ?>
        <?php $id = (string) $img['_id']; ?>
        <div class="image-item">
            <input type="checkbox" name="selected[]" value="<?php echo $id; ?>"
                <?php echo isset($favorites[$id]) ? 'checked' : ''; ?>>
            <img src="uploads/thumbs/<?php echo htmlspecialchars($img['filename']); ?>" alt="">
            <p><?php echo htmlspecialchars($img['author']); ?> – <?php echo htmlspecialchars(
     $img['title'],
 ); ?>
 <?php if (isset($img['is_private']) && $img['is_private']): ?>
    <span style="color: red; font-weight: bold;">(Prywatne)</span>
 <?php endif; ?>
</p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Brak zdjęć w galerii.</p>
<?php endif; ?>
</div>

<button type="submit">📌 Zapamiętaj wybrane</button>
</form>






