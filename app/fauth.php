<?php
function checkAdminTable($PDO_USED) { // Cek isian dari baris tabel karyawan
    $stateResult = $PDO_USED->prepare("SELECT * FROM karyawan;");
    $stateResult->execute();
    if ($stateResult->rowCount() <= 0) { // Jika tidak ada, maka inilah pertama kali ke halaman registrasi
        $stateResult = NULL;
        return header("Location: ".BASEURL."/app/admin/register.php");
    } else {
        return;
    }
}
function checkCustomerTable($PDO_USED) { // Cek isian dari baris tabel pelanggan
    $stateResult = $PDO_USED->prepare("SELECT * FROM customers;");
    $stateResult->execute();
    if ($stateResult->rowCount() <= 0) { // Jika tidak ada, maka inilah pertama kali ke halaman registrasi
        $stateResult = NULL;
        return header("Location: ".BASEURL."/app/customer/register.php");
    } else {
        return;
    }
}
function checkSignIn($checking) { // Fungsi untuk mengecek kondisi sudah masuk
    return isset($checking);
}
function adminAuth($PDO_USED, $adminusr, $adminpwd) { // Autentikasi untuk admin (manajer + karyawan)
    $stateExecuting = $PDO_USED->prepare("SELECT `karyawan`.`kodeJabatan` FROM `karyawan`, `jabatan`
    WHERE `karyawan`.`kodeJabatan` = `jabatan`.`kodeJabatan` AND `usernameKaryawan` = :bindVal1 AND `passwordKaryawan` = SHA2(:bindVal2, 256);");
    $stateExecuting->bindValue("bindVal1" , $adminusr);
    $stateExecuting->bindValue("bindVal2" , $adminpwd);
    $stateExecuting->execute();
    $userRoleID = $stateExecuting->fetchAll(PDO::FETCH_ORI_FIRST);
    $rowCount = $stateExecuting->rowCount();
    if ($rowCount >= 1) {
        // session_start();
        $_SESSION['adminSignIn'] = TRUE;
        $_SESSION['userRoleID'] = $userRoleID[0]['kodeJabatan'];
        $stateExecuting = NULL;
        return header ("Location: ".BASEURL."/app/admin/");
    } else {
        return "Autentikasi gagal. Apakah pengguna sudah terdaftar?";
    }
}
function authIn($PDO_USED, $customerEmail, $customerpwd, $remember) { // Autentikasi untuk pelanggan dengan menyertakan kode pelanggan agar dapat dipahami.
    $stateExecuting = $PDO_USED->prepare("SELECT `kodePelanggan` FROM `customers`
    WHERE `usernamePelanggan` = :bindVal1 AND `passwordPelanggan` = SHA2( :bindVal2 , 256) ");
    $stateExecuting->bindValue("bindVal1" , $customerEmail);
    $stateExecuting->bindValue("bindVal2" , $customerpwd);
    $stateExecuting->execute();
    $usrID = $stateExecuting->fetchAll(PDO::FETCH_ORI_FIRST);
    $rowCount = $stateExecuting->rowCount();
    if ($rowCount >= 1) {
        // session_start();
        $_SESSION['signedIn'] = TRUE;
        $_SESSION['userID'] = $usrID[0]['kodePelanggan'];
        $_SESSION['kodePelanggan'] = $usrID[0]['kodePelanggan'];
        if ($remember == 'on') {
            setcookie("userID", $usrID[0]['kodePelanggan'], time() + (60 * 60 * 24 * 30), "/"); // 60 dtk, 60 mnt, 24 jam, 30 hari
        }
        $stateExecuting = NULL;
        return header ("Location: ".BASEURL."/app/customer");
    } else {
        return "
        
        Autentikasi gagal. Akun ada tidak terdaftar
        ";
    }
}
function managerAuthRedirect($rolebased) { // Jika ditemukan sebagai manajer
    if ($rolebased == 2) {
        return header("Location: ".BASEURL."/app/manager");
    }
}
function matchingCustomerResetPWD($PDO_USED, $customerEmail, $newCustomerPWD, $confirmNewCustomerPWD) { // Reset kata sandi buat pelanggan atau konsumer
    $failResetCustomPWD = FALSE;
    $stateExecuting = $PDO_USED->prepare("SELECT `kodePelanggan` FROM `customers`
    WHERE `usernamePelanggan` = :bindVal1");
    $stateExecuting->bindValue("bindVal1" , $customerEmail);
    $stateExecuting->execute();
    $rowCount = $stateExecuting->rowCount();
    if ($rowCount != 1) { // Cek apakah surel ini cuma satu yang ketemu
        $failResetCustomPWD = TRUE;
        echo "Surel tidak ketemu. <i>HATI-HATI! BISA SAJA TIDAK AMAN JIKA CEROBOH DALAM URUSAN PRIVASI</i>";
    }
    if ($newCustomerPWD != $confirmNewCustomerPWD) { // Persaman kata sandi direset dengan konfirmasi kata sandi direset
        return "Gagal dalam konfirmasi ulang kata sandi tidak sama";
    } else if ($failResetCustomPWD == TRUE) {
        return;
    } else {
        return customerResetPWD($PDO_USED, $customerEmail, $newCustomerPWD); // Jika OK, jalankan eksekusi reset kata sandi
    }
}
function customerResetPWD($PDO_USED, $customerEmail, $newCustomerPWD) { // Sekarang eksekusi reset kata sandi
    $stateExecuting = $PDO_USED->prepare("UPDATE `customers` SET `passwordPelanggan` = SHA2(:bindVal2 , 256) WHERE `customerEmail` = :bindVal1");
    $stateExecuting->bindValue("bindVal2", $newCustomerPWD);
    $stateExecuting->bindValue("bindVal1", $customerEmail);
    $stateExecuting->execute();
    $stateExecuting = NULL;
    return header("Location: ".BASEURL."/app/customer/login.php"); // Balik ke halaman masuk

}
function matchingAdminResetPWD($PDO_USED, $adminusr, $newAdminPWD, $confirmNewAdminPWD) { // Reset kata sandi buat manajer dan admin + karyawan
    $failResetCustomPWD = FALSE;
    $stateExecuting = $PDO_USED->prepare("SELECT `kodeKaryawan` FROM `karyawan`
    WHERE `usernameKaryawan` = :bindVal1");
    $stateExecuting->bindValue("bindVal1" , $adminusr);
    $stateExecuting->execute();
    $rowCount = $stateExecuting->rowCount();
    if ($rowCount != 1) { // Cek apakah surel ini cuma satu yang ketemu
        $failResetCustomPWD = TRUE;
        echo "Nama pengguna tidak ketemu. <i>HATI-HATI! BISA SAJA TIDAK AMAN JIKA CEROBOH DALAM URUSAN PRIVASI</i>";
    }
    if ($newAdminPWD != $confirmNewAdminPWD) { // Persaman kata sandi direset dengan konfirmasi kata sandi direset
        return "Gagal dalam konfirmasi ulang kata sandi tidak sama";
    } else if ($failResetCustomPWD == TRUE) {
        return;
    } else {
        return adminResetPWD($PDO_USED, $adminusr, $newAdminPWD); // Jika OK, jalankan eksekusi reset kata sandi
    }
}
function adminResetPWD($PDO_USED, $adminusr, $newAdminPWD) { // Sekarang eksekusi reset kata sandi
    $stateExecuting = $PDO_USED->prepare("UPDATE `karyawan` SET `passwordKaryawan` = SHA2(:bindVal2 , 256) WHERE `usernameKaryawan` = :bindVal1");
    $stateExecuting->bindValue("bindVal2", $newAdminPWD);
    $stateExecuting->bindValue("bindVal1", $adminusr);
    $stateExecuting->execute();
    $stateExecuting = NULL;
    return header("Location: ".BASEURL."/app/admin/login.php"); // Balik ke halaman masuk

}
function rememberMe() { // Centang mengingat. HTML centang $_POST['remember'] = 'on' . HTML tidak centang tidak ada $_POST['remember']
    $remember = $_POST['remember'] ?? false;
    if ($remember != FALSE) {echo htmlspecialchars("checked"); return;}
    return;
}
function getUserData($PDO_USED, $userID) { // Ambil salah satu data pengguna pelanggan untuk diubah
    $stateExecute = $PDO_USED->prepare("SELECT `kodePelanggan`, `usernamePelanggan`, `alamatPelanggan` FROM `customers` WHERE `kodePelanggan` = :getUserID");
    $stateExecute->bindValue(":getUserID", $userID); // JANGAN MENAMPILKAN KATA SANDI DI KUERI INI
    $stateExecute->execute();
    $GLOBALS['UIDFetched'] = $stateExecute->fetch(PDO::FETCH_ASSOC);
    return $stateExecute = NULL;
}
function setted($METHOD, $arrayIn) { // apakah ini sudah diisi?
    if (!isset($METHOD[$arrayIn]) or $METHOD[$arrayIn] == "" or $METHOD[$arrayIn] == NULL) {
        $GLOBALS['failUpdate'] = TRUE;
        return "Harusnya diisi";
    }
    return validatingUpdate($METHOD, $arrayIn); // Sudah terisi, cek...
}
function validatingUpdate($METHOD, $arrayIn) { //... di sini
    switch($arrayIn) {
        case 'adminusr':
            if (!preg_match("/^[a-zA-Z0-9]+$/", $METHOD[$arrayIn])) {
                $GLOBALS['failUpdate'] = TRUE;
                return "Nama pengguna hanya huruf dan/atau angka";
            } else {
                break;
            }
        case 'adminpwd':
            if (strlen($METHOD[$arrayIn]) < 8 || (strlen($METHOD[$arrayIn]) > 99)) {
                $GLOBALS['failUpdate'] = TRUE;
                return "Kata sandi kurang dari 8 karakter. Atau terlalu banyak karakter akan bingung untuk Qiqi";
            } else if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-\.]).{8,}$/", $METHOD[$arrayIn])) {
                $GLOBALS['failUpdate'] = TRUE;
                return "Kata sandi seminimal ada huruf kecil, besar, angka, dan simbol tertentu (Misal # ? ! @ $ % ^ & * - . ).";
            } else {
                break;
            }
        case 'confirmAdminPwd':
            if ($METHOD[$arrayIn] != $_POST['adminpwd']) {
                $GLOBALS['failUpdate'] = TRUE;
                return "Konfirmasi kata sandi tidak sama";
            }
        case 'customerEmail':
            $surel = $GLOBALS['UIDFetched']['usernamePelanggan'] ?? FALSE;
            if ($METHOD[$arrayIn] == $surel && $surel != FALSE) {
                break;
            }
            if (!filter_var($METHOD[$arrayIn], FILTER_VALIDATE_EMAIL)) {
                $GLOBALS['failUpdate'] = TRUE;
                return "Surel tidak absah/valid. Kadang @localhost tidak diizinkan.";
            } else {
                break;
            }
        case 'customerpwdNEW':
            if (strlen($METHOD[$arrayIn]) < 8) {
                $GLOBALS['failUpdate'] = TRUE;
                return "Kata sandi kuranag dari 8 karakter";
            } else if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-\.]).{8,}$/", $METHOD[$arrayIn])) {
                $GLOBALS['failUpdate'] = TRUE;
                return "Kata sandi seminimal ada huruf kecil, besar, angka, dan simbol tertentu (Misal # ? ! @ $ % ^ & * - . ).";
            } else {
                break;
            }
        case 'customerpwdOLD':
            $PDO_USED = PDO_Connect;
            $getUserID = $_SESSION['userID'] ?? $_COOKIE['userID'] ?? FALSE;
            $stateExecute = $PDO_USED->prepare("SELECT `kodePelanggan` FROM `customers`
            WHERE `kodePelanggan` = :bindValue1 AND `passwordPelanggan` = SHA2( :bindValue2 , 256)");
            $stateExecute->bindValue(":bindValue1", $getUserID);
            $stateExecute->bindValue(":bindValue2", $METHOD[$arrayIn]);
            $stateExecute->execute();
            if ($stateExecute->rowCount() < 1) {
                $GLOBALS['failUpdate'] = TRUE;
                return "kata sandi salah";
            }
        default:
            break;
    }; return;
}
// Muktahirkan data pengguna pelanggan dan memastikan dalam keadaan sah/valid untuk syarat eksekusi...
function updateUserData($inFailUpdate, $PDO_USED, $userID, $customerEmail, $customerpwd, $customeraddr) {
    if ($inFailUpdate == TRUE) {
        return;
    } else { // ...muktahir data pengguna pelanggan
        $stateExecute = $PDO_USED->prepare("UPDATE `customers` SET `usernamePelanggan` = :bindVar4, `alamatPelanggan` = :bindVar1, `passwordPelanggan` = SHA2( :bindVar2 , 256) WHERE `kodePelanggan` = :bindVar3");
        $stateExecute->bindValue(":bindVar1", $customeraddr);
        $stateExecute->bindValue(":bindVar2", $customerpwd);
        $stateExecute->bindValue(":bindVar3", $userID);
        $stateExecute->bindValue(":bindVar4", $customerEmail);
        $stateExecute->execute();
        $stateExecute = NULL;
        return "Data pengguna sudah diperbarui. Pastikan mengingat kata sandi yang sudah diperbarukan.";
    }
}

// Untuk redirect yang tidak ada akun?
function checkSignedIn() { // untuk pelanggan
    $signedIn = $_SESSION['signedIn'] ?? false;
    $savedSignedIn = $_COOKIE['userID'] ?? false;
    if ($signedIn == FALSE) {
        if ($savedSignedIn != FALSE) {
            $_SESSION['userID'] = $_COOKIE['userID'];
            $_SESSION['kodePelanggan'] = $_COOKIE['userID'];
            $_SESSION['signedIn'] = TRUE;
        } else {
            header('Location: '.BASEURL.'/app/customer/login.php');
        }
    }
}
// Tentang admin --> karyawan dan manajer
function checkAdminSignedIn() { // untuk admin
    $userType = $_SESSION['userType'] ?? $_COOKIE['userType'] ?? false;
    if ($userType == 'customer') {
        header('Location: '.BASEURL.'/app/customer');
    } else if ($userType == FALSE) {
        header('Location: '.BASEURL.'/app/login.php');
    }
}
// Bukan pelanggan?
function whenIsNotCustomer() {
    $userType = $_SESSION['userType'] ?? $_COOKIE['userType'] ?? FALSE;
    if ($userType == 'admin' OR $userType == FALSE) {
        header('Location: '.BASEURL.'/app/login.php');
    }
}
// Semisal nih untuk manajer
function whenIsManager() {
    $userRoleID = $_SESSION['userRoleID'] ?? $_COOKIE['userRoleID'] ?? false;
    if ($userRoleID == "2") {
        header('Location: '.BASEURL.'/app/login.php');
    }
}
// Jika bukan untuk manajer
function whenIsNOTManager() {
    $userRoleID = $_SESSION['userRoleID'] ?? $_COOKIE['userRoleID'] ?? false;
    if ($userRoleID != "2") {
        header('Location: '.BASEURL.'/app/login.php');
    }
}

// Keluar dari akun ...
function signOut () {
    $signOut = $_GET['Chongyun_x_REA_ATUH'] ?? false;
    if ($signOut == 'Redirect_Sign_Out_Enabled') {
        unset($_SESSION['userID']);
        unset($_SESSION['userType']);
        unset($_SESSION['userRoleID']);
        setcookie("userID", "", time() - 9999, "/");
        setcookie("userType", "", time() - 9999, "/");
        setcookie("userRoleID", "", time() - 9999, "/");
        session_destroy();
        return header ('Location: '.BASEURL. '/app');
    };
}
// Gunakan yang cek sudah masuk akun di halaman login
function isSignedIn() {
    $userType = $_SESSION['userType'] ?? $_COOKIE['userType'] ?? FALSE; // Katakanlah tipe admin dan customer
    $userRoleID = $_SESSION['userRoleID'] ?? $_COOKIE['userRoleID'] ?? FALSE; // Untuk tipe admin
    if ($userType == 'admin') { // admin --> manajer (2) dan admin (1)
        if ($userRoleID == '2') {
            header('Location: manager/transaction-detail.php');
        } else if ($userRoleID == '1') {
            header('Location: admin/');
        }
    } else if ($userType == 'customer') { // customer
        header('Location: customer/');
    }
}
// Gunakan selain halaman login
function isNotSignedIn() {
    $userID = $_SESSION['userID'] ?? $_COOKIE['userID'] ?? FALSE;
    if ($userID == FALSE) {
        header('Location: '.BASEURL.'/app/login.php');
    }
}
// Autentikasi admin + customer
function loginAuth($PDO_USED, $username, $password) {
    $remember = $_POST['remember'] ?? FALSE; // Admin dulu --> admin + manajer
    $stateExecuting = $PDO_USED->prepare("SELECT `karyawan`.`kodeJabatan`, `kodeKaryawan` FROM `karyawan`, `jabatan`
    WHERE `karyawan`.`kodeJabatan` = `jabatan`.`kodeJabatan` AND `usernameKaryawan` = :bindVal1 AND `passwordKaryawan` = SHA2(:bindVal2, 256);");
    $stateExecuting->bindValue("bindVal1" , $username);
    $stateExecuting->bindValue("bindVal2" , $password);
    $stateExecuting->execute();
    $getUser = $stateExecuting->fetchAll(PDO::FETCH_ORI_FIRST);
    $rowCount = $stateExecuting->rowCount();
    if ($rowCount >= 1) {
        // session_start();
        $_SESSION['userID'] = $getUser[0]['kodeKaryawan'];
        $_SESSION['userType'] = 'admin';
        $_SESSION['userRoleID'] = $getUser[0]['kodeJabatan'];
        if ($remember == 'on') {
            setcookie("userID", $getUser[0]['kodeKaryawan'], time() + (60 * 60 * 24 * 30), "/"); // 60 dtk, 60 mnt, 24 jam, 30 hari
            setcookie("userType", 'admin', time() + (60 * 60 * 24 * 30), "/");
            setcookie("userRoleID", $getUser[0]['kodeJabatan'], time() + (60 * 60 * 24 * 30), "/");
        }
        $stateExecuting = NULL;
        return header ("Location: ".$_SERVER['PHP_SELF']);
    } else { // Baru di sini kalau nggak ketemu di sini sebagai pelanggan
        $stateExecuting = $PDO_USED->prepare("SELECT `kodePelanggan` FROM `customers`
        WHERE `usernamePelanggan` = :bindVal1 AND `passwordPelanggan` = SHA2( :bindVal2 , 256) ");
        $stateExecuting->bindValue("bindVal1" , $username);
        $stateExecuting->bindValue("bindVal2" , $password);
        $stateExecuting->execute();
        $getUser = $stateExecuting->fetchAll(PDO::FETCH_ORI_FIRST);
        $rowCount = $stateExecuting->rowCount();
        if ($rowCount >= 1) {
            // session_start();
            $_SESSION['userID'] = $getUser[0]['kodePelanggan'];
            $_SESSION['userType'] = 'customer';
            $_SESSION['userRoleID'] = 0;
            if ($remember == 'on') {
                setcookie("userID", $getUser[0]['kodePelanggan'], time() + (60 * 60 * 24 * 30), "/"); // 60 dtk, 60 mnt, 24 jam, 30 hari
                setcookie("userType", 'customer', time() + (60 * 60 * 24 * 30), "/");
                setcookie("userRoleID", 0, time() + (60 * 60 * 24 * 30), "/");
            }
            $stateExecuting = NULL;
            return header ("Location: ".$_SERVER['PHP_SELF']);
        } else {
            return "
            
            Autentikasi gagal. Coba ingat-ingat atau biasanya kan di simpan di pengelola masuk.
            "; // Autentikasi gagal karena input.
        }
    }
}
?>