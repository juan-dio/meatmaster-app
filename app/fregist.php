<?php
function isRegisteredAdmin($setValue, $PDO_USED) { // Apakah pengguna sudah registrasi?
    $stateResult = $PDO_USED->prepare("SELECT usernameKaryawan FROM karyawan WHERE usernameKaryawan = :bindVar1 ;");
    $stateResult->bindValue(":bindVar1", $setValue);
    $stateResult->execute();
    if ($stateResult->rowCount() >= 1) {
        $GLOBALS['failRegist'] = TRUE;
        return "Nama pengguna sudah didaftarkan. Silahkan ditambakan atau ganti nama pengguna yang belum didaftarkan.";
    } else { return; }
}
function isRegisteredCustomer($setValue, $PDO_USED) { // Apakah pengguna sudah registrasi?
    $stateResult = $PDO_USED->prepare("SELECT usernamePelanggan FROM customers WHERE usernamePelanggan = :bindVar1 ;");
    $stateResult->bindValue(":bindVar1", $setValue);
    $stateResult->execute();
    if ($stateResult->rowCount() >= 1) {
        $GLOBALS['failRegist'] = TRUE;
        return "Nama pengguna sudah didaftarkan. Silahkan ditambakan atau ganti nama pengguna yang belum didaftarkan.";
    } else { return; }
}

function isSetValue($methodSend,$inValue) { // $methodSend adalah POST, GET, maupun HEAD ; $inValue adalah key dari suatu $methodSend
    if (!isset($methodSend[$inValue]) || ($methodSend[$inValue] == "")) { // Apakah bidang ini kosong?
        $GLOBALS['failRegist'] = TRUE;
        return "Seharusnya wajib diisi";
    } else {
        return validatingValue($methodSend,$inValue);
    }
}
function validatingValue($methodSend, $inValue) { // Mengabsahan/validasi suatu isian
    switch($inValue) {
        case 'adminusr':
            if (!preg_match("/^[a-zA-Z0-9]+$/", $methodSend[$inValue])) {
                $GLOBALS['failRegist'] = TRUE;
                return "Nama pengguna hanya huruf dan/atau angka";
            } else {
                break;
            }
        case 'adminpwd':
            if (strlen($methodSend[$inValue]) < 8 || (strlen($methodSend[$inValue]) > 99)) {
                $GLOBALS['failRegist'] = TRUE;
                return "Kata sandi kurang dari 8 karakter.Atau terlalu banyak karakter akan bingung untuk Qiqi";
            } else if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-\.]).{8,}$/", $methodSend[$inValue])) {
                $GLOBALS['failRegist'] = TRUE;
                return "Kata sandi seminimal ada huruf kecil, besar, angka, dan simbol tertentu (Misal # ? ! @ $ % ^ & * - . ).";
            } else {
                break;
            }
        case 'customerEmail':
            if (!filter_var($methodSend[$inValue], FILTER_VALIDATE_EMAIL)) {
                $GLOBALS['failRegist'] = TRUE;
                return "Surel tidak absah/valid. Kadang @localhost tidak diizinkan.";
            } else {
                break;
            }
        case 'customerpwd':
            if (strlen($methodSend[$inValue]) < 8) {
                $GLOBALS['failRegist'] = TRUE;
                return "Kata sandi kuranag dari 8 karakter";
            } else if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-\.]).{8,}$/", $methodSend[$inValue])) {
                $GLOBALS['failRegist'] = TRUE;
                return "Kata sandi seminimal ada huruf kecil, besar, angka, dan simbol tertentu (Misal # ? ! @ $ % ^ & * - . ).";
            } else {
                break;
            }
        default:
            break;
    }; return;
}
function setSameDiffValue($Value1, $Value2) {
    if ($Value1 != $Value2) {
        return "Konfirmasi ulang tidak sama.";
    }
}
// Eksekusi dan pastikan aman
function isOKRegistAdmin($inFailRegist, $PDO_USED, $adminusr, $adminpwd, $admintitlecode) {
    if ($inFailRegist == TRUE) {
        return;
    } else {
        $stateExecute = $PDO_USED->prepare("INSERT INTO `karyawan` (`kodeJabatan`, `usernameKaryawan`, `passwordKaryawan`) VALUES (:admintitlecode, :adminusr, SHA2(:adminpwd , 256) );");
        $stateExecute->bindValue(":admintitlecode", $admintitlecode);
        $stateExecute->bindValue(":adminusr", $adminusr);
        $stateExecute->bindValue(":adminpwd", $adminpwd);
        $stateExecute->execute();
        header("Location: ".BASEURL."/app/login.php");
        return exit();
    }
}
function isOKRegistCustomer($inFailRegist, $PDO_USED, $customerEmail, $customerpwd, $customeraddr) {
    if ($inFailRegist == TRUE) {
        return;
    } else {
        $stateExecute = $PDO_USED->prepare("INSERT INTO `customers` (`alamatPelanggan`, `passwordPelanggan`, `usernamePelanggan`) VALUES(:bindVal1 , SHA2( :bindVal2 , 256) , :bindVal3);");
        $stateExecute->bindValue(":bindVal1", $customeraddr);
        $stateExecute->bindValue(":bindVal2", $customerpwd);
        $stateExecute->bindValue(":bindVal3", $customerEmail);
        $stateExecute->execute();
        header("Location: ".BASEURL."/app/login.php");
        return exit();
    }
}