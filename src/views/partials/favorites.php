<?php
$favorites = $_SESSION['favorites'] ?? [];
$totalItems = 0;

foreach ($favorites as $fav) {
    $totalItems += $fav['quantity'] ?? 1;
}
?>

<div class="cart-status">
    <div>
        <strong>Zapamiętane zdjęcia:</strong> 
        <span id="favorites-count"><?php echo $totalItems; ?></span>
    </div>
    <div>
        <a href="/zapamietane">Przejdź do zapamiętanych →</a>
    </div>
</div>
