<link rel="stylesheet" href="static/css/header.css"/>
<?php $user = $_SESSION['user'] ?? null; ?>

<header class="main-header">
    <div class="container">
        <div class="logo">
            <a href="/">🎨 Moja Galeria</a>
        </div>

        <nav class="nav-menu">
            <a href="/">Galeria</a>
            <a href="/dodaj-zdjecie">Dodaj zdjęcie</a>
           
        </nav>

        <div class="user-panel">
            <?php if ($user): ?>
                <img class="user-avatar" 
                     src="/uploads/PhotoFiles/<?= htmlspecialchars(
                         $user['avatar'] ?? 'default.png',
                     ) ?>" 
                     alt="Avatar">
                <span class="user-name"><?= htmlspecialchars($user['username']) ?></span>
                <a class="btn-logout" href="/auth/logout">Wyloguj</a>
            <?php else: ?>
                <a class="btn-login" href="/logowanie">Zaloguj</a>
                <a class="btn-register" href="/rejestracja">Rejestracja</a>
            <?php endif; ?>
        </div>
    </div>
</header>

