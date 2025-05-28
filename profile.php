<?php
require 'config.php';
if (!isset($_SESSION['user'])) header('Location: login.php');

// Favorileme
if (isset($_POST['add_favorite'])) {
    $pid = $_POST['fav_product_id'];
    $uid = $_SESSION['user']['id'];
    $pdo->prepare("INSERT IGNORE INTO favorites (user_id, product_id) VALUES (?, ?)")->execute([$uid, $pid]);
}

// Favori çıkarma
if (isset($_POST['remove_favorite'])) {
    $pid = $_POST['fav_product_id'];
    $uid = $_SESSION['user']['id'];
    $pdo->prepare("DELETE FROM favorites WHERE user_id=? AND product_id=?")->execute([$uid, $pid]);
}

// Kampanya bildirimi ayarı
if (isset($_POST['notify'])) {
    $val = $_POST['notify_campaign'] ? 1 : 0;
    $pdo->prepare("UPDATE users SET notify_campaign=? WHERE id=?")->execute([$val, $_SESSION['user']['id']]);
    $_SESSION['user']['notify_campaign'] = $val;
}

// Favori ürünler
$stmt = $pdo->prepare("SELECT p.* FROM products p JOIN favorites f ON p.id=f.product_id WHERE f.user_id=?");
$stmt->execute([$_SESSION['user']['id']]);
$favs = $stmt->fetchAll();
?>
<h3>Profil</h3>
<form method="post">
    <label>
        <input type="checkbox" name="notify_campaign" value="1" <?= $_SESSION['user']['notify_campaign'] ? 'checked' : '' ?>>
        Kampanya bildirimlerini al
    </label>
    <button type="submit" name="notify">Kaydet</button>
</form>

<h4>Favori Ürünler</h4>
<ul>
<?php foreach ($favs as $f): ?>
    <li>
        <a href="product.php?id=<?= $f['id'] ?>"><?= $f['name'] ?></a>
        <form method="post" style="display:inline">
            <input type="hidden" name="fav_product_id" value="<?= $f['id'] ?>">
            <button type="submit" name="remove_favorite">Çıkar</button>
        </form>
    </li>
<?php endforeach; ?>
</ul>