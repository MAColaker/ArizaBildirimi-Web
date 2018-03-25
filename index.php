
<?php
    ob_start();
    session_start();

    if(!isset($_POST['submit'])){
        if($_SESSION["TcKimlikSorgu"]!="true"){
            unset($_SESSION["TcKimlikSorgu"]);
            header('Location: http://159.89.103.125/TcKimlikSorgu.php');
        }else{
            unset($_SESSION["TcKimlikSorgu"]);
        }
    }


    include 'Baglan.php';
    include 'Information.php';

    $information=new Information();

    $arizalar=$information->arizalar;
    $fakülteler=$information->fakülteler;
    $siniflar=$information->siniflar;


    $baglanti=(new Baglan())->basla();
    $baglanti->select_db("Admin");

    $eror="";

    $tc=$_SESSION["tc"];
    $yil=$_SESSION["year"];
    $isim=$_SESSION["name"];
    $soyisim=$_SESSION["lastname"];
    $ariza="";

    if(isset($_POST['submit']) && $tc!="" && $yil!="" && $isim!="" && $soyisim!=""){

        $email=$_POST['email'];
        $tel=$_POST['tel'];
        $sikayet=$_POST['sikayet'];
        $yer=$fakülteler[str_split($_POST['fakulte'])[1]]." Sınıf ".$siniflar[str_split($_POST['sinif'])[1]];
        $ariza=$arizalar[str_split($_POST['ariza'])[1]];


        $sql = "INSERT INTO Arizalar(tcNo, isim, email, tel, sikayet, yer, ariza, tamamlandi) VALUES ('$tc','$isim $soyisim','$email','$tel','$sikayet','$yer','$ariza','hayir')";

        if($baglanti->query($sql)){
            $eror="";
            $_SESSION["index"]="true";

            unset($_SESSION["tc"]);
            unset($_SESSION["year"]);
            unset($_SESSION["name"]);
            unset($_SESSION["lastname"]);


            header('Location: http://159.89.103.125/Sonuc.php');

        }else{
            $eror="*Form Gönderilemedi, Lütfen Tekrar Deneyin";
        }

    }

?>


<!--suppress ALL -->
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

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script type="module" src="js/index.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>

    <div class="ekran">
      <div class="ustkisim"></div>
      <div class="altkisim">


        <form method="post" action="index.php" >

            <div class="formCard">
              <div class="cubuk"></div>

              <div class="forum">
                <div ><h4 class="baslik_color"><b>ARIZA BİLDİRİMİ</b></h4>
                  <p><h6 class="baslik_color">Arıza Türünü Seçtikten Sonra Form Açılacaktır</h6></p>
                    <p><font id="eror" color="#D50000" size="2px" face="elephant"><?php echo $eror;?></font></p>
                  </div>
                <!-- -->

                  <div class="row">
                    <div class="input-field col s12">
                      <select id="ariza" name="ariza" class="input-field col s12" onchange="show()" data-error="#e0" required  >
                        <option value="" disabled selected>Arıza Türünü Seçiniz</option>
                          <?php
                            for ($x = 0; $x < sizeof($arizalar); $x++) {
                                echo "<option value='.$x+1.' >$arizalar[$x]</option> ";
                            }
                          ?>

                      </select>

                      <div id="e0"></div>
                    </div>
                  </div>

                <!-- -->
              </div>
            </div>
            <!--style="display:none"-->
            <div class="formCard" id="formCard2" style="display:none">
              <div class="forum">
                <!-- -->


                  <div class="row">
                    <div class="input-field col s12">
                      <i class="material-icons prefix" >email</i>
                      <input id="email" name="email" type="email" minlength="2" maxlength="40" class="validate" data-error="#e3" required  >
                      <label for="email">Email Adresiniz</label>
                      <div id="e3"></div>
                    </div>
                  </div>


                    <div class="row">
                      <div class="kolon">
                          <div class="input-field col s12">
                            <select id="fakulte" name="fakulte" class="input-field col s12" data-error="#e4" required  >
                                <option value="" disabled selected>Fakülte</option>
                                <?php
                                    for ($x = 0; $x < sizeof($fakülteler); $x++) {
                                        echo "<option value='.$x+1.' >$fakülteler[$x]</option> ";
                                    }
                                ?>
                            </select>
                            <div id="e4"></div>
                        </div>
                      </div>

                      <div class="kolon2">
                            <div class="input-field col s12">
                                <select id="sinif" name="sinif" class="input-field col s12" data-error="#e5" required  >
                                    <option value="" disabled selected>Sınıf</option>
                                    <?php
                                    for ($x = 0; $x < sizeof($siniflar); $x++) {
                                        echo "<option value='.$x+1.' >$siniflar[$x]</option> ";
                                    }
                                    ?>
                                </select>
                                <div id="e5"></div>
                            </div>
                        </div>
                    </div>


                  <div class="row">
                    <div class="input-field col s12">
                      <i class="material-icons prefix" >phone</i>
                      <input id="tel" name="tel" type="tel" pattern="^5\d{2}\d{3}\d{4}$" maxlength="10" class="validate" data-error="#e6" required >
                      <label for="tel">Cep Telefonu (5XXXXXXXXX)</label>
                      <div id="e6"></div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="input-field col s12">
                      <i class="material-icons prefix" >comment</i>
                      <textarea id="sikayet" name="sikayet" class="materialize-textarea" minlength="5" maxlength="100" data-error="#e7" required ></textarea>
                      <label for="sikayet">Şikayet</label>
                      <div id="e7"></div>
                    </div>
                  </div>

                  <div class="row" >
                    <div class="input-field col m6 s12" >
                        <button  type="submit" name="submit" class="btn waves-light"><i class="material-icons right">send</i>Gönder</button>
                    </div>
                  </div>


                <!-- -->
              </div>
            </div>

      </form>
    </div>
  </body>

</html>
<script>
    function show() {
        $("#formCard2").slideDown("slow", function() {
            // Animation complete.
        });
    }
</script>