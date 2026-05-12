<?php 
session_start(); 
require 'db.php'; 

$room_id = $_POST['room_id'] ?? null;
$check_in = $_POST['check_in'] ?? null;
$check_out = $_POST['check_out'] ?? null;
$guests = $_POST['guests'] ?? 1;
$room_count = $_POST['room_count'] ?? 1;
$total_price = $_POST['total_price'] ?? 0;

$nights = 1;
if ($check_in && $check_out) {
    $d1 = new DateTime($check_in);
    $d2 = new DateTime($check_out);
    $nights = $d1->diff($d2)->days;
    if ($nights < 1) $nights = 1;
}

$room_name = "Seçilmedi";
if ($room_id) {
    $stmt = $pdo->prepare("SELECT room_type FROM rooms WHERE room_id = ?");
    $stmt->execute([$room_id]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($room) { $room_name = $room['room_type']; }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Rezervasyonu Tamamla | LİLİUM Otel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Prata&display=swap" rel="stylesheet">
    
    <style>
        body { background-color: #f9f7f2; font-family: 'Montserrat', sans-serif; color: #333; }
        .page-header { background: #fff; padding: 30px 60px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f0f0f0; margin-bottom: 40px; }
        .logo { font-family: 'Prata', serif; font-size: 26px; letter-spacing: 4px; text-transform: uppercase; color: #333; text-decoration:none; }
        .summary-card { background: white; padding: 30px; border-radius: 4px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .form-card { background: white; padding: 40px; border-radius: 4px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        h4 { font-family: 'Playfair Display', serif; font-weight: 400; margin-bottom: 25px; }
        label { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 8px; display: block; }
        .btn-submit { background-color: #b38a65; border: none; padding: 15px; font-weight: 600; color: white; width: 100%; transition: 0.3s; letter-spacing: 2px; text-transform: uppercase; }
        .btn-submit:hover { background-color: #967354; }
        .btn-submit:disabled { background-color: #d1b8a1; cursor: not-allowed; }
        .payment-info-box { background: #fff8f5; border-left: 4px solid #b38a65; padding: 20px; margin-top: 15px; display: none; }
        .card-panel { background: #fdfdfd; border: 1px solid #eee; padding: 20px; margin-top: 15px; display: none; }
        .iti { width: 100%; }
        .back-link { color: #b38a65; font-size: 13px; text-decoration: none; margin-bottom: 15px; display: inline-block; font-weight: 500; }
        .secure-badge { font-size: 11px; color: #999; text-align: center; margin-top: 15px; }
    </style>
</head>
<body>

<div class="page-header">
    <a href="index.php" class="logo">LİLİUM</a>
    <a href="index.php" style="text-decoration:none; color:#333; font-size:12px; letter-spacing:1px; text-transform:uppercase;">Ana sayfa</a>
</div>

<div class="container mb-5">
    <div class="row">
        <div class="col-md-4">
            <a href="reservations.php?check_in=<?php echo urlencode($check_in); ?>&check_out=<?php echo urlencode($check_out); ?>" class="back-link">
                <i class="fas fa-chevron-left"></i> Odalara geri dön
            </a>
            <div class="summary-card">
                <h5 style="font-family:'Playfair Display', serif;">Rezervasyonunuz</h5><hr>
                <p class="mb-2"><strong>Oda:</strong> <?php echo htmlspecialchars($room_name); ?></p>
                <p class="mb-2"><strong>Oda Sayısı:</strong> <?php echo htmlspecialchars($room_count); ?></p>
                <p class="mb-2"><strong>Giriş:</strong> <?php echo htmlspecialchars($check_in); ?></p>
                <p class="mb-2"><strong>Çıkış:</strong> <?php echo htmlspecialchars($check_out); ?></p>
                <p class="mb-2"><strong>Misafir:</strong> <?php echo htmlspecialchars($guests); ?> Yetişkin</p>
                <p class="mb-2"><strong>Konaklama:</strong> <?php echo $nights; ?> Gece</p>
                <hr>
                <h5 style="color:#b38a65 !important;">Toplam: <?php echo htmlspecialchars($total_price); ?> ₺</h5>
            </div>
        </div>

        <div class="col-md-8">
            <div class="form-card">
                <h4>İletişim ve Ödeme</h4>
                <form action="save-reservation.php" method="POST" id="reservationForm">
                    <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room_id); ?>">
                    <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($total_price); ?>">
                    <input type="hidden" name="check_in" value="<?php echo htmlspecialchars($check_in); ?>">
                    <input type="hidden" name="check_out" value="<?php echo htmlspecialchars($check_out); ?>">
                    <input type="hidden" name="guests" value="<?php echo htmlspecialchars($guests); ?>">
                    <input type="hidden" name="room_count" value="<?php echo htmlspecialchars($room_count); ?>">

                    <div class="row">
                        <div class="col-md-4 mb-3"><label>Ad</label><input type="text" name="first_name" class="form-control" required></div>
                        <div class="col-md-4 mb-3"><label>Soyad</label><input type="text" name="last_name" class="form-control" required></div>
                        <div class="col-md-4 mb-3">
                            <label>Cinsiyet</label>
                            <select name="gender" class="form-select" required>
                                <option value="Kadın">Kadın ♀</option>
                                <option value="Erkek">Erkek ♂</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3"><label>E-posta</label><input type="email" name="email" class="form-control" required></div>
                    <div class="mb-3"><label>Telefon</label><input type="tel" id="phone" name="phone" class="form-control" required></div>

                    <div class="mb-3">
                        <label>Ödeme Yöntemi</label>
                        <select name="payment_method" id="payment_method" class="form-select" onchange="showPaymentDetails()" required>
                            <option value="">Lütfen seçiniz...</option>
                            <option value="Nakit">Nakit</option>
                            <option value="Havale">Havale / EFT</option>
                            <option value="Kredi Kartı">Kredi Kartı</option>
                        </select>
                    </div>

                    <div id="cash-info" class="payment-info-box">
                        <i class="fas fa-info-circle" style="color:#b38a65;"></i> <strong>Nakit Ödeme:</strong> Rezervasyonunuz tamamlanmıştır. Ödemenizi otele giriş esnasında resepsiyondan yapabilirsiniz.
                    </div>
                    
                    <div id="transfer-info" class="payment-info-box">
                        <i class="fas fa-university" style="color:#b38a65;"></i> <strong>Banka Havalesi / EFT:</strong>
                        <ul class="mt-2 mb-0" style="list-style:none; padding-left:0; font-size:13px;">
                            <li class="mb-2"><strong>Garanti BBVA:</strong> TR00 0000 0000 0000 0000 0000 00 | LİLİUM Turizm A.Ş.</li>
                            <li><strong>İş Bankası:</strong> TR00 0000 0000 0000 0000 0000 01 | LİLİUM Turizm A.Ş.</li>
                        </ul>
                    </div>
                    
                    <div id="credit-card-panel" class="card-panel">
                        <h6 style="font-family:'Playfair Display', serif;">Kredi Kartı Bilgileri</h6>
                        <div class="mb-3"><label>Kart Üzerindeki İsim</label><input type="text" class="form-control" placeholder="AD SOYAD"></div>
                        <div class="mb-3"><label>Kart Numarası</label><input type="text" id="card-number" class="form-control" placeholder="0000 0000 0000 0000"></div>
                        <div class="row">
                            <div class="col-6 mb-3"><label>Son Kullanma</label><input type="text" id="card-expiry" class="form-control" placeholder="AA/YY"></div>
                            <div class="col-6 mb-3"><label>CVV</label><input type="text" id="card-cvv" class="form-control" placeholder="123"></div>
                        </div>
                    </div>

                    <div class="form-check mb-3 mt-3">
                        <input class="form-check-input" type="checkbox" id="kvkk" required>
                        <label class="form-check-label" for="kvkk" style="font-size:12px; color:#666;">KVKK aydınlatma metnini ve satış sözleşmesini okudum, onaylıyorum.</label>
                    </div>

                    <button type="submit" class="btn btn-submit" id="submitBtn">Rezervasyonu Tamamla</button>
                    <div class="secure-badge"><i class="fas fa-lock"></i> 256-bit SSL ile %100 Güvenli Ödeme</div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
<script>
    window.intlTelInput(document.querySelector("#phone"), { initialCountry: "tr" });
    $('#card-number').inputmask("9999 9999 9999 9999");
    $('#card-expiry').inputmask("99/99");
    $('#card-cvv').inputmask("999");

    document.getElementById('reservationForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> İşleniyor...';
    });

    function showPaymentDetails() {
        var method = document.getElementById("payment_method").value;
        document.getElementById("cash-info").style.display = (method === "Nakit") ? "block" : "none";
        document.getElementById("transfer-info").style.display = (method === "Havale") ? "block" : "none";
        document.getElementById("credit-card-panel").style.display = (method === "Kredi Kartı") ? "block" : "none";
    }
</script>
</body>
</html>