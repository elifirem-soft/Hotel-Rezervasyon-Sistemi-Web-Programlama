<?php 
if (session_status() === PHP_SESSION_NONE) {      
    session_start();  
}   

require_once 'db.php';    

try {      
    $query = "SELECT * FROM rooms";  
    $stmt = $pdo->prepare($query);  
    $stmt->execute();              
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC); 
} catch (PDOException $e) {
    die("Odalar yüklenirken hata oluştu: " . $e->getMessage());
}    

function getRoomDescription($roomType) { 
    $descriptions = [
        'Standart Twin'           => 'STANDART 2 AYRI TEK YATAKLI ODA, 15 METREKARELİK BİR YAŞAM ALANINA SAHİPTİR.',
        'Superior Twin'           => 'SUPERİOR İKİ TEK YATAKLI, VERANDA BAHÇELİ 25 METREKARE ODA',
        'Garden Double'           => 'STANDARD TEK BÜYÜK YATAKLI ODA, 1 ÇİFT KİŞİLİK YATAK, VERANDA, BAHÇELİ',
        'Superior Double Balcony' => 'Superior Tek Büyük Yataklı Oda, Deniz Manzaralı, Balkonlu',
        'Superior Suit Patio'     => '2 ODA, 1 BÜYÜK(QUEEN) YATAK, 2 TEK YATAK, KISMİ DENİZ MANZARALI SUİT ODA',
        'Leb-i Derya Suit'        => 'JUNİOR SÜİT, 2 YATAK ODASI, 1 BÜYÜK VE 1 TEK KİŞİLİK YATAK, AÇIK DENİZ MANZARALI ODA'
    ];
    return $descriptions[$roomType] ?? 'LİLİUM Otel Konforu'; 
}                                        
?>

<!DOCTYPE html>  
<html lang="tr">  
<head>  
    <meta charset="UTF-8">   
    <title>Odalar | LİLİUM Otel</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 


    <style>  
        * { margin: 0; padding: 0; box-sizing: border-box; }  
        body { font-family: 'Montserrat', sans-serif; background-color: #fff; -webkit-font-smoothing: antialiased; }

        header { position: absolute; top: 0; width: 100%; z-index: 100; padding: 25px 5%; }
        .navbar { display: flex; justify-content: space-between; align-items: center; }
        .navbar .logo { font-family: 'Playfair Display', serif; font-size: 26px; color: #fff; text-decoration: none; letter-spacing: 4px; text-transform: uppercase; }
        .navbar .menu a { color: #fff; text-decoration: none; margin-left: 25px; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; font-weight: 500; }
        .btn-nav-rez { background: #b38a65; padding: 10px 22px; font-weight: 600; color: white !important; }

        .hero-banner { 
            height: 40vh; 
            background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.25)), url('12.jpeg') center/cover; 
            display: flex; align-items: flex-end; padding: 0 5% 40px 5%; color: #fff;
        }
        .hero-banner h1 { 
            font-family: 'Playfair Display', serif; 
            font-size: 54px; 
            font-weight: 400; 
            letter-spacing: 2px; 
        }

        .intro-section { padding: 80px 5% 60px 5%; text-align: center; }
        .section-title { 
            font-family: 'Playfair Display', serif; 
            font-size: 52px; 
            margin-bottom: 10px; 
            font-weight: 400; 
            color: #1a1a1a; 
            letter-spacing: -0.5px;
        }
        .intro-section p { 
            font-size: 18px; 
            color: #243954; 
            line-height: 1.6; 
            max-width: 700px; 
            margin: 0 auto; 
            display: block; 
            font-weight: 300; 
        }

        /* ODALAR GRID */  
        .container { padding: 0 5% 100px 5%; }  
        .rooms-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; }
        .room-card { position: relative; height: 420px; overflow: hidden; background: #000; cursor: pointer; } 
        .room-card img { width: 100%; height: 100%; object-fit: cover; opacity: 0.9; transition: 0.8s ease; }
        .room-card:hover img { opacity: 0.6; transform: scale(1.05); }
        .room-overlay { position: absolute; bottom: 0; left: 0; width: 100%; padding: 40px; background: linear-gradient(transparent, rgba(0,0,0,0.85)); color: white; z-index: 2; }
        .room-overlay h3 { font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 5px; font-weight: 400; }
        .room-details-hover { max-height: 0; opacity: 0; transform: translateY(15px); transition: all 0.5s ease; }
        .room-card:hover .room-details-hover { max-height: 250px; opacity: 1; transform: translateY(0); }
        .room-price-hover { font-size: 18px; color: #d4a373; font-weight: 500; margin-bottom: 10px; letter-spacing: 1px; display: block; }
        .room-desc { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.8); margin-bottom: 20px; border-top: 1px solid rgba(255,255,255,0.3); padding-top: 15px; }

        .btn-examine { font-size: 14px; color: white; text-decoration: none; letter-spacing: 2px; text-transform: uppercase; position: relative; padding-bottom: 5px; transition: 0.3s; display: inline-block; }
        .btn-examine::after { content: ''; position: absolute; left: 0; bottom: 0; width: 60px; height: 1px; background-color: white; transition: 0.3s; }
        .btn-examine:hover { color: #d4a373; } 
        .btn-examine:hover::after { background-color: #d4a373; width: 100%; }

        @media (max-width: 991px) { .rooms-grid { grid-template-columns: 1fr; } .room-card { height: 350px; } .hero-banner h1 { font-size: 40px; } }
    </style>
</head>

<body> 

    <header>
        <nav class="navbar">
            <a href="index.php" class="logo">LİLİUM</a>
            <div class="menu">
                <a href="rooms.php">Odalar</a>
                <a href="index.php#galeri">Galeri</a>
                <a href="reservations.php" class="btn-nav-rez">Rezervasyon</a>
            </div>
        </nav>
    </header>

    <section class="hero-banner">
        <h1>Odalar</h1>
    </section>

    <section class="intro-section">
        <div style="margin-bottom: 10px;" class="section-title">LİLİUM'daki Odanızı Seçin</div> 
        <div class="class">
            <p style="color: #243954;">Son derece şık, bir o kadar da ferah dizayn edilmiş odalarımız ile ayrıcalıklı bir konaklama deneyimi sunuyoruz.</p>
        </div>  
    </section>

    <div class="container">   
        <div class="rooms-grid">
            <?php foreach ($rooms as $room): ?> 
                <div class="room-card" onclick="location.href='room-detail.php?id=<?php echo $room['room_id']; ?>'">  
                    <img src="<?php echo htmlspecialchars($room['image_url']); ?>" alt="Oda">  
                    
                    <div class="room-overlay">   
                        <h3><?php echo htmlspecialchars($room['room_type']); ?></h3> 
                        
                        <div class="room-details-hover">
                            <span class="room-price-hover">
                                ₺<?php echo number_format($room['price_per_night'], 0, ',', '.'); ?> / Gece   
                            </span>  
                            <p class="room-desc">
                                <?php echo getRoomDescription($room['room_type']); ?>  
                            </p>
                            <span class="btn-examine">İNCELE</span> 
                        </div>
                    </div>
                </div>
            <?php endforeach; ?> 
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  

</body>
</html>