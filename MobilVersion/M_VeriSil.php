<?php

    include 'Baglan.php';
    include 'M_Bildir.php';

    if($_POST) {

        $baglanti=(new Baglan())->basla();
        $baglanti->select_db("Admin");


        $deleteID = $_POST["deleteID"];
        $tablo = $_POST["tablo"];
        $meslek=$_POST["meslek"];

        $bildir=(new M_Bildir())->bildir($meslek,$baglanti);

        $sql = "DELETE FROM $tablo WHERE id=$deleteID";
        if($baglanti->query($sql)){
            echo "E";
        }else{
            echo "H";
        }

    }
?>