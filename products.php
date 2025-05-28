<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Affiluxe - Çok Satanlar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .content { background: white; border-radius: 12px; margin-top: 2rem; padding: 2rem;}
        @media (max-width: 900px) { .header-container{flex-direction:column;} }
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
<div class="container">
    <div class="content">
        <h2>Affiluxe - Çok Satanlar</h2>
        <p>Burada en çok satan ürünler ve fırsatlar yer alacak.</p>
        <!-- Dilersen ürün döngüsünü buraya da ekleyebilirsin. -->
    </div>
</div>
</body>
</html>