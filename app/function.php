<?php
/* koneksi database */
function connect($servername, $database, $username, $password)
{
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    return $conn;
}
$conn = connect("localhost", "store", "root", "");

/* AMBIL DATA */
function selectData($query)
{
    global $conn;
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

/* TAMBAH PRODUK */
function tambahProduk($value)
{
    global $conn;
    $gambar = upload();
    $suplai = htmlspecialchars($value["suplai"]);
    $kategori = htmlspecialchars($value["kategori"]);
    $nama = htmlspecialchars($value["namaProduk"]);
    $harga = htmlspecialchars($value["harga"]);
    $stok = htmlspecialchars($value["stok"]);
    $deskripsi = htmlspecialchars($value["deskripsi"]);
    $stmt = $conn->prepare("INSERT INTO products(kodeSuplaier,KodeKategori,namaProduk, gambarProduk, hargaProduk, stokProduk, deskripsiProduk)
                        VALUES (:kodeSuplaier,:KodeKategori,:namaProduk, :gambarProduk, :hargaProduk, :stokProduk, :deskripsiProduk)");
    $stmt->bindvalue(":kodeSuplaier", $suplai);
    $stmt->bindvalue(":KodeKategori", $kategori);
    $stmt->bindvalue(":namaProduk", $nama);
    $stmt->bindvalue(":gambarProduk", $gambar);
    $stmt->bindvalue(":hargaProduk", $harga);
    $stmt->bindvalue(":stokProduk", $stok);
    $stmt->bindvalue(":deskripsiProduk", $deskripsi);
    $stmt->execute();
}

/* HAPUS PRODUK */
function hapusProduk($id)
{
    global $conn;
    $data = selectData("SELECT gambarProduk FROM products WHERE kodeProduk=$id");
    $stmt = $conn->prepare("DELETE FROM products WHERE  kodeProduk =:kodeProduk");
    $stmt->bindvalue(":kodeProduk", $id);
    $stmt->execute();
    if(file_exists("../../assets/img/product/{$data[0]["gambarProduk"]}")){
        unlink('../../assets/img/product/' . $data[0]["gambarProduk"]);
    }
    return $stmt->rowCount();
}

/* UPLOAD GAMBAR */
function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= "$ekstensiGambar";

    move_uploaded_file($tmpName, '../../assets/img/product/' . $namaFileBaru);
    return $namaFileBaru;
};

/* EDIT PRODUK */
function editProduk($data)
{
    global $conn;
    $id = $data["id"];
    $kategori = $data["kategori"];
    $suplai = $data["suplai"];
    $nama = htmlspecialchars($data["namaProduk"]);
    $harga = htmlspecialchars($data["harga"]);
    $stok = htmlspecialchars($data["stok"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $gambarLama = $data["gambarLama"];

    if ($_FILES["gambar"]["error"] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
        $oldGambar = selectData("SELECT gambarProduk FROM products WHERE kodeProduk=$id");
        if(file_exists('../../assets/img/product/' . $oldGambar[0]["gambarProduk"])){
            unlink('../../assets/img/product/' . $oldGambar[0]["gambarProduk"]);
        }        
    };
    $query = "UPDATE products 
    SET kodeKategori=:kategori, kodeSuplaier=:suplaier, namaProduk=:nama, gambarProduk=:gambar, hargaProduk=:harga, stokProduk=:stok, deskripsiProduk=:deskripsi
    WHERE kodeProduk=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->bindValue(":kategori", $kategori);
    $stmt->bindValue(":suplaier", $suplai);
    $stmt->bindValue(":nama", $nama);
    $stmt->bindValue(":gambar", $gambar);
    $stmt->bindValue(":harga", $harga);
    $stmt->bindValue(":stok", $stok);
    $stmt->bindValue(":deskripsi", $deskripsi);
    $stmt->execute();
    return $stmt->rowCount();
};


/* TAMBAH SUPLAIER */
function tambahSuplaier($data)
{
    global $conn;
    $nama = htmlspecialchars($data["nama"]);
    $no = htmlspecialchars($data["no"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $stmt = $conn->prepare("INSERT INTO suplaier(namaSuplaier, telpSuplaier, alamatSuplaier)
                        VALUES (:namaSuplaier,:telp,:alamat)");
    $stmt->bindvalue(":namaSuplaier", $nama);
    $stmt->bindvalue(":telp", $no);
    $stmt->bindvalue(":alamat", $alamat);
    $stmt->execute();
    return $stmt->rowCount();
}

/* HAPUS SUPLAIER */
function hapusSuplaier($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM suplaier WHERE  kodeSuplaier =:kode");
    $stmt->bindvalue(":kode", $id);
    $stmt->execute();
    return $stmt->rowCount();
}

/* EDIT SUPLAIER */
function editSuplaier($data)
{
    global $conn;
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nomor = htmlspecialchars($data["nomor"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $query = "UPDATE suplaier 
    SET namaSuplaier=:nama, telpSuplaier=:nomor,alamatSuplaier=:alamat
    WHERE kodeSuplaier=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->bindvalue(":nama", $nama);
    $stmt->bindvalue(":nomor", $nomor);
    $stmt->bindvalue(":alamat", $alamat);
    $stmt->execute();
    return $stmt->rowCount();
}

/*  MEMBUAT ORDER */
function makeOrder($data)
{
    global $conn;
    $query = "SELECT * FROM orders WHERE kodePelanggan={$data['userID']} AND keterangan='belum'";
    $hasil = selectData($query);
    if ($hasil == []) {
        $stmt = $conn->prepare("INSERT INTO orders(kodePelanggan, keterangan)
                                VALUES (:kode,:ket)");
        $stmt->bindvalue(":kode", $data["userID"]);
        $stmt->bindValue(":ket", "belum");
        $stmt->execute();
        return $stmt->rowCount();
    }
}

/* ADD ORDER */
function addOrderDetail($data)
{
    global $conn;
    $query = "INSERT INTO orderdetail(kodeProduk, kodePesanan, subHarga, qty)
            VALUES (:kodeProduk,:kodePesanan,:subHarga,:qty)";
    $stmt = $conn->prepare($query);
    $stmt->bindvalue(":kodeProduk", $data["kodeProduk"]);
    $stmt->bindvalue(":kodePesanan", $data["kodePesanan"]);
    $stmt->bindvalue(":subHarga", $data["subHarga"]);
    $stmt->bindvalue(":qty", $data["jumlah"]);
    $stmt->execute();

    $stokLama = selectData("SELECT stokProduk FROM products WHERE kodeProduk={$data['kodeProduk']}");
    $hasil = $stokLama[0]["stokProduk"] - $data["jumlah"];
    $stokUpdate = $conn->prepare("UPDATE products SET stokProduk=:stokBaru WHERE kodeProduk=:kodeProduk");
    $stokUpdate->bindvalue(":stokBaru", $hasil);
    $stokUpdate->bindvalue(":kodeProduk", $data["kodeProduk"]);
    $stokUpdate->execute();

    return $stmt->rowCount();
}

/* HAPUS ORDER */
function hapusOrderDetil($idProduk, $idPesanan)
{
    global $conn;
    $jumlahOrder = selectData("SELECT qty FROM orderdetail WHERE kodeProduk={$idProduk} AND kodePesanan={$idPesanan}");
    $jumlahData = selectData("SELECT stokProduk FROM products WHERE kodeProduk={$idProduk}");
    $hasil = $jumlahOrder[0]["qty"] + $jumlahData[0]["stokProduk"];
    $stmt = $conn->prepare("DELETE FROM orderdetail WHERE kodeProduk=:idProduk AND kodePesanan=:idPesan");
    $stmt->bindvalue(":idProduk", $idProduk);
    $stmt->bindvalue(":idPesan", $idPesanan);
    $stmt->execute();

    $addStok =  $conn->prepare("UPDATE products SET stokProduk=:returnStok WHERE kodeProduk=:kodeProduk");
    $addStok->bindvalue(":returnStok", $hasil);
    $addStok->bindvalue(":kodeProduk", $idProduk);
    $addStok->execute();
    return $stmt->rowCount();
}

// ADD PEMBAYARAN
function addPembayaran($kodePesanan, $metode)
{
    global $conn;
    $stmt = $conn->prepare(
        "INSERT INTO pembayaran (kodePesanan, total, metode)
        VALUES (:kodePesanan, (SELECT SUM(subHarga) FROM orderdetail 
        WHERE kodePesanan = :kodePesanan), :metode)"
    );
    $stmt->bindValue(":kodePesanan", $kodePesanan);
    $stmt->bindValue(":metode", $metode);
    $stmt->execute();

    $updateOrder = $conn->prepare(
        "UPDATE orders
        SET keterangan = 'sudah'
        WHERE kodePesanan = :kodePesanan"
    );
    $updateOrder->bindValue(":kodePesanan", $kodePesanan);
    $updateOrder->execute();

    return $stmt->rowCount();
}

// ADD WALLET
function addWallet($kodePelanggan) {
    global $conn;
    $stmt = $conn->prepare(
        "INSERT INTO wallet (kodePelanggan, namaWallet)
        VALUES (:kodePelanggan, 'DANA'), (:kodePelanggan, 'GOPAY'), (:kodePelanggan, 'OVO')"
    );
    $stmt->bindValue(":kodePelanggan", $kodePelanggan);
    $stmt->execute();
}

// EDIT WALLET
function editWallet($kodePelanggan, $nomorDana, $nomorGopay, $nomorOvo) {
    global $conn;

    if($nomorDana) {
        $stmt = $conn->prepare(
            "UPDATE wallet 
            SET nomorWallet = '$nomorDana'
            WHERE namaWallet = 'DANA' AND kodePelanggan = '$kodePelanggan'"
        );
        $stmt->execute();
    }

    if($nomorGopay) {
        $stmt = $conn->prepare(
            "UPDATE wallet 
            SET nomorWallet = '$nomorGopay'
            WHERE namaWallet = 'GOPAY' AND kodePelanggan = '$kodePelanggan'"
        );
        $stmt->execute();
    }

    if($nomorOvo) {
        $stmt = $conn->prepare(
            "UPDATE wallet 
            SET nomorWallet = '$nomorOvo'
            WHERE namaWallet = 'OVO' AND kodePelanggan = '$kodePelanggan'"
        );
        $stmt->execute();
    }

    // header('Refresh:1');
}


// Mengabsahan / validasi suatu data
function terisikan($metodeKirim, $dalamIsian) { // Apakah sudah terisi?
	if (!isset($metodeKirim[$dalamIsian]) || $metodeKirim[$dalamIsian] == '') {
        $GLOBALS['gagal'] = TRUE;
		return "Harusnya diisi"; // Kembali jika tidak terisi
	} else {
		return validasiSesuatu_1($metodeKirim, $dalamIsian); // Lanjut ke...
	}
}
function validasiSesuatu_1($metodeKirim, $dalamIsian) { // ... fungsi validasi validasiSesuatu_1
	switch ($dalamIsian) {
		case 'nama':
			if (preg_match("/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i", $metodeKirim[$dalamIsian])) {
                $GLOBALS['gagal'] = TRUE;
                return "Kesalahan dalam nama supplier/pemasok";
            } break;
		case 'namaProduk':
			if (preg_match("/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i", $metodeKirim[$dalamIsian])) {
                $GLOBALS['gagal'] = TRUE;
                return "Kesalahan dalam nama produk";
            } break;
		case 'no':
            if (!preg_match("/^[0-9]{10,15}$/", $metodeKirim[$dalamIsian])) {
                $GLOBALS['gagal'] = TRUE;
                return "Biasanya nomor telepon hanya lokal (Indonesia) 10-15 karakter";
            } break;
        case 'harga':
			if (!preg_match("/^[0-9]$/", $metodeKirim[$dalamIsian])) {
                $GLOBALS['gagal'] = TRUE;
                return "Hanya diisi angka. Jadi sudah termasuk \"IDR\"";
            } break;
        case 'stok':
			if (!preg_match("/^[0-9]$/", $metodeKirim[$dalamIsian])) {
                $GLOBALS['gagal'] = TRUE;
                return "Stok yang diisikan hanyalah angka";
            } break;
        case 'deskripsi':
			if (!preg_match("/^[\w\-\d\.\!\%\&]$/", $metodeKirim[$dalamIsian])) {
                $GLOBALS['gagal'] = TRUE;
                return "Biasanya deskripsi yang singkat dan teks latin";
            } break;
		default:
			break;
	}
}

/* VALIDASI */

// Inputan tidak boleh kosong produk & supplier
function validAll(&$errors, $arr){
    $ket="Wajib diisi !!!";
    foreach($arr as $key => $val){
        if($val==""){
            $errors[$key] = $ket;
        }
    }
}

// validasi alfa numerik produk & supplier
function validAlfa(&$errors, $arr, $val){
    $pattern = "/^(?=.*[a-zA-Z])[a-zA-Z ]+$/";
    if (!preg_match($pattern, $arr[$val]) && $arr[$val]!=""){
        $errors[$val] = "Inputan harus huruf (Alfabet) !!!";
    }
}

// validasi numerik produk & supplier
function validNum(&$errors, $arr, $val){
    $pattern = "/^[0-9]+$/";
    if (!preg_match($pattern, $arr[$val]) && $arr[$val]!=""){
        $errors[$val] = "Inputan harus angka (jangan ada spasi dan '.') !!!";
    }
}

// validasi Alfa numerik produk & supplier
function validAlfaNum(&$errors, $arr, $val){
    $pattern = "/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z \d]+$/";
    if (!preg_match($pattern, $arr[$val]) && $arr[$val]!=""){
        $errors[$val] = "Inputan harus huruf dan angka saja (tanpa simbol)!!!";
    }
}

// validasi numerik length for no supplier
function validNumLen(&$errors, $arr, $val){
    $pattern = "/^[0-9]{10,13}+$/";
    if (!preg_match($pattern, $arr[$val]) && $arr[$val]!=""){
        $errors[$val] = "Inputan harus angka (awalan 0 bukan +62) (tanpa '-' dan 'spasi') (berjumlah  10-13 digit) !!!";
    }
}
function validWallet(&$errors, $arr, $val){
    $pattern = "/^[0-9]{10,13}+$/";
    if (!preg_match($pattern, $arr[$val]) && $arr[$val]!=""){
        $errors[$val] = "Inputan harus angka (berjumlah  10-13 digit) !!!";
    }
}

// mengecek error
function cekError($errors,$val){
    if(isset($errors[$val])){
        echo $errors[$val];
    }
}