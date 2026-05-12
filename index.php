<?php session_start(); ?> 
<!DOCTYPE html>  
<html lang="tr"> 
<head>  
    <meta charset="UTF-8"> 
    <title>LİLİUM Otel | GölTürkbükü</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,500&family=Prata&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* --- GENEL AYARLAR --- */
        html { scroll-behavior: smooth; }
        body, html { margin: 0; padding: 0; font-family: 'Montserrat', sans-serif; background-color: white; overflow-x: hidden; -webkit-font-smoothing: antialiased; }

        /* --- NAVBAR --- */
        .navbar { position: absolute; width: 100%; top: 0; display: flex; justify-content: space-between; align-items: center; padding: 25px 60px; box-sizing: border-box; z-index: 100; color: white; }
        .navbar .logo { font-family: 'Prata', serif; font-size: 28px; letter-spacing: 5px; text-transform: uppercase; color: white; text-decoration: none; }
        .navbar .menu a { color: white; text-decoration: none; margin: 0 18px; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; font-weight: 600; transition: 0.3s; }
        .navbar .menu a:hover { opacity: 0.7; }
        .btn-nav-rez { background-color: #b38a65; padding: 10px 22px; transition: 0.3s; }
        .btn-nav-rez:hover { background-color: #967354; }

        /* --- HERO AREA --- */
        .hero { height: 100vh; position: relative; background: linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.35)), url('thumbnail_5.jpg') center/cover; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; color: white; }
        .hero-content h1 { font-family: 'Playfair Display', serif; font-size: 60px; margin: 0; text-transform: uppercase; letter-spacing: 8px; line-height: 1.1; }
        
        .btn-main-rez { display: inline-block; margin-top: 40px; padding: 20px 50px; background-color: #b38a65; color: white; text-decoration: none; text-transform: uppercase; font-size: 14px; letter-spacing: 3px; font-weight: 600; transition: 0.4s ease; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .btn-main-rez:hover { background-color: white; color: #333; transform: translateY(-3px); }

        .btn-hero-rooms { display: inline-block; margin-top: 20px; padding: 15px 35px; border: 1px solid rgba(255,255,255,0.6); color: white; text-decoration: none; text-transform: uppercase; font-size: 13px; letter-spacing: 2px; font-weight: 600; transition: 0.4s ease; background: transparent; }
        .btn-hero-rooms:hover { background: white; color: #333; }

        /* --- TANITIM SECTION --- */
        .section-intro { display: flex; padding: 100px 60px; background-color: #f9f7f2; align-items: center; }
        .intro-text-block { flex: 1; padding-right: 60px; text-align: left; }
        .intro-stars { color: #b38a65; font-size: 14px; margin-bottom: 20px; }
        .intro-title { font-family: 'Playfair Display', serif; font-size: 42px; color: #333; margin-bottom: 30px; font-weight: 400; }
        .intro-desc { font-size: 15px; color: #666; line-height: 1.8; margin-bottom: 40px; font-weight: 300; }
        .reservations-call { display: flex; align-items: center; gap: 15px; }
        .call-text a { font-size: 20px; color: #333; text-decoration: none; font-weight: 600; }
        .intro-image-block { flex: 1; }
        .intro-image-block img { width: 100%; border-radius: 10px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }

        /* --- ODALAR SECTION (YENİ TASARIM) --- */
        .section-rooms { padding: 120px 60px; background-color: white; text-align: left; }
        .rooms-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 40px; }
        
        .room-card { position: relative; background: none; cursor: pointer; }
        .room-image-wrapper { position: relative; height: 480px; overflow: hidden; background: #000; }
        .room-image-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: 0.8s ease; }
        .room-card:hover .room-image-wrapper img { transform: scale(1.05); opacity: 0.8; }

        /* Bilgi Alanı */
        .room-info { padding: 25px 0 10px 0; }
        .room-info h3 { font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 10px; font-style: italic; color: #1a1a1a; font-weight: 400; }
        .room-price { font-size: 18px; color: #b38a65; font-weight: 500; margin-bottom: 20px; letter-spacing: 1px; }

        .room-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #eee; padding-top: 20px; }
        .room-desc { font-size: 10px; color: #888; letter-spacing: 1.5px; text-transform: uppercase; font-weight: 400; max-width: 70%; line-height: 1.6; }

        /* İncele Butonu */
        .btn-examine { font-size: 13px; color: #1a1a1a; text-decoration: none; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; position: relative; padding-bottom: 5px; transition: 0.3s; border-bottom: 1px solid #1a1a1a; }
        .btn-examine:hover { color: #b38a65; border-color: #b38a65; }

        /* --- DİĞER BÖLÜMLER --- */
        .section-divider-parallax { height: 450px; background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.1)), url('ig9.jpg') center/cover fixed; width: 100%; }

        .section-gallery { padding: 100px 60px; background-color: #f9f7f2; }
        .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 40px; }
        .gallery-item { height: 250px; overflow: hidden; border-radius: 4px; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: 0.4s; }
        .gallery-item:hover img { transform: scale(1.05); }

        .section-features { padding: 100px 60px; background-color: white; }
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 40px; }
        .feature-item { border: 1px solid #f0f0f0; padding: 40px; transition: 0.3s; }
        .feature-item h3 { font-family: 'Playfair Display', serif; font-size: 24px; color: #333; margin-bottom: 15px; }
        .feature-item p { font-size: 14px; color: #777; line-height: 1.7; font-weight: 300; }

        .section-rez-banner { position: relative; height: 450px; background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('thumbnail_9.jpg') center/cover fixed; display: flex; align-items: center; justify-content: center; padding: 0 60px; color: white; }
        .rez-banner-container { display: flex; justify-content: space-between; align-items: flex-end; width: 100%; max-width: 1200px; }
        .rez-banner-left h2 { font-family: 'Playfair Display', serif; font-size: 40px; line-height: 1.3; font-weight: 400; }
        .btn-rez-large { display: inline-block; background-color: #b38a65; color: white; padding: 15px 40px; text-decoration: none; text-transform: uppercase; font-size: 13px; letter-spacing: 2px; font-weight: 600; transition: 0.3s; }

        /* --- FOOTER --- */
        .main-footer { background-color: #f9f7f2; padding: 60px 60px 30px 60px; border-top: 1px solid #eee; }
        .footer-brand .logo { font-family: 'Prata', serif; font-size: 28px; color: #b38a65; letter-spacing: 5px; text-transform: uppercase; margin-bottom: 20px; }
        .footer-bottom { border-top: 1px solid #e5e0d5; padding-top: 30px; margin-top: 40px; display: flex; justify-content: space-between; font-size: 12px; color: #999; }

        @media (max-width: 991px) {
            .navbar { padding: 20px; }
            .rooms-grid, .features-grid, .gallery-grid, .section-intro { grid-template-columns: 1fr; }
            .rez-banner-container { flex-direction: column; text-align: center; align-items: center; }
            .rez-banner-right { margin-top: 20px; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="index.php" class="logo">LİLİUM</a>
        <div class="menu">
            <a href="#odalar-section">Odalar</a>
            <a href="#galeri">Galeri</a>
            <a href="reservations.php" class="btn-nav-rez">Rezervasyon</a>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <p style="letter-spacing:3px; text-transform:uppercase; font-size:12px; margin-bottom:10px;">LİLİUM Otel Göltürkbükü</p>
            <h1>HİKÂYEN <br> BURADA BAŞLIYOR</h1>
            <a href="reservations.php" class="btn-main-rez">HEMEN REZERVASYON YAP</a>
            <br>
            <a href="#odalar-section" class="btn-hero-rooms">ODALARIMIZI İNCELEYİN</a>
        </div>
    </header>

    <section id="tanitim" class="section-intro">
        <div class="intro-text-block">
            <div class="intro-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
            <h2 class="intro-title">Sofistike, Doğal ve Konforlu</h2>
            <p class="intro-desc">Ege’nin eşsiz maviliklerine açılan LİLİUM Otel, Bodrum’un en gözde tatil bölgelerinden biri olan Göltürkbükü’nde, denize sıfır konumuyla huzur ve konforu bir arada sunuyor.</p>
            <div class="reservations-call">
                <i class="fas fa-phone-alt" style="color: #b38a65; font-size: 24px;"></i>
                <div class="call-text">
                    <p style="margin:0; font-size:12px; color:#888; text-transform:uppercase;">Doğrudan İletişim</p>
                    <a href="tel:05393876060">0539 387 6060</a>
                </div>
            </div>
        </div>
        <div class="intro-image-block">
            <img src="Genel_Alanlar-_-_46.jpeg" alt="LİLİUM Otel">
        </div>
    </section>

    <section id="odalar-section" class="section-rooms" style="padding: 100px 60px; background-color: white;">
        <p style="letter-spacing:3px; color:#888; text-transform:uppercase; font-size:11px;">LİLİUM Otel Göltürkbükü</p>
        <h2 class="intro-title" style="margin-top:10px; font-family: 'Playfair Display', serif; font-size: 42px; font-weight: 400;">Odalar</h2>
        
        <div class="rooms-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; margin-top: 40px;">
            
            <div class="room-card" onclick="location.href='room-detail.php?id=1'" style="position: relative; height: 480px; overflow: hidden; background: #000; cursor: pointer;">
                <img src="standart-twin.jpg" alt="Standart Twin" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9; transition: 0.8s ease;">
                
                <div class="room-overlay" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 40px; background: linear-gradient(transparent, rgba(0,0,0,0.85)); color: white; box-sizing: border-box;">
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 5px; font-weight: 400;">Standart Twin</h3>
                    
                    <div class="room-details-hover">
                        <p style="font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.8); margin-bottom: 20px; border-top: 1px solid rgba(255,255,255,0.3); padding-top: 15px;">STANDART 2 AYRI TEK YATAKLI ODA, 15 METREKARELİK BİR YAŞAM ALANINA SAHİPTİR.</p>
                        <span class="btn-examine-index">İNCELE</span>
                    </div>
                </div>
            </div>

            <div class="room-card" onclick="location.href='room-detail.php?id=2'" style="position: relative; height: 480px; overflow: hidden; background: #000; cursor: pointer;">
                <img src="superior-twin.jpg" alt="Superior Twin" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9; transition: 0.8s ease;">
                
                <div class="room-overlay" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 40px; background: linear-gradient(transparent, rgba(0,0,0,0.85)); color: white; box-sizing: border-box;">
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 5px; font-weight: 400;">Superior Twin</h3>
                    
                    <div class="room-details-hover">
                        <p style="font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.8); margin-bottom: 20px; border-top: 1px solid rgba(255,255,255,0.3); padding-top: 15px;">SUPERİOR İKİ TEK YATAKLI, VERANDA BAHÇELİ 25 METREKARE ODA</p>
                        <span class="btn-examine-index">İNCELE</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="all-rooms-container" style="margin-top: 60px; text-align: center;">
            <a href="rooms.php" class="btn-all-rooms" style="display: inline-block; background-color: #b38a65; color: white; padding: 18px 50px; text-decoration: none; text-transform: uppercase; font-size: 14px; letter-spacing: 2px; font-weight: 600; transition: 0.3s ease;">Tüm Odaları Keşfedin</a>
        </div>
    </section>

    <style>
        /* Resim kararma ve büyüme */
        .room-card:hover img { opacity: 0.6; transform: scale(1.05); }
        
        /* Detayların aşağıdan yukarı çıkışı */
        .room-details-hover { 
            max-height: 0; 
            opacity: 0; 
            transform: translateY(15px); 
            transition: all 0.5s ease; 
        }
        .room-card:hover .room-details-hover { 
            max-height: 200px; 
            opacity: 1; 
            transform: translateY(0); 
        }

        /* İNCELE BUTONU STİLİ */
        .btn-examine-index {
            font-size: 14px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            border-bottom: 1px solid white;
            padding-bottom: 5px;
            transition: 0.3s ease;
            display: inline-block;
        }

        /* Üzerine gelince Renk Değişimi (Rooms.php ile aynı bronz tonu) */
        .btn-examine-index:hover {
            color: #d4a373 !important;
            border-color: #d4a373 !important;
        }
    </style>

    <section class="section-divider-parallax"></section>

    <section id="galeri" class="section-gallery">
        <p style="letter-spacing:3px; color:#888; text-transform:uppercase; font-size:11px;">Görsel Bir Yolculuk</p>
        <h2 class="intro-title" style="margin-top:10px;">Galeri</h2>
        <div class="gallery-grid">
            <div class="gallery-item"><img src="thumbnail_5.jpg" alt="LİLİUM 1"></div>
            <div class="gallery-item"><img src="ig9.jpg" alt="LİLİUM 2"></div>
            <div class="gallery-item"><img src="Genel_Alanlar-_-_46.jpeg" alt="LİLİUM 3"></div>
            <div class="gallery-item"><img src="thumbnail_9.jpg" alt="LİLİUM 4"></div>
            <div class="gallery-item"><img src="superior-double-balcony-2.jpg" alt="LİLİUM 5"></div>
            <div class="gallery-item"><img src="Genel_Alanlar-_-_53.jpeg" alt="LİLİUM 6"></div>
        </div>
    </section>

    <section class="section-features">
        <div class="features-subtitle">Neler Sunuyoruz</div>
        <h2 class="intro-title" style="margin:0;">Otel Özellikleri</h2>
        <div class="features-grid">
            <div class="feature-item"><h3>Denize Sıfır</h3><p>Bodrum'un sularına doğrudan erişim imkanı sunan benzersiz bir konum.</p></div>
            <div class="feature-item"><h3>Ödüllü Plaj</h3><p>Mavi Bayrak ödüllü plajımızla mükemmel bir deniz keyfi sunar.</p></div>
            <div class="feature-item"><h3>Modern Odalar</h3><p>Tüm odalarımız konfor ve stilin uyumuyla dekore edilmiştir.</p></div>
        </div>
    </section>

    <footer class="main-footer">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="logo">LİLİUM</div>
                <p>Bodrum'un kalbinde denize sıfır huzuru keşfedin.</p>
                <div class="footer-contact">
                    <p><i class="fas fa-map-marker-alt" style="color:#b38a65;"></i> Göltürkbükü, Bodrum / Muğla</p>
                    <p><i class="fas fa-phone-alt" style="color:#b38a65;"></i> +90 (539) 387 60 60</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 LİLİUM Hotel. Tüm hakları saklıdır.</p>
            <p>"Ege'nin en saf haliyle tanışın."</p>
        </div>
    </footer>

</body>
</html>