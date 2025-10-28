<div class="gallery">
<?php if (!empty($thumbs)): ?>
    <?php foreach ($thumbs as $thumb): ?>
        <img src="<?php echo $thumb; ?>" alt="">
    <?php endforeach; ?>
<?php else: ?>
    <p>Brak zdjęć w galerii.</p>
<?php endif; ?>
</div>

<div class="pagination">
<?php if ($currentPage > 1): ?>
    <a href="?page=<?php echo $currentPage - 1; ?>">&laquo; Poprzednia</a>
<?php endif; ?>

<?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <?php if ($i == $currentPage): ?>
        <span class="current"><?php echo $i; ?></span>
    <?php else: ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php endif; ?>
<?php endfor; ?>

<?php if ($currentPage < $totalPages): ?>
    <a href="?page=<?php echo $currentPage + 1; ?>">Następna &raquo;</a>
<?php endif; ?>
</div>
