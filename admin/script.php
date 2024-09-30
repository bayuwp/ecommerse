<?php
$conn = mysqli_connect("127.0.0.1", "root", "", "e_commerce");

function query($query){
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }

    return $rows;
}

function tambah($post) {
    global $conn;

    $nama = htmlspecialchars($post["namaGambar"]);
    $keterangan = htmlspecialchars($post["keterangan"]);

    $path = upload($_FILES['gambar']);

    if (!$path) {
        return false;
    }

    $queryTambah = "INSERT INTO gambar (nama_gambar, keterangan, path)
                VALUES ('$nama', '$keterangan', '$path')";

    mysqli_query($conn, $queryTambah);

    header('Location: ../galleries/index.php');
    exit;

    return mysqli_affected_rows($conn);
}

function upload($files){
    $namaGambar = $files["name"];
    $tmpName = $files["tmp_name"];
    $error = $files["error"];
    $size = $files["size"];

    $ekstensi = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', strtolower($namaGambar));
    $ekstensiGambar = end($ekstensiGambar);
    
    if (!in_array($ekstensiGambar, $ekstensi)){

        return false;
    }

    $namaGambarBaru = uniqid();
    $namaGambarBaru .= '.' . $ekstensiGambar;

    $uploadDir = realpath('../../upload');
    move_uploaded_file($tmpName, $uploadDir . "/" . $namaGambarBaru);
    // move_uploaded_file($tmpName, "../upload/" . $namaGambarBaru);

    if ($error !== UPLOAD_ERR_OK) {
        echo 'File upload error: ' . $error;
        return false;
    }

    echo $uploadDir; // This will print the resolved path
    
    return $namaGambarBaru;

}
?>