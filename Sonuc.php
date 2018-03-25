<?php
    session_start();

    if($_SESSION["index"]!="true"){
        unset($_SESSION["index"]);
        header('Location: http://159.89.103.125/TcKimlikSorgu.php');
    }else{
        unset($_SESSION["index"]);
    }
?>s

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
    <title>Arıza Bildirim Formu</title>
</head>

<body>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>


<div class="ekran">

    <div class="ustkisim"></div>
    <div class="altkisim">

        <form method="post" action="<?php $PHP_SELF ?>" >

            <div class="formCard">
                <div class="cubuk"></div>

                <div class="formCard" id="formCard">
                    <div class="forum">
                        <!-- -->
                        <div ><h4 style="baslik_color"><b>BAŞARILI</b></h4>
                            <p><h6 style="baslik_color">Talebiniz Başarıyla Alınmıştır. En Kısa Sürede Teknik Persone Sorunu Gidermek İçin Gelecektir </h6></p>
                        </div>

                        <!-- -->
                    </div>
                </div>
            </div>

        </form>
    </div>
</body>

</html>