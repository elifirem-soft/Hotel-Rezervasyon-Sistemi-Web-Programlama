<?php 
session_start(); 
require 'db.php';

$room_id = isset($_GET['id']) ? (int)$_GET['id'] : 0; 
if ($room_id <= 0) { header("Location: index.php"); exit; }

try {  
    $query = "SELECT * FROM rooms WHERE room_id = :id"; 
    $stmt = $pdo->prepare($query);  
    $stmt->execute(['id' => $room_id]);  
    $room = $stmt->fetch(PDO::FETCH_ASSOC);  
    if (!$room) { die("Oda bulunamadı!"); } 
} catch (PDOException $e) { die("Hata: " . $e->getMessage()); }

$room_type = $room['room_type'];

if($room_type == 'Leb-i Derya Suit') {  
    $h1_title = "Leb-i Derya Suit";  
    $intro_subtitle = "LİLİUM ROOM"; 
    $intro_text = "LİLİUM Otel'e hoş geldiniz! Leb-i Derya Suit odamız, aileler için özel olarak tasarlanmış, 35 metrekarelik geniş bir Junior Suit'tir. Bu özel süitte, 1 büyük ve 1 tek kişilik yatağın konumlandığı 2 ayrı yatak odası bulunmaktadır. Ayrıca, muhteşem deniz manzarasına sahip bir balkonu vardır.";
    $sections = [
        ["title" => "Benzersiz Açık Deniz Manzarası", "text" => "Leb-i Derya Suit odamızın balkonu, muhteşem bir açık deniz manzarasına sahiptir. Sabahları uyanır uyanmaz bu manzarayı görmek, tatiliniz boyunca huzur ve keyif dolu anlar yaşamanıza olanak tanır. Akşamları ise gün batımını bu eşsiz manzara eşliğinde izlemek unutulmaz bir deneyim olacaktır."],
        ["title" => "Geniş ve Konforlu Yaşam Alanı", "text" => "35 metrekarelik geniş yaşam alanı, misafirlerimize rahat bir konaklama imkanı sunar. İki ayrı yatak odası, ailelerin konforlu bir konaklama deneyimi yaşamasını sağlar. Odanın modern dekorasyonu ve şık tasarımı, konuklarımızın kendilerini özel hissetmelerine olanak tanır."],
        ["title" => "Aile İçin İdeal Konaklama Seçeneği", "text" => "Leb-i Derya Suit odamız, aileler için ideal bir konaklama seçeneği sunar. İki ayrı yatak odası, aile üyelerinin birlikte olmalarını sağlarken, aynı zamanda gizlilik ve rahatlık sunar. Misafirlerimiz, aileleriyle birlikte unutulmaz bir tatil deneyimi yaşayabilirler. Eğer siz de LİLİUM Otel'in Leb-i Derya Suit odasında ailenizle birlikte unutulmaz bir tatil deneyimi yaşamak istiyorsanız, hemen rezervasyonunuzu yapın!"]
    ];
    $amenities = ["Deniz manzarası", "35 metre kare", "3 Kişilik", "1 Büyük (King Size) Yatak ve 1 Tek Kişilik Yatak", "Ücretsiz kablosuz internet", "Ücretsiz Kahvaltı", "Ücretsiz valesiz otopark", "Otomatik soğutma/ısıtma sistemi", "Ücretsiz banyo/kozmetik ürünleri", "Saç kurutma makinesi", "Özel banyo", "Dijital TV ve düz ekran televizyon", "Minibar ve Oda Servisi (Sınırlı)", "Günlük kat hizmetleri", "Emanet kasası", "Çarşaf takımı", "Ücretsiz beşik/çocuk yatağı", "Portatif/ilave yatak yoktur"];
    $slides = [htmlspecialchars($room['image_url']), "leb-i-derya-banyo.jpeg"]; 

} elseif($room_type == 'Superior Suit Patio') {
    $h1_title = "Superior Suit Patio";
    $intro_subtitle = "LİLİUM ROOM";
    $intro_text = "Superior Suit Patio odamız, lüks bir konaklama deneyimi sunmak için özel olarak tasarlanmıştır. İçerisinde biri Queen olmak üzere toplam üç yatak bulunan bu süit odada, kısmi deniz manzarası ile birlikte 40 metrekarelik geniş bir yaşam alanı bulunmaktadır.";
    $sections = [
        ["title" => "Lüks Süit Konaklama", "text" => "Superior Suit Patio odamız, lüks bir konaklama deneyimi sunar. Modern iç mekan tasarımıyla dikkat çeken süit odamız, misafirlerimize maksimum konfor ve huzur sunmak üzere özenle tasarlanmıştır. Her detay, konuklarımızın beklentilerini karşılamak için özel olarak düşünülmüştür."],
        ["title" => "Geniş Yaşam Alanı", "text" => "Suit odamız, 40 metrekarelik geniş bir alana sahiptir. Bu genişlik, misafirlerimize rahat ve ferah bir konaklama imkânı sunar. Oda içindeki oturma alanı, dinlenmek ve vakit geçirmek için ideal bir ortam oluşturur."],
        ["title" => "Kısmi Deniz Manzarası", "text" => "Superior Suit Patio odamız, kısmi deniz manzarasına sahiptir. Sabahları uyanır uyanmaz Ege Denizi'nin büyüleyici manzarasını görmek, tatiliniz boyunca huzur ve keyif dolu anlar yaşamanıza olanak tanır."],
        ["title" => "Farklı Yatak Seçenekleri", "text" => "Odamızda biri Queen yatak olmak üzere toplam üç yatak bulunmaktadır. Bu farklı yatak seçenekleri, çeşitli konuk profillerine hitap etmektedir."],
        ["title" => "Özel Patio Alanı", "text" => "Superior Suit Patio odamız, özel bir patio alanına sahiptir. Bu alanda dışarıda oturma ve dinlenme imkanı sunulur. Misafirlerimiz, bahçenin huzurlu ortamında vakit geçirirken, tatilin keyfini çıkarabilirler."]
    ];
    $amenities = ["40 metre kare", "4 Kişilik", "Kısmi Deniz manzarası", "1 büyük (King Size) Boy Yatak", "Ücretsiz kablosuz internet", "Ücretsiz Kahvaltı", "Ücretsiz valesiz otopark", "Otomatik soğutma/ısıtma sistemi", "Ücretsiz banyo/kozmetik ürünleri", "Saç kurutma makinesi", "Özel banyo", "Dijital TV ve düz ekran televizyon", "Minibar ve Oda Servisi (Sınırlı)", "Günlük kat hizmetleri", "Emanet kasası", "Çarşaf takımı", "Ücretsiz beşik/çocuk yatağı", "Portatif/ilave yatak yoktur"];
    $slides = [htmlspecialchars($room['image_url']), "banyo.jpg"];

} elseif($room_type == 'Superior Double Balcony') {
    $h1_title = "Superior Double Balcony";
    $intro_subtitle = "LİLİUM ROOM";
    $intro_text = "LİLİUM Otel'de Göltürkbükü’nün Eşsiz Güzelliğiyle Tanışın! Bodrum'un kalbindeki sıcak ve konforlu adresimizde, Superior Double Balcony odamızda sizi bekleyen unutulmaz bir deneyim için hazır olun.";
    $sections = [
        ["title" => "Genişlik ve Konforun Buluştuğu Alan", "text" => "LİLİUM Otel Superior Double Balcony odamız ile 30 metrekarelik ferah bir yaşam alanı sunuyoruz. Misafirlerimizin rahatı ve konforu göz önünde bulundurularak özenle tasarlanan odamızın her köşesi, konforunuzu maksimumda tutmak için özel olarak hazırlanmıştır."],
        ["title" => "Huzur Dolu Manzara", "text" => "Odamızın pencereleri, Göltürkbükü’nün sakin ve huzur veren manzarasına açılır. Sabahları uyanır uyanmaz bu eşsiz manzarayı görmek, tatiliniz boyunca keyif dolu anlar yaşamanıza olanak tanır."],
        ["title" => "Konforlu Yatak ve Rahat Bir Dinlenme Alanı", "text" => "Odada bulunan geniş yataklarımız, konuklarımıza rahat bir uyku deneyimi sunar. Yatağın kalitesi ve konforu, misafirlerimizin dinlenme ihtiyacını en iyi şekilde karşılar. Ayrıca, odanın iç tasarımı, dinlenmek ve gevşemek için ideal bir ortam sağlar."],
        ["title" => "Balkon Keyfi", "text" => "Superior Double Balcony odamızda bulunan özel balkon, misafirlerimize dışarıda vakit geçirme ve Bodrum’un güneşli ikliminin tadını çıkarma imkânı sunar."]
    ];
    $amenities = ["Kısmi Deniz manzarası", "30 metre kare", "2 kişilik", "1 büyük (King Size) Boy Yatak", "Ücretsiz kablosuz internet", "Ücretsiz Kahvaltı", "Ücretsiz valesiz otopark", "Otomatik soğutma/ısıtma sistemi", "Ücretsiz banyo/kozmetik ürünleri", "Saç kurutma makinesi", "Özel banyo", "Dijital TV ve düz ekran televizyon", "Minibar ve Oda Servisi (Sınırlı)", "Günlük kat hizmetleri", "Emanet kasası", "Çarşaf takımı", "Ücretsiz beşik/çocuk yatağı", "Portatif/ilave yatak yoktur"];
    $slides = [htmlspecialchars($room['image_url']), "banyo.jpg"];

} elseif($room_type == 'Garden Double') {
    $h1_title = "Garden Double";
    $intro_subtitle = "LİLİUM ROOM";
    $intro_text = "Garden Double odamız, yoğun şehir hayatından kaçmak ve huzurlu bir ortamda dinlenmek isteyen misafirlerimiz için mükemmel bir seçenektir. Tek büyük yatağı, verandası ve bahçe manzarasıyla bu oda, 25 metrekarelik geniş bir alana sahiptir.";
    $sections = [
        ["title" => "Huzur Dolu Bahçe Manzarası", "text" => "Garden Double odamız, özel bir bahçe manzarasına sahiptir. Doğanın yeşil dokusu ve huzur veren atmosferiyle çevrili olan bu odada, misafirlerimiz stresten uzaklaşarak ruhlarını dinlendirebilirler."],
        ["title" => "Rahatlık ve Konfor", "text" => "Odamız, tek büyük yatağıyla misafirlerimize rahat bir uyku deneyimi sunar. Ayrıca, 25 metrekarelik geniş alanı, konuklarımıza konforlu bir konaklama ve rahat bir dinlenme imkanı tanır. Veranda alanı ise açık havada vakit geçirmek için idealdir."],
        ["title" => "Doğayla İç İçe Bir Tatil Deneyimi", "text" => "Garden Double odamız, doğayla iç içe bir tatil deneyimi yaşamak isteyen misafirlerimiz için ideal bir seçenektir. Bahçenin huzurlu ortamında yürüyüş yapabilir, çiçeklerin ve ağaçların güzelliklerini keşfedebilirsiniz. Eğer siz de LİLİUM Otel'in Garden Double odasında huzur dolu bir konaklama deneyimi yaşamak istiyorsanız, hemen rezervasyonunuzu yapın."]
    ];
    $amenities = ["Bahçe manzarası", "25 metre kare", "2 kişilik", "1 büyük (King Size) Boy Yatak", "Ücretsiz kablosuz internet", "Ücretsiz Kahvaltı", "Ücretsiz valesiz otopark", "Otomatik soğutma/ısıtma sistemi", "Ücretsiz banyo/kozmetik ürünleri", "Saç kurutma makinesi", "Özel banyo", "Dijital TV ve düz ekran televizyon", "Minibar ve Oda Servisi (Sınırlı)", "Günlük kat hizmetleri", "Emanet kasası", "Çarşaf takımı", "Ücretsiz beşik/çocuk yatağı", "Portatif/ilave yatak yoktur"];
    $slides = [htmlspecialchars($room['image_url'])]; 

} elseif($room_type == 'Superior Twin') {
    $h1_title = "Superior Twin";
    $intro_subtitle = "LİLİUM ROOM";
    $intro_text = "Superior Twin odamız, modern iç mekânı, zarif detayları ve keyifli vakit geçirmek için ideal ortamıyla misafirlerimize hizmet vermektedir.";
    $sections = [
        ["title" => "Modern ve Zarif İç Mekan", "text" => "Superior Twin odamız, modern tasarımıyla dikkat çeker. Zarif detaylarla dekore edilmiş bu şık bu oda, misafirlerimize rahat ve huzurlu bir konaklama deneyimi sunar."],
        ["title" => "İki Tek Yatak ve Rahat Dinlenme Alanı", "text" => "Odamızda bulunan iki tek yatak, konforlu bir konaklama için idealdir. Rahat yataklarımızda dinlenirken, misafirlerimiz huzurlu bir uyku deneyimi yaşar. Ayrıca, odanın geniş yaşam alanı, keyifli vakit geçirmek için ideal bir ortam sunar."],
        ["title" => "Veranda Bahçe Keyfi", "text" => "Superior Twin odamız, özel bir verandaya sahiptir. Bu veranda, misafirlerimize dışarıda oturma ve dinlenme imkânı sunar. Bahçenin huzurlu atmosferinde vakit geçirirken, doğanın güzelliklerini keşfetme fırsatını yakalayacak ve tatilinizin keyfini çıkaracaksınız."],
        ["title" => "Konfor ve Estetik Bir Arada", "text" => "Superior Twin odamız, estetik ve konforun mükemmel kombinasyonunu sunar. Modern iç mekanıyla göz alıcı bir atmosfer yaratırken, misafirlerimize rahat bir konaklama imkanı sağlar. LİLİUM Otel'in sunduğu olanaklarla birleşen bu özel oda, unutulmaz bir tatil deneyimi yaşamanızı sağlar."]
    ];
    $amenities = ["25 metre kare", "Kara manzaralı", "2 kişilik", "1 büyük (King Size) Boy Yatak", "Ücretsiz kablosuz internet", "Ücretsiz Kahvaltı", "Ücretsiz valesiz otopark", "Otomatik soğutma/ısıtma sistemi", "Ücretsiz banyo/kozmetik ürünleri", "Saç kurutma makinesi", "Özel banyo", "Dijital TV ve düz ekran televizyon", "Minibar ve Oda Servisi (Sınırlı)", "Günlük kat hizmetleri", "Emanet kasası", "Çarşaf takımı", "Ücretsiz beşik/çocuk yatağı", "Portatif/ilave yatak yoktur"];
    $slides = [htmlspecialchars($room['image_url']), "banyo.jpg"]; 

} elseif($room_type == 'Standart Twin') {
    $h1_title = "Standart Twin";
    $intro_subtitle = "LİLİUM ROOM";
    $intro_text = "Standart Twin odalarımız, modern tasarımı ve sakinleştirici atmosferiyle ön plana çıkar. Her biri 15 metrekarelik geniş bir yaşam alanına sahip olan bu odalar, iki ayrı yataklı düzenlemesiyle konuklarımıza huzurlu bir konaklama deneyimi sunar.";
    $sections = [
        ["title" => "Modern Tasarım ve Rahatlık", "text" => "Standart Twin odalarımız, modern bir tasarımla dikkat çeker. Her detayın özenle düşünüldüğü bu odalarda, konuklarımızın maksimum konforu düşünülmüştür."],
        ["title" => "Avlu Manzaralı Odalar", "text" => "Odalarımız, avlu manzarasına sahiptir. Doğanın güzellikleriyle çevrili olan bu manzara, misafirlerimize huzur dolu bir konaklama deneyimi sunar. Avlunun sakin ortamı, konuklarımızın şehrin gürültüsünden uzaklaşıp dinlenmelerine olanak tanır."],
        ["title" => "İki Tek Yatak ve Rahat Bir Dinlenme Alanı", "text" => "Her bir Standart Twin odasında iki ayrı tek yatak bulunur. Rahat yataklarımız, konuklarımıza huzurlu bir uyku deneyimi sunar. Ayrıca, odalarımızda bulunan yaşam alanı, dinlenmek ve vakit geçirmek için idealdir."]
    ];
    $amenities = ["Kara manzaralı", "15 metre kare", "2 kişilik", "2 ayrı tek yatak", "Ücretsiz kablosuz internet", "Ücretsiz Kahvaltı", "Ücretsiz valesiz otopark", "Otomatik soğutma/ısıtma sistemi", "Ücretsiz banyo/kozmetik ürünleri", "Saç kurutma makinesi", "Özel banyo", "Dijital TV ve düz ekran televizyon", "Minibar ve Oda Servisi (Sınırlı)", "Günlük kat hizmetleri", "Emanet kasası", "Çarşaf takımı", "Ücretsiz beşik/çocuk yatağı", "Portatif/ilave yatak yoktur"];
    $slides = [htmlspecialchars($room['image_url'])];
}
?>


<!DOCTYPE html>  
<html lang="tr"> 
<head>   
    <meta charset="UTF-8">  
    <title><?php echo $h1_title; ?> | LİLİUM Otel</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style> 
        * { margin: 0; padding: 0; box-sizing: border-box; } 
        
        body { font-family: 'Montserrat', sans-serif; background-color: #fff; color: #333; overflow-x: hidden; }
        
        header { position: absolute; top: 0; width: 100%; z-index: 1000; padding: 30px 5%; }
        .navbar { display: flex; justify-content: space-between; align-items: center; }
        .navbar .logo { font-family: 'Playfair Display', serif; font-size: 24px; color: #fff; text-decoration: none; letter-spacing: 5px; text-transform: uppercase; }
        .navbar .menu a { color: #fff; text-decoration: none; margin-left: 25px; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; font-weight: 500; }
        .btn-rez { background: #b38a65; padding: 12px 25px; color: white !important; font-weight: 600; }

        .room-slider { height: 100vh; width: 100%; position: relative; background: #000; overflow: hidden; }
        .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 0.8s ease-in-out; background-size: cover; background-position: center; z-index: 1; }
        .slide.active { opacity: 1; z-index: 2; }

        .slider-controls { position: absolute; bottom: 50px; width: 100%; padding: 0 5%; display: flex; justify-content: space-between; align-items: center; z-index: 100; }
    
        .nav-arrow { color: white; cursor: pointer; font-size: 20px; opacity: 0.8; }
        .counter { color: white; font-size: 14px; letter-spacing: 2px; font-weight: 300; }
        .main-container { max-width: 1100px; margin: 0 auto; padding: 80px 5%; display: grid; grid-template-columns: 2fr 1fr; gap: 60px; }
        .stars { color: #b38a65; font-size: 12px; margin-bottom: 10px; }
        .subtitle { font-size: 12px; letter-spacing: 3px; color: #999; text-transform: uppercase; margin-bottom: 15px; display: block; font-weight: 400; }
        .room-title { font-family: 'Playfair Display', serif; font-size: 40px; color: #1a1a1a; margin-bottom: 30px; font-weight: 400; letter-spacing: 0.5px; }
        .section-block { margin-bottom: 40px; } 
        .section-block h2 { font-family: 'Playfair Display', serif; font-size: 22px; color: #1a1a1a; margin-bottom: 15px; font-weight: 400; }
        .section-block p { font-size: 15px; color: #555; line-height: 1.7; font-weight: 300; }
        .sidebar h3 { font-family: 'Playfair Display', serif; font-size: 20px; margin-bottom: 25px; font-weight: 400; color: #1a1a1a; }
        .amenity-list { list-style: none; } 
        .amenity-list li { font-size: 14px; color: #555; margin-bottom: 12px; display: flex; align-items: center; font-weight: 300; }
        .amenity-list li::before { content: "\f00c"; font-family: "Font Awesome 6 Free"; font-weight: 900; font-size: 10px; color: #b38a65; margin-right: 10px; }

        .btn-reserve-final { display: inline-block; background: #b38a65; color: #fff; text-decoration: none; padding: 15px 35px; font-size: 12px; letter-spacing: 2px; text-transform: uppercase; font-weight: 600; margin-top: 30px; }
        @media (max-width: 991px) { .main-container { grid-template-columns: 1fr; } .room-title { font-size: 32px; } .room-slider { height: 60vh; } }
    </style>
</head>

<body>  

    <header>  
        <nav class="navbar"> 
            <a href="index.php" class="logo">LİLİUM</a> 
            <div class="menu"> 
                <a href="rooms.php">Odalar</a> 
                <a href="index.php#galeri">Galeri</a>
                <a href="reservations.php" class="btn-rez">Rezervasyon</a> 
            </div>
        </nav>
    </header>

    <section class="room-slider"> 
        <?php foreach ($slides as $index => $slide): ?> 
            <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>" style="background-image: url('<?php echo $slide; ?>');"></div> 
        <?php endforeach; ?> 
        <?php if(count($slides) > 1): ?> 
        <div class="slider-controls"> 
            <div class="nav-arrow" onclick="moveSlide(-1)"><i class="fas fa-chevron-left"></i></div>
            <div class="counter"><b id="curr-num">01</b> — 0<?php echo count($slides); ?></div>
            <div class="nav-arrow" onclick="moveSlide(1)"><i class="fas fa-chevron-right"></i></div>
        </div>
        <?php endif; ?>
    </section>

    <main class="main-container"> 
        <div class="room-details"> 
            <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
           
            <span class="subtitle"><?php echo $intro_subtitle; ?></span>
            <h1 class="room-title"><?php echo $h1_title; ?></h1>
            <div class="section-block"><p><?php echo $intro_text; ?></p></div>

            <?php foreach($sections as $sec): ?>  
            <div class="section-block">
                <h2><?php echo $sec['title']; ?></h2>
                <p><?php echo $sec['text']; ?></p> 
            </div>
            <?php endforeach; ?>

            <a href="reservations.php" class="btn-reserve-final">REZERVASYON YAP</a>
        </div>

        <aside class="sidebar">
            <h3>Oda Özellikleri</h3>
            <ul class="amenity-list">
                <?php foreach($amenities as $item): ?> 
                    <li><?php echo $item; ?></li>  
                <?php endforeach; ?>
            </ul>
        </aside>
    </main>

    <script>   

        let currentSlide = 0; 
        const slides = document.querySelectorAll('.slide');  
        const totalSlides = slides.length; 
        if(totalSlides > 1) { 
            function moveSlide(direction) { 
                slides[currentSlide].classList.remove('active'); 
                currentSlide = (currentSlide + direction + totalSlides) % totalSlides; 
                slides[currentSlide].classList.add('active'); 
                document.getElementById('curr-num').innerText = "0" + (currentSlide + 1); 
            }
        }
    </script>
</body>
</html>