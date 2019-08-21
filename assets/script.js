function top_up() {
    var topup_submit = $("#topup-submit");
    var topup_modal = $("#topup-modal");

    topup_submit.click(function() {
        topup_modal.modal('hide');
    });
}

function user_login() {
    var data = $('#login-form').serialize();
    $.ajax({
        url: "api/user_login.php",
        method : "post",
        data : data,
        dataType : "json",
        success: function(response) {
            if (response.status == "sukses") {
                $(".alert").hide();
                window.location.replace("myaccount/dashboard.php");
            }else if(response.status == "gagal"){
                $(".alert").show();
            }
        }
    });
}

// function getTopup() {
//     $.ajax({
//         url : "getTopup.php",
//         method : "GET",
//         dataType : "json",
//         success: function(response) {
//             response.forEach(topupdata => {
//                 console.log(topupdata.jumlah_topup);
//             });
//         }
//     })
// }

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