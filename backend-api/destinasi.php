<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Tangani preflight request OPTIONS untuk CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'koneksi.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Ambil data (Semua atau Berdasarkan ID)
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare("SELECT * FROM destinasi_wisata WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($data) {
                echo json_encode(["status" => "success", "data" => $data]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => "error", "message" => "Data tidak ditemukan"]);
            }
        } else {
            $stmt = $pdo->query("SELECT * FROM destinasi_wisata ORDER BY id DESC");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(["status" => "success", "data" => $data]);
        }
        break;

    case 'POST':
        // Tambah Data Baru
        $input = json_decode(file_get_contents("php://input"), true);
        
        // Jika data dikirim via Form-Data biasa
        if (empty($input)) {
            $input = $_POST;
        }

        if (!empty($input['nama_tempat']) && !empty($input['kategori']) && !empty($input['lokasi'])) {
            $stmt = $pdo->prepare("INSERT INTO destinasi_wisata (nama_tempat, kategori, lokasi, deskripsi, harga_tiket, gambar_url) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $input['nama_tempat'],
                $input['kategori'],
                $input['lokasi'],
                $input['deskripsi'] ?? '',
                $input['harga_tiket'] ?? 0,
                $input['gambar_url'] ?? ''
            ]);
            
            http_response_code(201);
            echo json_encode(["status" => "success", "message" => "Destinasi berhasil ditambahkan"]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Data tidak lengkap (nama_tempat, kategori, lokasi wajib diisi)"]);
        }
        break;

    case 'PUT':
        // Update Data
        $input = json_decode(file_get_contents("php://input"), true);
        $id = $_GET['id'] ?? null;

        if ($id && !empty($input['nama_tempat'])) {
            $stmt = $pdo->prepare("UPDATE destinasi_wisata SET nama_tempat = ?, kategori = ?, lokasi = ?, deskripsi = ?, harga_tiket = ?, gambar_url = ? WHERE id = ?");
            $stmt->execute([
                $input['nama_tempat'],
                $input['kategori'],
                $input['lokasi'],
                $input['deskripsi'],
                $input['harga_tiket'],
                $input['gambar_url'],
                $id
            ]);

            echo json_encode(["status" => "success", "message" => "Destinasi berhasil diperbarui"]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "ID atau data yang diperbarui tidak valid"]);
        }
        break;

    case 'DELETE':
        // Hapus Data
        $id = $_GET['id'] ?? null;

        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM destinasi_wisata WHERE id = ?");
            $stmt->execute([$id]);

            echo json_encode(["status" => "success", "message" => "Destinasi berhasil dihapus"]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "ID tidak ditemukan"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["status" => "error", "message" => "Metode HTTP tidak didukung"]);
        break;
}
?>