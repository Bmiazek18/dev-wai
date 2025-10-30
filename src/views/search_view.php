<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Wyszukiwarka zdjęć (MVC + AJAX)</title>
<link rel="stylesheet" href="static/css/gallery.css"/>
</head>
<body>
<div class="gallery-container">
<h2>🔍 Wyszukiwarka zdjęć</h2>
<input type="text" id="search" placeholder="Wpisz fragment tytułu...">
<div id="results" class="gallery"></div>
</div>
<script>
const input = document.getElementById('search');
const results = document.getElementById('results');

input.addEventListener('keyup', async () => {
  const q = input.value.trim();
  if (!q) { results.innerHTML = ''; return; }

  const response = await fetch('/ajax_search?q=' + encodeURIComponent(q));
  results.innerHTML = await response.text();
});
</script>

</body>
</html>
