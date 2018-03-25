<?php
include 'Baglan.php';

if($_POST){
    //Ajaxdan eriler alınıyor
    $meslek=$_POST["meslek"];
    $baglanti=(new Baglan())->basla();
    $baglanti->select_db("Admin");

    //admin ve gelen mesleğin bildirisi bir arttırılıyor.
    $query="UPDATE Uyeler SET bildiri=bildiri+1 WHERE meslek='$meslek' OR meslek='admin'";

    if($baglanti->query($query))
        echo json_encode("E");
    else
        echo json_encode("H");

    mysqli_close($baglanti);
}else{
    header('Location: http://159.89.103.125/TcKimlikSorgu.php');
}

?>