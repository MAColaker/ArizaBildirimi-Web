<?php
    include 'Baglan.php';



    if($_POST){

        $baglanti=(new Baglan())->basla();
        $baglanti->select_db("Admin");

        //Ajax ile gelen veriler alınıyor.
        $meslek=$_POST["meslek"];
        $lastid=$_POST["lastid"];
        $bildiri=$_POST["bildiri"];
        $id=$_POST["id"];

        $control="";

        //Tablodaki arıza sayısına bakılıyor.
        $result=$baglanti->query("SELECT COUNT(*) AS id FROM Arizalar");
        $dataCount=mysqli_fetch_assoc($result)['id'];

        if($dataCount!=0){//Tabloda veri var ise
            //Bildiri sayısı çekiliyor
            $now_bildiri=mysqli_fetch_object($baglanti->query("SELECT * FROM Uyeler WHERE id='$id'"))->bildiri;

            if(strlen($now_bildiri)>10){//Eger bildiri sayısı 10 haneyi geçtiyse bildiri sıfırlanıyor
                $query="UPDATE Uyeler SET bildiri=0 WHERE id='$id'";
                $baglanti->query($query);
            }

            if($now_bildiri!=$bildiri){//Önceki bildiri(ajaxdan gelen) ile şuanki bildiri eşit değil ise
                $control="true";
            }else{//eşit ise
                if($meslek=="admin")//kullanıcı admin ise
                {
                    //Tüm arızalarda,son id den büyük olan id'ler çekiliyor.
                    $result=$baglanti->query("SELECT * FROM Arizalar WHERE id>$lastid ORDER BY id DESC ");
                    while ($value = mysqli_fetch_object($result)){
                        $control="true";
                    }
                }else{//değil ise
                    //Ajax ile gelen mesleğe ait arızalarda, son id den büyük olan id'ler çekiliyor.
                    $result=$baglanti->query("SELECT * FROM Arizalar WHERE id>$lastid AND ariza='$meslek' ORDER BY id DESC ");
                    while ($value = mysqli_fetch_object($result)){
                        $control="true";
                    }
                }
            }
        }
        //Veritabanı kapatılıyor
        mysqli_close($baglanti);
        mysqli_free_result($result);

        //Eger bir işlem yapıldıysa değişkende true vardır, hiç bir işlem yapılmadıysa değişken boştur
        echo json_encode($control);//Bu değişken ajaxa gönderiliyor.
    }else{
        header('Location: http://159.89.103.125/TcKimlikSorgu.php');
    }


?>