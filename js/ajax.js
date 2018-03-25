

var meslek="";
var bildiri="";
var id="";

function start() {

    $.ajaxLoad=function () {
        var lastid=$("#cards div:first").attr("id");//html deki farızalardaki son id yi çekiyoruz

        if(lastid==null)//id yok ise
            lastid="0";

        //Ajax ile bilgiler GetData.php ya gönderiliyor
        $.ajax({
            type: 'post',
            url: 'GetData.php',
            data: {"lastid":lastid,"meslek":meslek,"bildiri":bildiri,"id":id},
            dataType: 'json',
            success: function(result) {
                if(result!=""){//GetData.php den gelen cevap alınıyor.
                    location.reload();//Eger bir cevap var ise sayfa yenileniyor
                }
            }
        });
    };
    setInterval('$.ajaxLoad()',5000);//Her 5 saniyede ajax çağırılıyor.
}


function setMeslek(val1,val2,val3) {
    meslek=val1;
    bildiri=val2;
    id=val3;
    start();
}
