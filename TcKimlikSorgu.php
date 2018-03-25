
<?php
    //curl için "apt-get install php-curl" eklenmeli
    function tcno_dogrula($bilgiler){
        //Bilgiler değişkene alınıyor
        $gonder = '<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                <soap:Body>
                <TCKimlikNoDogrula xmlns="http://tckimlik.nvi.gov.tr/WS">
                <TCKimlikNo>'.$bilgiler["tcno"].'</TCKimlikNo>
                <Ad>'.$bilgiler["isim"].'</Ad>
                <Soyad>'.$bilgiler["soyisim"].'</Soyad>
                <DogumYili>'.$bilgiler["dogumyili"].'</DogumYili>
                </TCKimlikNoDogrula>
                </soap:Body>
                </soap:Envelope>';
        //Bilgiler adrese gönderiliyor
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            "https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx" );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_POST,           true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,    $gonder);
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array(
            'POST /Service/KPSPublic.asmx HTTP/1.1',
            'Host: tckimlik.nvi.gov.tr',
            'Content-Type: text/xml; charset=utf-8',
            'SOAPAction: "http://tckimlik.nvi.gov.tr/WS/TCKimlikNoDogrula"',
            'Content-Length: '.strlen($gonder)
        ));
        //Gelen cevap değişkene alınıyor(true,false)
        $gelen = curl_exec($ch);
        curl_close($ch);
        return strip_tags($gelen);
    }

    include 'Baglan.php';
    include 'VeritabaniOlustur.php';
    include 'Information.php';

    $information=new Information();

    $baglanti=(new Baglan())->basla();

    $veritabani = new VeritabaniOlustur($baglanti);

    $baglanti->select_db("Admin");

    if($veritabani->tabloOlustur($baglanti)){
        $sifre=md5('12345678');
        $sql = "INSERT INTO Uyeler(kullaniciAdi, sifre, isim, soyisim, email, meslek, telefon, bildiri) VALUES ('admin','$sifre','-','-','-','admin','-',0)";
        $baglanti->query($sql);
    }


    $tc="";$yil="";$isim="";$soyisim="";$eror="";$kullaniciAdi="";$sifre="";

    session_start();


    if(isset($_POST['submit'])){
        //Kimlik Sorgulama
        $tc=$_POST['tc'];
        $yil=$_POST['year'];
        $isim=mb_strtoupper(str_replace("i", "İ", $_POST['name']), 'utf-8');
        $soyisim=mb_strtoupper(str_replace("i", "İ", $_POST['lastname']), 'utf-8');

        $bilgiler = array(
            "isim"      => $isim,
            "soyisim"   => $soyisim,
            "dogumyili" => (string)$yil,
            "tcno"      => (string)$tc
        );



        $sonuc = tcno_dogrula($bilgiler);
        if($sonuc=="true"){

            $_SESSION["TcKimlikSorgu"] = "true";
            $_SESSION["tc"] = $tc;
            $_SESSION["year"] = $yil;
            $_SESSION["name"] = $isim;
            $_SESSION["lastname"] = $soyisim;


            header('Location: http://159.89.103.125/index.php');
        }else{
            $eror="*Kimlik Bilgilerinizde Hata Var";
        }


    }else if(isset($_POST['submitGiris'])){
        //Giriş Yapma
        $kullaniciAdi=$_POST['username'];
        $sifre=md5($_POST['password']);//Şifrenin md5 i alındı
        //KullanıcıAdı ve şifre veritabanında aratıldı
        $result=$baglanti->query("SELECT * FROM Uyeler WHERE kullaniciAdi='$kullaniciAdi' AND sifre='$sifre'");
        $value =  mysqli_fetch_object($result);

        if($value->id!=null){//Eger bu kullanıcı adı ve şifreye ait bir id var ise

            //Veritabanı kapatıldı
            mysqli_free_result($result);
            mysqli_close($baglanti);

            //Kullanıcının admin olup olmadığını mesleğe bakarak anlıypruz
            $meslek=$value->meslek;
            if($meslek!='admin'){//mesleği admin ise
                $_SESSION["Meslek"] = $value->id;//id'si session ile panel sayfasına gönderiliyor
                header('Location: http://159.89.103.125/Panel.php');
            }else{//değil ise
                $_SESSION["Meslek"] =  "admin";//admin olduğu session ile adminpaneli sayfasına gönderiliyor
                header('Location: http://159.89.103.125/AdminPanel.php');
            }
        }else{
            $eror="*Kullanıcı Adı Veya Parola Hatalı";
        }
    }


?>

<html lang="tr" >
<head>
    <link rel="stylesheet" href="css/Css.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">


    <meta charset="utf-8">

    <meta name="viewport" content="width=1024">
    <title>Arıza Bildirim Formu</title>
</head>



<body>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js'></script>
<script src="js/index.js"></script>

<div class="ekran">


    <div class="ustkisim">


        <form action="" method="post">
            <div style="margin:0;padding:10px; ">
                <div style="text-align: right">
                    <input style="height: 20px; width: 100px; size: 14px" id="username" name="username" type="text"  class="validate" autocomplete="off"  value="<?php echo $kullaniciAdi;?>" placeholder="Kullanıcı Adı" required >
                    <input style="height: 20px; width: 100px; size: 14px"  id="password" name="password" type="password"  class="validate" autocomplete="off" placeholder="Şifre" required >
                </div>
            </div>

            <button  type="submit" id="submitGiris" name="submitGiris" style="display:none" class="btn waves-light"></button>

        </form>


    </div>

    <div class="altkisim">

        <form method="post" action="TcKimlikSorgu.php" >

            <div class="formCard">
            <div class="cubuk"></div>

            <div class="formCard" id="formCard">
                <div class="forum">
                    <div ><h4 class="baslik_color" ><b>KİMLİK DOĞRULAMA</b></h4>
                        <p><h6 class="baslik_color">Arıza Bildiriminiz İçin Kimlik Bilgilerinizi Doğrulamalısınız</h6></p>
                    </div>
                    <!-- -->

                    <div class="row">
                        <div class="kolon">
                            <div class="input-field col s12">

                                <i class="material-icons prefix" >branding_watermark</i>
                                <input  id="tc" name="tc" type="tel" pattern="^\d{11}$" maxlength="11" class="validate" value="<?php echo $tc;?>" data-error="#e1" required >
                                <label for="tc">TC No</label>

                                <div id="e1"></div>
                            </div>
                        </div>

                        <div class="kolon2">
                            <div class="input-field col s12">
                                <input id="year" name="year" type="tel" pattern="^\d{4}$" maxlength="4" class="validate" value="<?php echo $yil;?>" data-error="#e12" " required >
                                <label for="year">Doğum Yılı</label>
                                <div id="e12"></div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="kolon3">
                            <div class="input-field col s12">
                                <i class="material-icons prefix" >account_box</i>
                                <input id="name" name="name" type="text" minlength="2" maxlength="30" class="validate" data-error="#e2" value="<?php echo $isim;?>" required >
                                <label for="name">İsim</label>
                                <div id="e2"></div>
                            </div>
                        </div>

                        <div class="kolon3">
                            <div class="input-field col s12">
                                <input id="lastname" name="lastname" type="text" minlength="2" maxlength="30" class="validate" value="<?php echo $soyisim;?>" data-error="#e11" required >
                                <label for="lastname">Soyisim</label>
                                <div id="e11"></div>
                            </div>
                        </div>
                    </div>


                    <div class="row" >
                        <div class="input-field col m6 s12" >
                            <button  type="submit" name="submit" class="btn waves-light"><i class="material-icons right">send</i>Gönder</button>

                        </div>
                    </div>

                    <p style="color:#D50000; size: 2px; face: elephant;"><?php echo $eror;?></p>
                    <!-- -->
                </div>
            </div>
        </div>

    </form>
</div>

</body>

</html>


