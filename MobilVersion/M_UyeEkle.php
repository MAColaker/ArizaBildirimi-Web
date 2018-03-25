<?php

include 'Baglan.php';

if($_POST){

    $baglanti=(new Baglan())->basla();
    $baglanti->select_db("Admin");

    $sifre=$_POST['password'];
    $kullaniciAdi=$_POST['username'];
    $isim=$_POST['name'];
    $soyisim=$_POST['lastname'];
    $email=$_POST['email'];
    $meslek=$_POST['meslek'];
    $telefon=$_POST['tel'];


    $sifre=md5($sifre);

    $result=$baglanti->query("SELECT kullaniciAdi,email FROM Uyeler WHERE kullaniciAdi='$kullaniciAdi' OR email='$email'");
    $value =  mysqli_fetch_object($result);

    echo $value;

    if($value->kullaniciAdi!="" || $value->email!=""){
        echo "Z";
    }else{
        $sql = "INSERT INTO Uyeler(kullaniciAdi, sifre, isim, soyisim, email, meslek, telefon, bildiri) VALUES ('$kullaniciAdi','$sifre','$isim','$soyisim','$email','$meslek','$telefon',0)";

        if($baglanti->query($sql)){
            echo "E";
            mysqli_free_result($result);
            mysqli_close($baglanti);
        }else{
            echo "H";
        }
    }

}

?>
