<?php

    include 'Baglan.php';

    if($_POST){
        $baglanti=(new Baglan())->basla();
        $baglanti->select_db("Admin");

        $kullaniciAdi=$_POST['username'];
        $sifre=md5($_POST['password']);

        $result=$baglanti->query("SELECT * FROM Uyeler WHERE kullaniciAdi='$kullaniciAdi' AND sifre='$sifre'");
        $value =  mysqli_fetch_object($result);

        if($value->id!=null){

            mysqli_free_result($result);
            mysqli_close($baglanti);


            echo $value->id."-".$value->meslek."-".$value->bildiri."-".$value->kullaniciAdi;

        }else{
            echo "H";
        }
    }
?>