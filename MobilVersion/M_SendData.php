<?php
    include 'Baglan.php';

    if($_POST){

        $baglanti=(new Baglan())->basla();
        $baglanti->select_db("Admin");

        $tc=$_POST["tc"];
        $yil=$_POST["year"];
        $isim=$_POST["name"];
        $soyisim=$_POST["lastname"];
        $email=$_POST['email'];
        $tel=$_POST['tel'];
        $sikayet=$_POST['sikayet'];
        $yer=$_POST['fakulte']." Sınıf ".$_POST['sinif'];
        $ariza=$_POST['ariza'];

        $sql = "INSERT INTO Arizalar(tcNo, isim, email, tel, sikayet, yer, ariza, tamamlandi) VALUES ('$tc','$isim $soyisim','$email','$tel','$sikayet','$yer','$ariza','hayir')";

        if($baglanti->query($sql)){
            echo "E";
        }else{
            echo "H";
        }

    }
?>