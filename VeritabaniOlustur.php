


<?php

	
	class VeritabaniOlustur{

		public $veritabaniAdi="Admin";
		public $tabloAdi1="Arizalar";
        public $tabloAdi2="Uyeler";


        function VeritabaniOlustur($baglanti){
            //Veritabanı oluşturuluyor
			$sql = 'CREATE DATABASE '.$this->veritabaniAdi;
			$baglanti->query($sql);
		}
		
		function tabloOlustur($sql){
            //Arizalar için tablo oluşturuluyor
            $table = "CREATE TABLE ".$this->tabloAdi1."(
				id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				tcNo varchar(11) NOT NULL,
				isim varchar(60) NOT NULL,
				email varchar(40) NOT NULL,
				tel varchar(10) NOT NULL,
				sikayet varchar(100) NOT NULL,
				yer varchar(30) NOT NULL,
				ariza varchar(30) NOT NULL,
				tamamlandi varchar(30) NOT NULL)
				CHARACTER SET utf8 COLLATE utf8_general_ci";
            $sql->query($table);

            //Uyeler için tablo oluşturuluyor
            $table = "CREATE TABLE ".$this->tabloAdi2."(
				id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				kullaniciAdi varchar(30) NOT NULL,
				sifre varchar(32) NOT NULL,
				isim varchar(20) NOT NULL,
				soyisim varchar(20) NOT NULL,
				email varchar(40) NOT NULL,
				meslek varchar(40) NOT NULL,
				telefon varchar(40) NOT NULL,
				bildiri int(11) NOT NULL)
				CHARACTER SET utf8 COLLATE utf8_general_ci";
            if($sql->query($table)){
                return true;
            }else{
                return false;
            }

		}
		
		
	}

?>