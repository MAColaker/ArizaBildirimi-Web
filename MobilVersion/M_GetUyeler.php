<?php

include 'Baglan.php';



if($_POST){

    $baglanti=(new Baglan())->basla();
    $baglanti->select_db("Admin");


    $postControl=$_POST["post"];


    $result=$baglanti->query("SELECT * FROM Uyeler WHERE meslek<>'admin'");
    while ($value = mysqli_fetch_object($result)){
        echo $value->id.'-'.$value->kullaniciAdi.'-'.$value->isim.'-'.$value->soyisim.'-'.$value->email.'-'.$value->telefon.'-'.$value->meslek."/";
    }


}


?>