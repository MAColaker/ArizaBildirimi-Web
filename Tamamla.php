<?php

include 'Baglan.php';

if($_POST){

    $baglanti=(new Baglan())->basla();
    $baglanti->select_db("Admin");

    //Ajax ile gelen veriler alınıyor.
    $changeID=$_POST["changeID"];
    $durum=$_POST["durum"];

    //Gelen ıd deki arıza güncelleniyor.
    $sql="UPDATE Arizalar SET tamamlandi='$durum' WHERE id=($changeID)";

    //evet veya hayır olarak ajaxa veri gönderiyor.
    if($baglanti->query($sql))
        echo json_encode("E");
    else
        echo json_encode("H");

    mysqli_close($baglanti);
}else{
    header('Location: http://159.89.103.125/TcKimlikSorgu.php');
}

?>