<?php

	class Baglan{
		
		function basla(){
			$link =	mysqli_connect('', 'root', '1997200Nine.');//veritabanına bağlanılıyor
			if (!$link) {
				echo 'Baglanamadı';
			}else{
				//Veritabanına türkçe karakterler desteği ekleniyor
                $link->query("SET NAMES utf8");
                $link->query("SET CHARACTER SET utf8");
                $link->query("SET COLLATION_CONNECTION='utf8_general_ci'");
                return $link;
			}

			return null;
		}
	}

?>

