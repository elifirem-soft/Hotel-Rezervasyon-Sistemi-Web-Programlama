<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $room_id = $_POST['room_id'] ?? null;
        $total_price = $_POST['total_price'] ?? 0;
        $name = $_POST['first_name'] ?? '';
        $surname = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $payment = $_POST['payment_method'] ?? 'Nakit';
        $gender = $_POST['gender'] ?? 'Kadın'; 
        $check_in = $_POST['check_in'] ?? null;
        $check_out = $_POST['check_out'] ?? null;
        $guests = $_POST['guests'] ?? 1;
        $room_count = $_POST['room_count'] ?? 1; // Yeni: Oda sayısı
        
        $nights = 1;
        if ($check_in && $check_out) {
            $d1 = new DateTime($check_in);
            $d2 = new DateTime($check_out);
            $nights = $d1->diff($d2)->days;
        }

        // INSERT sorgusu (Veritabanı tablosuna guests ve room_count sütunlarını eklediğinden emin ol!)
        $stmt = $pdo->prepare("INSERT INTO reservations 
            (room_id, total_price, guest_name, guest_surname, guest_email, guest_phone, payment_method, gender, check_in, check_out, guests, room_count, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        
        $stmt->execute([$room_id, $total_price, $name, $surname, $email, $phone, $payment, $gender, $check_in, $check_out, $guests, $room_count]);

        $stmt_room = $pdo->prepare("SELECT room_type FROM rooms WHERE room_id = ?");
        $stmt_room->execute([$room_id]);
        $room = $stmt_room->fetch(PDO::FETCH_ASSOC);
        $room_name = $room ? $room['room_type'] : "Standart Oda";

        $_SESSION['booking_data'] = [
            'name' => $name,
            'gender' => $gender,
            'room_name' => $room_name,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'nights' => $nights,
            'guests' => $guests,
            'room_count' => $room_count, // Session'a eklendi
            'payment_method' => $payment
        ];

        header("Location: reservation-success.php");
        exit;

    } catch (PDOException $e) {
        die("Hata: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit;
}
?>