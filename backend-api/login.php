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

$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

// Akun default hardcode untuk testing cepat (Role: admin)
if ($email === "admin" && $password === "password123") {
    echo json_encode([
        "status" => "success", 
        "message" => "Login Berhasil (Admin)",
        "user" => [
            "nama" => "Administrator", 
            "email" => "admin",
            "role" => "admin"
        ]
    ]);
    exit();
}

if (!empty($email) && !empty($password)) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode([
            "status" => "success", 
            "message" => "Login Berhasil",
            "user" => [
                "nama" => $user['nama'], 
                "email" => $user['email'],
                "role" => $user['role'] // Mengirim role dari database ('admin' atau 'user')
            ]
        ]);
    } else {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Email atau Password salah!"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Email dan Password wajib diisi!"]);
}
?>