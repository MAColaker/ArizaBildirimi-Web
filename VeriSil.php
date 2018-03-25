<?php

    include 'Baglan.php';



    if($_POST) {
        $baglanti=(new Baglan())->basla();
        $baglanti->select_db("Admin");

        //Ajaxdan gelen veriler alınıyor.
        $deleteID = $_POST["deleteID"];
        $tablo = $_POST["tablo"];

        //gelen tablo ve id ye ait veri siliniyor.
        $sql = "DELETE FROM $tablo WHERE id=$deleteID";
        if($baglanti->query($sql)){
            echo json_encode("E");
        }else{
            echo json_encode("H");
        }

        mysqli_close($baglanti);

    }else{
        header('Location: http://159.89.103.125/TcKimlikSorgu.php');
    }
?>