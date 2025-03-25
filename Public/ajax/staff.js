function refreshPage() {
    location.reload();
}


$(document).ready(function () {

    $("#formulaire-staff").submit(function (event) {
        event.preventDefault();
        $.ajax({
            url: "Public/script/addstaff.php",
            method: "POST",
            type: "post",
            data: $("#formulaire-staff").serialize(),
            success: function (data) {
                $('#message').html(data).slideDown();
                $("#formulaire-staff")[0].reset();
                $("#add-staff").modal("hide");
                setInterval(refreshPage, 1000);
            }
        });
    });

    $("#formulaire-salaire-add").submit(function (event) {
        event.preventDefault();
        $.ajax({
            url: "Public/script/addsalstaff.php",
            method: "POST",
            type: "post",
            data: $("#formulaire-salaire-add").serialize(),
            success: function (data) {
                $('#message').html(data).slideDown();
                $("#formulaire-salaire-add")[0].reset();
                $("#add-salaire").modal("hide");
                setInterval(refreshPage, 1000);
            }
        });
    });

    $(document).on("click", ".delete-staff", function (event) {
        event.preventDefault();
        var id = $(this).attr("id");
        if (confirm("Voulez-vous supprimer? ")) {
            $.ajax({
                url: "Public/script/deletestaff.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function (data) {
                    $('#messages').html(data).slideDown();
                    setInterval(refreshPage, 1000);
                }
            });
        } else {
            return false;
        }
    });

});

function search_agent(url) {
    $("#autocomplete_agent").autocomplete({
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
            $('#autocomplete_agent').val(ui.item.label); // display the selected text
            $('#agent_id').val(ui.item.value); // save selected id to input
            return false;
        },
        focus: function (event, ui) {
            $("#autocomplete_agent").val(ui.item.label);
            $("#agent_id").val(ui.item.value);
            return false;
        },
    });
}

function autocomplete_agents() {
    keyword = $('#content_lib_agent').val();
    $.ajax({
        url: 'Public/script/list_agents.php',
        type: 'POST',
        data: {
            keyword: keyword
        },
        success: function (data) {
            $('#content_list_prod_v').show();
            $('#content_list_prod_v').html(data);
        }
    });
}