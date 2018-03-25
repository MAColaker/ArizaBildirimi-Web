<?php

include 'Baglan.php';
if($_POST){

    $baglanti=(new Baglan())->basla();
    $baglanti->select_db("Admin");

    //Ajaxdan gelen bilgiler alındı
    $ID=$_POST["ID"];
    $password=md5($_POST["password"]);
    $passwordID=$_POST["passwordID"];

    if($passwordID=="CONTROL"){//Eski şifre kontrolü yapılacak ise
        //gelen id ile gelen şifre kontrol ediliyor
        $result=$baglanti->query("SELECT * FROM Uyeler WHERE id='$ID' AND sifre='$password'");
        $value =  mysqli_fetch_object($result);

        if($value->id!=null)
            echo json_encode("E");
        else
            echo json_encode("H");

    }else if($passwordID=="UPDATE"){//Şifre güncellenecek ise
        //Gelen id deki şifre yenisi ile değiştiriliyor.
        $sql="UPDATE Uyeler SET sifre='$password' WHERE id=($ID)";

        if($baglanti->query($sql))
            echo json_encode("E");
        else
            echo json_encode("H");
    }

    mysqli_close($baglanti);
    mysqli_free_result($result);

}else{
    header('Location: http://159.89.103.125/TcKimlikSorgu.php');
}

?>