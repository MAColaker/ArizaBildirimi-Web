
<?php

    session_start();

    if($_SESSION["Meslek"]!="admin"){
        header('Location: http://159.89.103.125/TcKimlikSorgu.php');
    }

    include 'Baglan.php';
    include 'Information.php';

    $baglanti=(new Baglan())->basla();
    $baglanti->select_db("Admin");

    $information=new Information();

    $arizalar=$information->arizalar;
    $kullaniciAdi="";$sifre="";$isim="";$soyisim="";$email="";$eror="";

    if(isset($_POST['submit'])){

        //İnputlardaki veriler alınıyor.
        $sifre=$_POST['password'];
        $tekrarSifre=$_POST['repassword'];
        $kullaniciAdi=$_POST['username'];
        $isim=$_POST['name'];
        $soyisim=$_POST['lastname'];
        $email=$_POST['email'];
        $meslek=$arizalar[str_split($_POST['ariza'])[1]];
        $telefon=$_POST['tel'];


        if(strpos($sifre,' ')!==false){//Şifrede boşluk varise
            $eror="*Şifrede Boşluk Olamaz";
        }else{//Yok ise
            //şifrenin m5 i alınıyor
            $sifre=md5($sifre);
            $tekrarSifre=md5($tekrarSifre);

            //Şifre veritabanına aranıyor
            $result=$baglanti->query("SELECT kullaniciAdi,email FROM Uyeler WHERE kullaniciAdi='$kullaniciAdi' OR email='$email'");
            $value =  mysqli_fetch_object($result);

            if($value->kullaniciAdi!="" || $value->email!=""){//Eger kullanıcı adı veya epostadan varsa
                $eror="*Bu Kullanıcı Adı Veya Email Adresi Zaten Kullanılmakta";
            }
            else if($sifre==$tekrarSifre){//Yoksa şifre ile tekrar şifre kontrol ediliyor
                //Uyeler tablosuna yeni üye ekleniyor.
                $sql = "INSERT INTO Uyeler(kullaniciAdi, sifre, isim, soyisim, email, meslek, telefon, bildiri) VALUES ('$kullaniciAdi','$sifre','$isim','$soyisim','$email','$meslek','$telefon',0)";
                if($baglanti->query($sql)){//Başarılı ise
                    //Uye ekleme sekmesi kaoatılıyor
                    echo "<script>window.close();</script>";
                    mysqli_free_result($result);
                    mysqli_close($baglanti);
                }else{
                    $eror="*Üye Olamadınız, Lütfen Formu Kontrol Ediniz";
                }
            }else{
                $eror="*Şifre uyuşmuyor";
            }
        }
    }

?>


<html lang="tr" >

<head>
    <link rel="stylesheet" href="css/Css.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

    <script type="module" src="js/index.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=1024">
    <title>Giriş Yap - Kayıt Ol</title>
</head>

<body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>

    <div class="ekran">
        <div class="ustkisim"></div>
        <div class="altkisim">
            <form method="post" action="Kayitol.php" >

                <div class="formCard">
                    <div class="cubuk"></div>

                    <div class="formCard" id="formCard">
                        <div class="forum">
                            <div >
                                <h4 class="baslik_color" ><b>ÜYE OL</b></h4>
                            </div>
                            <!-- -->

                            <div class="row">
                                <div class="input-field col s12">

                                    <input  id="username" name="username" type="text" minlength="3" maxlength="30" class="validate" value="<?php echo $kullaniciAdi;?>" required >
                                    <label for="username">Kullanıcı Adı</label>

                                </div>
                            </div>


                            <div class="row">
                                <div class="input-field col s12">

                                    <input  id="password" name="password" type="password" minlength="5" maxlength="30" class="validate" value="" required >
                                    <label for="username">Şifre</label>

                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">

                                    <input  id="repassword" name="repassword" type="password" minlength="5" maxlength="30" class="validate" required >
                                    <label for="repassword">Şifre Tekrar</label>

                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">

                                    <input  id="name" name="name" type="text" minlength="2" maxlength="30" class="validate" value="<?php echo $isim;?>" required >
                                    <label for="name">İsim</label>

                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">

                                    <input  id="lastname" name="lastname" type="text" minlength="2" maxlength="30" class="validate" value="<?php echo $soyisim;?>" required >
                                    <label for="lastname">Soy İsim</label>

                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">

                                    <input  id="email" name="email" type="email" minlength="2" maxlength="40" class="validate" value="<?php echo $email;?>" required >
                                    <label for="email">Email</label>

                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="tel" name="tel" type="tel" pattern="^5\d{2}\d{3}\d{4}$" maxlength="10" class="validate" value="<?php echo $telefon;?>" required >
                                    <label for="tel">Cep Telefonu (5XXXXXXXXX)</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <select id="ariza" name="ariza" class="input-field col s12" required  >
                                        <option value="" disabled selected>Hangi Alanda Üye Olacaksınız</option>
                                        <?php
                                        for ($x = 0; $x < sizeof($arizalar); $x++) {
                                            echo "<option value='.$x+1.' >$arizalar[$x]</option> ";
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>

                            <div class="row" >
                                <div class="input-field col m6 s12" >
                                    <button  type="submit" name="submit" class="btn waves-light"><i class="material-icons right">send</i>Kayıt Ol</button>
                                    <p><font id="eror" color="#D50000" size="2px" face="elephant"><?php echo $eror;?></font></p>

                                </div>
                            </div>
                            <!-- -->
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>


</body>

</html>
