<?php
require_once 'config.php';

// Ürünleri çek
$query = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 12");
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Affiluxe - Banlanmayan Alternatif Alışveriş Linkleri</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FontAwesome ve CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin:0; padding:0; background:#f5f7ff; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }
        header { background: linear-gradient(135deg, #e63946, #d90429); color: white; padding: 1rem 0; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .header-container { display:flex; justify-content:space-between; align-items:center; }
        .logo { font-size:1.8rem; font-weight:700; display:flex; align-items:center; }
        .logo i { margin-right:10px; color:white; }
        nav ul {display:flex; list-style:none; margin:0; padding:0;}
        nav ul li {margin-left:1.5rem;}
        nav ul li a {color:white; text-decoration:none; font-weight:500;}
        .product-grid { display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center; }
        .product-card { background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: 1px solid #eee; width: 300px; margin-bottom: 2rem; position:relative;}
        .product-badge { position: absolute; top: 10px; left: 10px; background: #e63946; color: white; padding: 0.3rem 0.8rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; z-index: 2; }
        .product-img { height: 200px; overflow: hidden; position: relative; background: #fafafa;}
        .product-img img { width: 100%; height: 100%; object-fit: cover; display:block;}
        .product-info { padding: 1.5rem; }
        .product-info h3 { margin: 0 0 1rem 0; font-size: 1.3rem; }
        .product-price { display: flex; align-items: center; margin-bottom: 1rem; }
        .current-price { font-size: 1.5rem; font-weight: 700; color: #e63946; }
        .old-price { font-size: 1rem; text-decoration: line-through; color: #999; margin-left: 0.8rem; }
        .discount { background: #2ec4b6; color: white; padding: 0.2rem 0.5rem; border-radius: 5px; font-size: 0.9rem; font-weight: 600; margin-left: 0.8rem; }
        .product-meta { color: #666; font-size: 0.9rem; margin-bottom: 1rem;}
        .product-link { display:block; text-align:center; background:#e63946; color:white; padding:0.8rem; border-radius:5px; text-decoration:none; font-weight:600; transition:all 0.3s;}
        .product-link:hover { background:#d90429; }
        @media (max-width: 900px) { .product-grid { flex-direction:column; align-items:center; } .header-container{flex-direction:column;} }
    </style>
</head>
<body>
<header>
    <div class="container header-container">
        <div class="logo">
            <i class="fas fa-fire-alt"></i>
            <span>Affiluxe</span>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="products.php">Çok Satanlar</a></li>
                <li><a href="deals.php">Fırsatlar</a></li>
                <li><a href="why-us.php">Neden Biz?</a></li>
                <li><a href="contact.php">İletişim</a></li>
            </ul>
        </nav>
    </div>
</header>

<section class="hot-products" id="products">
    <div class="container">
        <div class="section-title">
            <h2>ÇOK SATAN BANLI ÜRÜNLER</h2>
            <p>Binlerce kişinin bu linkler üzerinden alışveriş yaptığı ürünler</p>
        </div>
        <div class="product-grid">
            <?php foreach ($products as $urun):
                $imgList = isset($urun['images']) ? explode(',', $urun['images']) : [];
                $img = isset($imgList[0]) && $imgList[0] != '' ? $imgList[0] : 'default.jpg';
                $name = isset($urun['name']) ? $urun['name'] : '-';
                $price = isset($urun['price']) ? $urun['price'] : 0;
                $oldPrice = isset($urun['original_price']) ? $urun['original_price'] : null;
                $discount = ($oldPrice && $oldPrice > $price) ? round((($oldPrice-$price)/$oldPrice)*100) : 0;
                $link = isset($urun['affiliate_link']) ? $urun['affiliate_link'] : '#';
                $badge = (!empty($urun['campaign_active']) && $urun['campaign_active']) ? 'FIRSAT' : '';
            ?>
            <div class="product-card">
                <?php if($badge): ?>
                    <div class="product-badge"><?= $badge ?></div>
                <?php endif; ?>
                <div class="product-img">
                    <img src="uploads/<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($name) ?>">
                </div>
                <div class="product-info">
                    <h3><?= htmlspecialchars($name) ?></h3>
                    <div class="product-price">
                        <span class="current-price">₺<?= number_format($price, 0, ',', '.') ?></span>
                        <?php if($oldPrice): ?>
                            <span class="old-price">₺<?= number_format($oldPrice, 0, ',', '.') ?></span>
                        <?php endif; ?>
                        <?php if($discount > 0): ?>
                            <span class="discount">%<?= $discount ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="product-meta">
                        <span><i class="fas fa-check-circle"></i> Stokta</span>
                    </div>
                    <a href="<?= htmlspecialchars($link) ?>" class="product-link" target="_blank">BANLANMADAN AL (Affiliate Link)</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
</body>
</html>