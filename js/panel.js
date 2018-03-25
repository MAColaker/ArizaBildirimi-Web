
var username="";
function datas(val_username) {
    username=val_username;
}


if(document.cookie.indexOf(";")==-1){//Eger çerezlerde birşey yok ise
    arizalar();//defauşt olarak arizalar yükleniyor
}else if(document.cookie.split(";")[1].trim()==='U'){//Eger çerezlerde üyeler sayfası kayıtlı ise
    uyeler();//uyeler yukleniyor
}else if(document.cookie.split(";")[1].trim()==='A'){//Eger çerezlerde arizlar sayfası kayıtlı ise
    arizalar();//arizalar yukleniyor
}

function tamamla(id,ariza) {

    if(confirm("Bu arıza giderildi mi?")){
        $.ajax({
            type: 'post',
            url: 'Tamamla.php',
            data: {"changeID":id,"durum":username},
            dataType: 'json',
            success: function(result) {
                if(result!=="E"){
                    alert("Hata Oluştu");
                }else{
                    bildir(ariza);
                }
            }
        });
    }
}

function isDeleteAriza(id,ariza) {
    if(confirm("Silmek istediğinize emin misiniz?")){
        sil(id,"Arizalar",ariza)
    }
}

function isDeleteUye(id,ariza) {
    if(confirm("Silmek istediğinize emin misiniz?")){
        sil(id,"Uyeler","")
    }
}

function sil(id,tablo,ariza){

    $.ajax({
        type: 'post',
        url: 'VeriSil.php',
        data: {"deleteID":id,"tablo":tablo},
        dataType: 'json',
        success: function(result) {
            if(result!=="E"){
                alert("Silinemedi");
            }else{
                if(ariza!=="")
                    bildir(ariza);
                else
                    reflesh();
            }

        }
    });
}
function gerial(id,ariza) {
    if(confirm("Geri alınsın mı?")){
        $.ajax({
            type: 'post',
            url: 'Tamamla.php',
            data: {"changeID":id,"durum":"hayir"},
            dataType: 'json',
            success: function(result) {
                if(result!=="E"){
                    alert("Hata Oluştu");
                }else {
                    bildir(ariza);
                }

            }
        });
    }
}


function bildir(ariza) {

    $.ajax({
        type: 'post',
        url: 'Bildir.php',
        data: {"meslek":ariza},
        dataType: 'json',
        success: function(result) {
            if(result==="E")
                reflesh();
        }
    });
}

function reflesh() {
    location.reload();
}

///scrollbarı aynı yerde tuttu
$(window).scroll(function() {
    sessionStorage.scrollTop = $(this).scrollTop();
});

$(document).ready(function() {
    if (sessionStorage.scrollTop !== "undefined") {
        $(window).scrollTop(sessionStorage.scrollTop);
    }
});
//////////////////////////////

function uyeler() {
    //Üyeler sayfası aktif, diğer sayfalar pasif hale gelir
    document.cookie="U";
    $(".yy").css("display","block");
    $(".zz").css("display","none");
    $(".xx").css("display","none");
}
function arizalar() {
    //Arizalar sayfası aktif, diğer sayfalar pasif hale gelir
    document.cookie="A";
    $(".yy").css("display","none");
    $(".zz").css("display","block");
    $(".xx").css("display","none");
}
function sifre() {
    //Sifre sayfası aktif, diğer sayfalar pasif hale gelir
    document.cookie="A";
    $(".yy").css("display","none");
    $(".zz").css("display","none");
    $(".xx").css("display","block");
}

function passwordUpdate(id,pass1,pass2) {

    if(pass1===pass2){
        $.ajax({
            type: 'post',
            url: 'Parola.php',
            data: {"ID":id,"password":pass1,"passwordID":"UPDATE"},
            dataType: 'json',
            success: function(result) {
                if(result==="E"){
                    document.getElementById("oldpassword").innerText="";
                    document.getElementById("password").innerText="";
                    document.getElementById("repassword").innerText="";
                    alert("Şifre Başarı İle Güncellendi");
                }

                else
                    document.getElementById("error").innerText="*Bir Sorun Oluştu";
            }
        });
    }else {
        document.getElementById("error").innerText="*Şifreler Uyuşmuyor";
    }

}

function passwordControl(id) {

    var oldPassword=document.getElementById("oldpassword").value.toString();
    var newPassword=document.getElementById("password").value.toString();
    var r_newPassword=document.getElementById("repassword").value.toString();
    document.getElementById("error").innerText="";


    if(newPassword.indexOf(" ")!=-1){
        document.getElementById("error").innerText="*Şifrede Boşluk Olamaz";
    }else if(oldPassword.length>4 && newPassword.length>4 && r_newPassword.length>4){
        $.ajax({
            type: 'post',
            url: 'Parola.php',
            data: {"ID":id,"password":oldPassword,"passwordID":"CONTROL"},
            dataType: 'json',
            success: function(result) {
                if(result==="E")
                    passwordUpdate(id,newPassword,r_newPassword);
                else{
                    document.getElementById("error").innerText="*Hatalı Parola";
                }

            }
        });
    }



}