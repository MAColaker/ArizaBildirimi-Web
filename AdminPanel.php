
<?php
session_start();

if($_SESSION["Meslek"]==null || $_SESSION["Meslek"]!="admin"){
    header('Location: http://159.89.103.125/TcKimlikSorgu.php');
}

    include 'Baglan.php';
    include 'Information.php';

    $baglanti=(new Baglan())->basla();
    $baglanti->select_db("Admin");


    //adminin id ve bildiri'si değişkenlere aktarılıyor.
    $value=mysqli_fetch_object($baglanti->query("SELECT * FROM Uyeler WHERE meslek='admin'"));
    $id=$value->id;
    $bildiri=$value->bildiri;
    $kullaniciAdi=$value->kullaniciAdi;

?>



<html>
<head>
    <link rel="stylesheet" href="css/Css.css">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/css/materialize.min.css'>
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="module" src="js/index.js"></script>
    <link rel="stylesheet" href="css/PanelCss.css">
    <meta name="viewport" content="width=1024">

</head>

<body >

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>

<header>
    <nav id="main-nav" class="blue-grey">
        <div class="container">
            <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
            <a href="#" class="page-title">ARIZA YÖNETİM PANELİ</a>
        </div>
    </nav>
    <ul id="slide-out" class="side-nav">
        <li class="center-align black-text logo"><a>ADMİN</a></li>
        <li class="divider"></li>
        <li><a href="#" onclick="arizalar()"><i class="mdi-action-dashboard left"></i>Panel</a></li>
        <li><a href="#" onclick="uyeler(),reflesh()"><i class="mdi-social-people left"></i>Üyeler</a></li>
        <li><a target="_blank" href="http://159.89.103.125/Kayitol.php" onclick="arizalar()"><i class="mdi-social-person-add left"></i>Üye Ekle</a></li>
        <li><a style="cursor: pointer;" onclick="sifre()"><i class="mdi-action-settings left"></i>Şifre</a></li>
        <li><a class="dropdown-button" href="http://159.89.103.125/Cikis.php" data-activates="user-dropdown"><i class="mdi-action-input left"></i>Çıkış Yap</a></li>
    </ul>
</header>

<main>

    <div class="container">
        <div class="row">

            <ul id="cards" style="size: 30px; color: rgb(96, 125, 139)">
                <?php
                $information=new Information();

                //Arizalar tablosundaki tüm veriler çekiliyor
                $result=$baglanti->query("SELECT * FROM Arizalar ORDER BY id DESC ");
                while ($value=mysqli_fetch_object($result))
                {
                    //Tamamlanmışlık durumuna göre buton seçiliyor
                    if($value->tamamlandi=="hayir"){
                        $css="hayir";
                        $Text='<p class="abc">tamamlanmadı</p>';
                        $button='<a name="'.$value->ariza.'"  style="cursor: pointer;" onclick="tamamla(this.id,this.name)" id="'.$value->id.'" class="blue-text">TAMAMLA</a>';
                    }
                    else{
                        $css="evet";
                        $Text='<p class="abc">'.$value->tamamlandi.' '.tamamladı.'</p>';
                        $button='<a name="'.$value->ariza.'" id="'.$value->id.'" style="cursor: pointer;" onclick="gerial(this.id,this.name)" class="blue-text">GERİAL</a>';
                    }

                    //Arıza bilgileri karta yerleştiriliyor ve echo ekrana yazdırılıyor.
                    echo '<div id="'.$value->id.'" class="col s12 m6 l4">
                        <div class="card zz '.$css.'">        
                          <div>
                            <b><h5 class="abc">'.$value->isim.'</h5></b>
                            <b><p class="abc">'.$value->tcNo.'</p></b>
                            <p class="abc">'.$value->tel.'</p>
                            <p class="abc">'.$value->email.'</p>                      
                            <p class="abc">
                            <b>'.$value->yer.'</b>
                            </p>           
                            <li class="divider"></li>
                            <p class="abc cardSize">'.$value->sikayet.'</p>
                             '.$Text.'
                          </div>
                          <div class="card-action">
                            <a class="black-text">'.$value->ariza.'</a>
                            '.$button.'
                            <a  name="'.$value->ariza.'" style="cursor: pointer;" id="'.$value->id.'" onclick="isDeleteAriza(this.id,this.name)" class="red-text">SİL</a>
                          </div>
                        </div>
                      </div>';

                }
                //Veritabanı kapatılıyor
                mysqli_close($baglanti);
                mysqli_free_result($result);
                //Tüm üyeler çekiliyor
                $result=$baglanti->query("SELECT * FROM Uyeler WHERE meslek<>'admin'");
                while ($value=mysqli_fetch_object($result))
                {
                    //Karta yerleştirilip echo ile ekrana basılıyor.
                    echo '<div id="Uye'.$value->id.'" class="card yy">        
                              <div>            
                                  <p class="abc ab">'.$value->kullaniciAdi.'</p>
                                  <p class="abc ab">'.$value->isim.'  '.$value->soyisim.'</p>                         
                                  <p class="abc ab">'.$value->email.'</p>
                                  <p class="abc ab">'.$value->telefon.'</p>
                                  <p class="abc ab">'.$value->meslek.'</p>
                              </div>
                              <div class="card-action ac" style="border-top: none;">
                                <a href="" name="" id="'.$value->id.'" onclick="isDeleteUye(this.id,this.name)"  class="red-text">SİL</a>
                              </div>
                          </div>';
                }
                //Veritabanı kapatılıyor
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
</main>


<script src="js/ajax.js"></script>
<script src="js/panel.js"></script>
</body>
</html>

<?php
echo "<script>
    setMeslek('admin','$bildiri','$id');
    datas('$kullaniciAdi');
</script>";
?>





