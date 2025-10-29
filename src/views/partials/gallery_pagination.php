<?php if ($totalPages > 1): ?>
<div class="pagination">
    <?php if ($currentPage > 1): ?>
        <a href="?page=<?php echo $currentPage - 1; ?>" class="page-btn">&laquo; Poprzednia</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $currentPage): ?>
            <span class="page-btn current"><?php echo $i; ?></span>
        <?php else: ?>
            <a href="?page=<?php echo $i; ?>" class="page-btn"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($currentPage < $totalPages): ?>
        <a href="?page=<?php echo $currentPage + 1; ?>" class="page-btn">Następna &raquo;</a>
    <?php endif; ?>
</div>
<?php endif; ?>
