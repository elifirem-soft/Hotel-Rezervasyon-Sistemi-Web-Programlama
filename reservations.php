<?php
session_start();
require 'db.php';

$check_in = $_GET['check_in'] ?? date('Y-m-d');
$check_out = $_GET['check_out'] ?? date('Y-m-d', strtotime('+1 day'));
$guests = $_GET['guests'] ?? 2;

$date1 = new DateTime($check_in);
$date2 = new DateTime($check_out);
$nights = $date1->diff($date2)->days;
if ($nights <= 0) $nights = 1;

try {
    $query = "SELECT * FROM rooms WHERE max_occupancy >= :guests";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['guests' => $guests]);
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Hata: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Rezervasyon | LİLİUM Otel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; color: #333; }
        .reservation-top-header { background: #fff; padding: 20px 50px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e0e0e0; }
        .branding-name { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; color: #333; text-decoration: none; letter-spacing: 1px; }
        .btn-go-home { border: 1px solid #b38a65; color: #b38a65; padding: 8px 20px; text-decoration: none; font-size: 13px; font-weight: 600; border-radius: 4px; transition: 0.3s; }
        .btn-go-home:hover { background: #b38a65; color: #fff; }
        .search-bar { background: #b38a65; padding: 20px; display: flex; justify-content: center; gap: 10px; align-items: center; }
        .search-input-group { background: white; padding: 10px 15px; border-radius: 4px; display: flex; align-items: center; min-width: 200px; }
        .search-input-group input, .search-input-group select { border: none; outline: none; font-family: 'Montserrat'; font-size: 14px; margin-left: 10px; width: 100%; }
        .btn-search { background: #8d6e53; color: white; border: none; padding: 12px 35px; border-radius: 4px; cursor: pointer; font-weight: 600; }
        .main-container { max-width: 1200px; margin: 30px auto; display: grid; grid-template-columns: 320px 1fr; gap: 20px; padding: 0 20px; }
        .summary-card { background: white; padding: 20px; border-radius: 4px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); height: fit-content; }
        .summary-card h3 { font-size: 16px; margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; text-transform: uppercase; }
        .summary-item { font-size: 13px; margin: 15px 0; line-height: 1.6; }
        .total-price { font-size: 20px; font-weight: 700; color: #000; }
        .room-card { background: white; border-radius: 4px; display: flex; margin-bottom: 20px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .room-image { width: 280px; height: 190px; object-fit: cover; }
        .room-details { padding: 20px; flex: 1; }
        .room-details h2 { font-size: 18px; margin: 0 0 10px 0; text-transform: uppercase; }
        .btn-select { background: #b38a65; color: white; border: none; padding: 10px 30px; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: 600; float: right; }
        .btn-continue { width: 100%; padding: 15px; border: none; margin-top: 15px; font-weight: 600; border-radius: 4px; background: #e0e0e0; color: #999; }
        .btn-continue.active { background: #b38a65; color: white; cursor: pointer; }
    </style>
</head>
<body>

<div class="reservation-top-header">
    <a href="index.php" class="branding-name">LİLİUM OTEL</a>
    <a href="index.php" class="btn-go-home">Ana Sayfaya Dön</a>
</div>

<form method="GET" action="reservations.php" class="search-bar">
    <div class="search-input-group">
        <i class="fa fa-calendar"></i>
        <input type="date" name="check_in" value="<?php echo $check_in; ?>">
        <input type="date" name="check_out" value="<?php echo $check_out; ?>">
    </div>
    <div class="search-input-group">
        <i class="fa fa-user"></i>
        <select name="guests">
            <option value="1" <?php echo ($guests == 1) ? 'selected' : ''; ?>>1 Oda, 1 Yetişkin</option>
            <option value="2" <?php echo ($guests == 2) ? 'selected' : ''; ?>>1 Oda, 2 Yetişkin</option>
            <option value="3" <?php echo ($guests == 3) ? 'selected' : ''; ?>>1 Oda, 3 Yetişkin</option>
            <option value="4" <?php echo ($guests == 4) ? 'selected' : ''; ?>>1 Oda, 4 Yetişkin</option>
        </select>
    </div>
    <button type="submit" class="btn-search">Ara</button>
</form>

<div class="main-container">
    <aside class="summary-card">
        <h3>REZERVASYONUNUZ</h3>
        <div class="summary-item">
            <strong>Giriş:</strong> <?php echo date('d M Y', strtotime($check_in)); ?><br>
            <strong>Çıkış:</strong> <?php echo date('d M Y', strtotime($check_out)); ?><br>
            <strong>Misafir:</strong> <?php echo $guests; ?> Yetişkin<br>
            <strong>Oda:</strong> 1 Oda<br>
            <span id="summary-nights"><?php echo $nights; ?> Gece</span>
        </div>
        <div id="selected-room-info" style="display: none; color: #b38a65; font-weight: 600; margin-bottom: 10px;">
            Seçilen Oda: <span id="display-room-name">-</span>
        </div>
        <div class="total-price" id="display-total">0,00 ₺</div>
        
        <form action="complete-reservation.php" method="POST">
            <input type="hidden" name="room_id" id="input-room-id">
            <input type="hidden" name="total_price" id="input-total-price">
            <input type="hidden" name="check_in" value="<?php echo htmlspecialchars($check_in); ?>">
            <input type="hidden" name="check_out" value="<?php echo htmlspecialchars($check_out); ?>">
            <input type="hidden" name="guests" value="<?php echo htmlspecialchars($guests); ?>">
            <input type="hidden" name="room_count" value="1">
            <button type="submit" id="btn-continue" class="btn-continue" disabled>DEVAM ET</button>
        </form>
    </aside>

    <main>
        <?php foreach ($rooms as $room): ?>
        <div class="room-card">
            <img src="<?php echo htmlspecialchars($room['image_url']); ?>" class="room-image">
            <div class="room-details">
                <h2><?php echo htmlspecialchars($room['room_type']); ?></h2>
                <button type="button" class="btn-select" 
                    onclick="selectRoom('<?php echo $room['room_id']; ?>', '<?php echo $room['room_type']; ?>', <?php echo $room['price_per_night'] * $nights; ?>)">
                    Seç
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </main>
</div>

<script>
function selectRoom(id, name, total) {
    document.getElementById('display-room-name').innerText = name;
    document.getElementById('display-total').innerText = total.toLocaleString('tr-TR') + ' ₺';
    document.getElementById('selected-room-info').style.display = 'block';
    document.getElementById('input-room-id').value = id;
    document.getElementById('input-total-price').value = total;
    const btn = document.getElementById('btn-continue');
    btn.classList.add('active');
    btn.disabled = false;
}
</script>
</body>
</html>