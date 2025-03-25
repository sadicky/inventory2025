function refreshPageTransfert() {
    // location.reload();
    window.location.href = 'index.php?p=bank';
}

$(document).ready(function () {

    $("#resultat").hide();
    $(".bank-change").change(function () {
        var bank = $(this).val();
        if (bank) {
            $.ajax({
                type: 'POST',
                url: 'Public/script/somme.php',
                data: {
                    bank: bank
                },
                success: function (d) {
                    $('#resultat').html(d).slideDown();
                }

            });
        }
    });


    $("#formulaire_transfert").submit(function (event) {
        event.preventDefault();
        $.ajax({
            url: "Public/script/transfm.php",
            method: "POST",
            type: "post",
            data: $("#formulaire_transfert").serialize(),
            success: function (data) {
                $('#message').html(data).slideDown();
                setInterval(refreshPageTransfert, 3000);
            }
        });
    });

});