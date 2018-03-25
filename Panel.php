
<?php
    session_start();

    if($_SESSION["Meslek"]==null || $_SESSION["Meslek"]=="admin"){
        header('Location: http://159.89.103.125/TcKimlikSorgu.php');
    }

    include 'Baglan.php';
    include 'Information.php';

    $baglanti=(new Baglan())->basla();
    $baglanti->select_db("Admin");


    $id=$_SESSION["Meslek"];

    $result=$baglanti->query("SELECT * FROM Uyeler WHERE id='$id'");
    $value=mysqli_fetch_object($result);
    if(!$value){
        header('Location: http://159.89.103.125/TcKimlikSorgu.php');
    }

    $meslek=$value->meslek;
    $bildiri=$value->bildiri;
    $kullaniciAdi=$value->kullaniciAdi;



?>

<html>
    <head>
        <link rel="stylesheet" href="css/Css.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/css/materialize.min.css'>
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="css/PanelCss.css">
        <meta name="viewport" content="width=1024">

    </head>

    <ul>
        <nav id="main-nav" class="blue-grey">
            <div class="container">
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
                <a href="#" class="page-title"><?php echo mb_strtoupper(str_replace("i", "İ", $meslek), 'utf-8')?> ARIZASI PANELİ</a>
                <ul class="right">
                    <li><a onclick="change()" id="sifredegis" class="dropdown-button" style="cursor: pointer;"  data-activates="user-dropdown">Şifre Değiş</a></li>
                    <li><a class="dropdown-button" href="http://159.89.103.125/Cikis.php" data-activates="user-dropdown"><i class="mdi-action-input">  </i>Çıkış Yap</a></li>
                </ul>
            </div>

        </nav>
    </ul>


    <body >
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>

    <div class="container yy">
        <div class="row">

            <ul id="cards" style="size: 30px; color: rgb(96, 125, 139)">
                <?php

                $information=new Information();

                $result=$baglanti->query("SELECT * FROM Arizalar WHERE ariza='$meslek' ORDER BY id DESC ");

                while ($value=mysqli_fetch_object($result))
                {
                    $css="";
                    if($value->tamamlandi=="hayir"){
                        $css="hayir";
                        $button=' <a style="cursor: pointer;" name="'.$value->ariza.'" id="'.$value->id.'"onclick="tamamla(this.id,this.name)" class="blue-text">TAMAMLA</a>';
                    }
                    else{
                        $css="evet";
                        $button='<a class="black-text">TAMAMLANDI</a>';
                    }

                    echo ' <div id="'.$value->id.'" class="col s12 m6 l4">
                                <div id="'.$value->id.'" class="card small '.$css.'">        
                                  <div>
                                    <b><h5 class="abc">'.$value->isim.'</h5></b>
                                    <i class="abc">'.$value->tel.'</i>
                                    <p class="abc">'.$value->email.'</p>                      
                                    <p class="abc">
                                      <b>'.$value->yer.'</b>
                                    </p>           
                                    <li class="divider"></li>
                                    <p class="abc">'.$value->sikayet.'</p>
                                  </div>
                                  <div class="card-action">
                                    '.$button.'                  
                                  </div>
                                </div>
                              </div>';

                }
                mysqli_close($baglanti);
                mysqli_free_result($result);

                ?>

            </ul>
        </div>
    </div>

    <div class="altkisim xx" style="margin-top: 10%">
        <div class="formCard">
            <div class="formCard" id="formCard">
                <div class="forum">


                    <div class="row">
                        <div class="input-field col s12">

                            <input  id="oldpassword" name="oldpassword" type="password" minlength="5" maxlength="30" class="validate" value="" required >
                            <label for="username">Eski Şifre</label>

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


                    <div class="row" >
                        <div class="input-field col m6 s12" >
                            <button name="<?php echo $id;?>" onclick="passwordControl(this.name)"  type="submit"  class="btn waves-light">Değiştir</button>
                            <p><font  id="error" color="#D50000" size="2px" face="elephant"><?php echo $eror;?></font></p>
                        </div>
                    </div>
                    <!-- -->
                </div>
            </div>
        </div>
    </div>

    </body>
</html>
<script src="js/ajax.js"></script>
<script src="js/panel.js"></script>
<?php
echo "<script>
     setMeslek('$meslek','$bildiri','$id');
     datas('$kullaniciAdi');
</script>";
?>

<script>

    p_arizalar();

    var count=0;
    function change() {
        if(++count%2==0)
            p_arizalar();
        else
            p_sifre();
    }

    function p_arizalar() {
        document.getElementById("sifredegis").innerText="Şifre Değiş";
        $(".yy").css("display","block");
        $(".xx").css("display","none");
    }
    function p_sifre() {
        document.getElementById("sifredegis").innerText="Panele Dön";
        $(".yy").css("display","none");
        $(".xx").css("display","block");
    }

</script>


