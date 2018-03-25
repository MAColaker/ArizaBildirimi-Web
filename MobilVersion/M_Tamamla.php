<?php


if($_POST){

    include 'Baglan.php';
    include 'M_Bildir.php';

    $baglanti=(new Baglan())->basla();
    $baglanti->select_db("Admin");


    $changeID=$_POST["changeID"];
    $durum=$_POST["durum"];
    $meslek=$_POST["meslek"];


    $bildir=(new M_Bildir())->bildir($meslek,$baglanti);

    $sql="UPDATE Arizalar SET tamamlandi='$durum' WHERE id=($changeID)";



    if($baglanti->query($sql))
        echo "E";
    else
        echo "H";

}

?>