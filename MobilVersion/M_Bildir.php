<?php

class M_Bildir{
    function bildir($meslek,$baglanti){

        $query="UPDATE Uyeler SET bildiri=bildiri+1 WHERE meslek='$meslek' OR meslek='admin'";
        $baglanti->query($query);
    }
}



?>