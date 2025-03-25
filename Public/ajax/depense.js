$(document).ready(function () {

    $(document).on('click', '#depenses', function () {
        load_form_dep('');
    });

    $(document).on('click', '#avances', function () {
        load_form_avance('');
    });

    $(document).on('click', '#tab_avances', function () {
        load_tab_avance_dette('');
    });

    $(document).on('submit', '#ad-searcher', function () {
        from_d = $('#from_d').val();
        to_d = $('#to_d').val();
        branche_id = $('#pos_id').val();
        load_tab_avance_dette(from_d, to_d, branche_id);
    });

    $(document).on('submit', '#ad-commission', function () {
        from_d = $('#from_d').val();
        to_d = $('#to_d').val();
        id = $('#pos_id').val();
        load_tab_commission(from_d, to_d, id);
    });

    $(document).on('blur', '#mont_trans', function () {
        mont_trans = $("#mont_trans").val();

        alert('SVP, Verifie bien votre montant ' + mont_trans);

    });

    $(document).on('submit', '#form_cash_out', function (event) {
        event.preventDefault();
        $.ajax({
            url: "Public/script/add_cash_out.php",
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (data) {
                alert(data);
                load_form_dep('');
            }
        });
    });

    $(document).on('submit', '#form_avance_dette', function (event) {
        event.preventDefault();
        $.ajax({
            url: "Public/script/add_avance_dette.php",
            method: 'POST',
            contentType: false,
            processData: false,
            data: new FormData(this),
            success: function (data) {
                alert(data);
                load_tab_avance_dette('');
            }
        });
    });

});


//FUNCTIONS

function load_form_dep(trans_id) {
    $.ajax({

        url: "Public/partials/form_cash_dep.php",
        method: "GET",
        data: {
            trans_id: trans_id
        },
        success: function (data) {
            $('#page-content').html(data);
            $('.afficher').hide();
            // //   $('.number-separator').number( true, 0 );
            //   search_field("tables/list_dep.php");
        }
    })
}

function load_form_avance(trans_id) {
    $.ajax({

        url: "Public/partials/form_cash_avance.php",
        method: "GET",
        data: {
            trans_id: trans_id
        },
        success: function (data) {
            $('#page-content').html(data);
            $('.afficher').hide();
            $('.select2').select2();
            // toastr.success('This is a Success Toast', 'lorem ipsum asit');
        }
    })
}

function load_tab_avance_dette(from_d, to_d, branche_id) {
    $.ajax({
        url: "Public/script/tab_avance_dette.php",
        method: "GET",
        data: {
            branche_id: branche_id,
            from_d: from_d,
            to_d: to_d
        },
        beforeSend: function () {
            $('#page-content').html('<p><b>Page en chargement .......</b></p>');
        },
        success: function (data) {
            $('#page-content').html(data);
            $('.afficher').hide();
            $('.tab').dataTable();
        }

    })
}

function load_tab_commission(from_d, to_d, id) {
    $.ajax({
        url: "Public/script/tab_commission.php",
        method: "GET",
        data: {
            id: id,
            from_d: from_d,
            to_d: to_d
        },
        beforeSend: function () {
            $('#page-content').html('<p><b>Page en chargement .......</b></p>');
        },
        success: function (data) {
            $('#page-content').html(data);
            $('.afficher').hide();
            $('.tab').dataTable();
        }

    })
}

function search_field(url) {
    $("#autocomplete_field").autocomplete({
        source: function (request, response) {

            $.ajax({
                url: url,
                type: 'post',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $('#autocomplete_field').val(ui.item.label); // display the selected text
            $('#select_id').val(ui.item.value); // save selected id to input
            return false;
        },
        focus: function (event, ui) {
            $("#autocomplete_field").val(ui.item.label);
            $("#select_id").val(ui.item.value);
            return false;
        },
    });
}