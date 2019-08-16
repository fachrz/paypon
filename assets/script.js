function top_up() {
    var topup_submit = $("#topup-submit");
    var topup_modal = $("#topup-modal");

    topup_submit.click(function() {
        topup_modal.modal('hide');
    });
}

function topup_hapus() {
    var topup_id = $(".delete_topup").attr("id");
    var topup_notif = $("#topup-notif");
    $.ajax({
        url: "top-up-hapus.php",
        method : "POST",
        data: {topup_id:topup_id},
        success: function() {
            
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
        url: "bank.php",
        method : "POST",
        success: function(data) {
            $("#bank-card").html(data);
        }
    });
}

function getBank() {
    $.ajax({
        url : "getBank.php",
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
        url : "bank-register.php",
        method : "POST",
        data: data,
        success: function() {
            checkConnectedBank();
            $('#bank-modal').modal('hide');  
        }
    });
}