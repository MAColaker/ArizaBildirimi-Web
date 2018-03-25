<?php
    include 'Information.php';

    if($_POST){
        $information=new Information();

        $arizalar=$information->arizalar;
        $fakülteler=$information->fakülteler;
        $siniflar=$information->siniflar;

        for($i=0; $i<sizeof($arizalar);$i++){
            echo $arizalar[$i]."/";
        }
        echo "-";
        for($i=0; $i<sizeof($fakülteler);$i++){
            echo $fakülteler[$i]."/";
        }
        echo "-";
        for($i=0; $i<sizeof($siniflar);$i++){
            echo $siniflar[$i]."/";
        }
    }

?>