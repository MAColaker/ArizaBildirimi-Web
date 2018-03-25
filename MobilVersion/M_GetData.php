<?php
include 'Baglan.php';



if($_POST){

    $baglanti=(new Baglan())->basla();
    $baglanti->select_db("Admin");


    $meslek=$_POST["meslek"];
    $lastid=$_POST["lastid"];

    $bildiri=$_POST["bildiri"];
    $id=$_POST["id"];

    $now_bildiri=mysqli_fetch_object($baglanti->query("SELECT * FROM Uyeler WHERE id='$id'"))->bildiri;

    if(strlen($now_bildiri)>10){
        $query="UPDATE Uyeler SET bildiri=0 WHERE id='$id'";
        $baglanti->query($query);
    }

    $control=false;

    $result=$baglanti->query("SELECT COUNT(*) AS id FROM Arizalar");
    $dataCount=mysqli_fetch_assoc($result)['id'];


    if($dataCount==0){
        echo "EMPTY";
    }else if($now_bildiri!=$bildiri){
        echo "true"."-".$now_bildiri;
    }else{
        if($meslek=="admin")
        {
            $result=$baglanti->query("SELECT * FROM Arizalar WHERE id>$lastid ORDER BY id ASC ");
            while ($value = mysqli_fetch_object($result)){
                echo $value->id.'-'.$value->tcNo.'-'.$value->isim.'-'.$value->email.'-'.$value->tel.'-'.$value->sikayet.'-'.$value->yer.'-'.$value->ariza.'-'.$value->tamamlandi."/";
            }


        }else{
            $result=$baglanti->query("SELECT * FROM Arizalar WHERE id>$lastid AND ariza='$meslek' ORDER BY id ASC ");
            while ($value = mysqli_fetch_object($result)){
                echo $value->id.'-'.$value->isim.'-'.$value->email.'-'.$value->tel.'-'.$value->sikayet.'-'.$value->yer.'-'.$value->tamamlandi."/";
            }
        }
    }


}

?>