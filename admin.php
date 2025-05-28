<?php
require 'config.php';
if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) header("Location: login.php");

// Ürün ekleme
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $original = $_POST['original_price'] ?: null;
    $cat = $_POST['category'];
    $link = $_POST['affiliate_link'];
    $desc = $_POST['description'];
    $campaign = isset($_POST['campaign']) ? 1 : 0;

    // Resim yükle
    $img_names = [];
    foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {
        $img = uniqid() . "_" . $_FILES['images']['name'][$i];
        move_uploaded_file($tmp, "uploads/$img");
        $img_names[] = $img;
    }
    $imgs = implode(',', $img_names);

    $stmt = $pdo->prepare("INSERT INTO products (name, price, original_price, category_id, affiliate_link, description, images, campaign_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $price, $original, $cat, $link, $desc, $imgs, $campaign]);

    // Kampanya bildirimi
    if ($campaign) {
        $mails = $pdo->query("SELECT email FROM users WHERE notify_campaign=1 AND verified=1")->fetchAll(PDO::FETCH_COLUMN);
        foreach ($mails as $mail) send_verification_mail($mail, "Yeni kampanyalı ürün: $name");
    }
    echo "Ürün eklendi!";
}
?>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" required placeholder="Ürün adı">
    <input type="text" name="price" required placeholder="Fiyat">
    <input type="text" name="original_price" placeholder="Orjinal Fiyat (kampanya için)">
    <select name="category">
        <?php foreach ($pdo->query("SELECT * FROM categories") as $cat)
            echo "<option value='{$cat['id']}'>{$cat['name']}</option>"; ?>
    </select>
    <input type="text" name="affiliate_link" required placeholder="Affiliate Link">
    <textarea name="description" placeholder="Açıklama"></textarea>
    <input type="file" name="images[]" multiple required>
    <label><input type="checkbox" name="campaign"> Kampanya</label>
    <button type="submit" name="add_product">Ekle</button>
</form>