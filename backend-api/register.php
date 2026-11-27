<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'koneksi.php';

$input = json_decode(file_get_contents("php://input"), true);
if (empty($input)) {
    $input = $_POST;
}

$nama = $input['nama'] ?? '';
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

if (!empty($nama) && !empty($email) && !empty($password)) {
   
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Email sudah terdaftar! Gunakan email lain."]);
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$nama, $email, $hashedPassword])) {
        http_response_code(201);
        echo json_encode(["status" => "success", "message" => "Registrasi berhasil! Silakan login."]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Gagal mendaftarkan akun."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Semua kolom wajib diisi!"]);
}
?>