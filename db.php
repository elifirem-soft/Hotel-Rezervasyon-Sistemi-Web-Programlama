<?php 

$host = 'localhost';           
$dbname = 'hotel_booking'; 
$username = 'root'; 
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {   
    die("Veritabanı bağlantısı başarısız: " . $e->getMessage()); 
}

// Yardımcı fonksiyonlar
function isLoggedIn() {
    return isset($_SESSION['user_id']);     
}

function redirect($url) {        
    header("Location: $url");  
    exit();   
}    
?>