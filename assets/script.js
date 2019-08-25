function top_up() {
    var topup_submit = $("#topup-submit");
    var topup_modal = $("#topup-modal");

    topup_submit.click(function() {
        topup_modal.modal('hide');
    });
}

function notification(message, type, width) {
    var div = "<div class="+ "notification" +">"+ message +"</div>";
    var button = "<button class="+ "button-close" +"></button>";
    $('.alert-container').append(div);
    $('.alert-container').css("max-width", width)
    $('.notification').addClass("alert "+ type +" alert-dismissible fade show").append(button);
    $('.button-close').attr('type', 'button').attr('data-dismiss', 'alert').addClass('close');
    $('.button-close').append('<span>&times</span>');
}

function user_login(email, password) {
    $.ajax({
        url: "api/user_login.php",
        method : "post",
        data : {
            "email" : email,
            "password" : password
        },
        dataType : "json",
        success: function(response) {
            if (response.status == "sukses") {
                window.location.replace("myaccount/dashboard.php", "alert-success", "300px");
            }else if(response.status == "gagal"){
                notification("Email atau Password salah", "alert-danger", "300px");
            }else if(response.status == "tidak terdaftar"){
                notification("Email tidak terdaftar", "alert-danger", "300px")
            }
        }
    });
}
function user_register(email, password, nama, no_telp, alamat) {
    $.ajax({
        url: "api/user_register.php",
        method : "post",
        data : {
            "email" : email,
            "password" : password,
            "nama" : nama,
            "no_telp" : no_telp,
            "alamat" : alamat
        },
        dataType : "json",  
        success: function(response) {
            if (response.status == "sukses") {
                notification("Akun berhasil didaftarkan", "alert-success", "600px");
            }else if(response.status == "gagal"){
                notification("Akun gagal didaftarkan", "alert-danger", "600px");
            }else if(response.status == "terdaftar"){
                notification("Tidak bisa didaftarkan, Email sudah terdaftar", "alert-danger","600px");
            }
        }
    });
}

function checkConnectedBank() {
    $.ajax({
        url: "../api/bank_notification.php",
        method : "POST",
        success: function(data) {
            $("#bank-card").html(data);
        }
    });
}

function getBank() {
    $.ajax({
        url : "../api/getBank.php",
        method : "GET",
        dataType : "json",
        success: function(response) {
            response.forEach(bankdata => {
                var o = new Option(bankdata.nama_bank, bankdata.kode_bank);
                $("#nama-bank").append(o);
            });
        }
    })
}

function connectBank() {
    var data = $('#bank-form').serialize();
    $.ajax({
        url : "../api/bank-register.php",
        method : "POST",
        data: data,
        dataType : 'json',
        success: function(response){
            if (response.status == 'berhasil') {
                checkConnectedBank();
                $('#bank-modal').modal('hide');
            } 
        }
    });
}

function disconnectBank() {
    var data = $(".disconnect-bank").attr('id');
    $.ajax({
        url : "../api/bank-remove.php",
        method : "POST",
        data: {rek:data},   
        success: function() {
            checkConnectedBank();
        }
    });
}

function getActivity() {
    $.ajax({
        url : "../api/getActivity.php",
        method : "GET",
        success: function(response) {
              $(".activity-body").html(response);
        }
    }); 
}