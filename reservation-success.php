<?php
session_start();
// Eğer session boşsa ana sayfaya at
if (!isset($_SESSION['booking_data'])) {
    header("Location: index.php");
    exit;
}

$data = $_SESSION['booking_data'];

// Cinsiyet kontrolü ve Başlık (Bey/Hanım)
$gender = $data['gender'] ?? 'Kadın';
$title = ($gender == 'Erkek') ? 'Bey' : 'Hanım';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Rezervasyonunuz Alındı | LİLİUM Otel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Prata&display=swap" rel="stylesheet">
    <style>
        body { 
            margin: 0; padding: 0; min-height: 100vh; 
            background-color: #f2ece4; /* Arka plan: Sütlü kahve */
            font-family: 'Montserrat', sans-serif; 
            color: #2d2d2d; /* Ana metin rengi: Net ve Okunaklı */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Üst Header */
        .page-header { 
            background: #fff; padding: 30px 60px; display: flex; justify-content: space-between; align-items: center; 
            width: 100%; border-bottom: 1px solid #e0dcd5;
        }
        .logo { font-family: 'Prata', serif; font-size: 26px; letter-spacing: 4px; text-transform: uppercase; color: #2d2d2d; text-decoration:none; }
        
        /* Kart Tasarımı */
        .success-card {
            background: #fdfbf7; /* Kart: Çok açık krem */
            padding: 60px; 
            border-radius: 4px; 
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            width: 90%; 
            max-width: 500px;
            margin-top: 60px; 
            margin-bottom: 50px;
        }
        h3 { font-family: 'Playfair Display', serif; font-size: 32px; color: #2d2d2d; margin-bottom: 10px; }
        .welcome-msg { font-size: 16px; color: #444; margin-bottom: 30px; font-style: italic; }
        
        .details { 
            text-align: left; 
            border-top: 1px solid #dcdad5;
            border-bottom: 1px solid #dcdad5;
            padding: 25px 0; 
            margin: 20px 0; 
            font-size: 14px;
            color: #333;
        }
        .details p { margin-bottom: 10px; display: flex; justify-content: space-between; }
        .details strong { color: #9c754d; } /* Bronz tonu biraz daha belirginleştirdik */
        
        .cash-alert { 
            background: #f5efe8; 
            color: #7a5e30; 
            padding: 15px; 
            font-size: 13px; 
            border-radius: 4px; 
            margin-top: 20px; 
            font-weight: 600;
        }
        .footer-text { font-size: 12px; color: #666; margin-top: 30px; }
    </style>
</head>
<body>

<div class="page-header">
    <a href="index.php" class="logo">LİLİUM</a>
    <a href="index.php" style="text-decoration:none; color:#2d2d2d; font-size:12px; letter-spacing:1px; text-transform:uppercase; font-weight: 500;">Ana sayfa</a>
</div>

<div class="success-card">
    <h3>Rezervasyonunuz Alındı!</h3>
    <p class="welcome-msg">Sizi ağırlamak için sabırsızlanıyoruz, Sayın <strong><?php echo htmlspecialchars($data['name']) . " " . $title; ?></strong>.</p>
    
    <div class="details">
        <p><strong>Oda:</strong> <span><?php echo htmlspecialchars($data['room_name']); ?></span></p>
        <p><strong>Oda Sayısı:</strong> <span><?php echo htmlspecialchars($data['room_count']); ?> Oda</span></p>
        <p><strong>Misafir:</strong> <span><?php echo htmlspecialchars($data['guests']); ?> Yetişkin</span></p>
        <p><strong>Süre:</strong> <span><?php echo $data['nights']; ?> Gece</span></p>
        <p><strong>Tarih:</strong> <span><?php echo htmlspecialchars($data['check_in']); ?> - <?php echo htmlspecialchars($data['check_out']); ?></span></p>
        <p><strong>Ödeme:</strong> <span><?php echo htmlspecialchars($data['payment_method']); ?></span></p>
        
        <?php if($data['payment_method'] == 'Nakit'): ?>
            <div class="cash-alert">
                Ödemenizi otele giriş esnasında resepsiyondan yapabilirsiniz.
            </div>
        <?php endif; ?>
    </div>
    
    <p class="footer-text">
        <span id="countdown">5</span> saniye içinde ana sayfaya dönüyorsunuz...
    </p>
</div>

<script>
    let timeLeft = 5;
    const countdownElement = document.getElementById('countdown');
    
    const timer = setInterval(function() {
        timeLeft--;
        countdownElement.innerText = timeLeft;
        if (timeLeft <= 0) {
            clearInterval(timer);
            window.location.href = "index.php";
        }
    }, 1000);
</script>
</body>
</html>