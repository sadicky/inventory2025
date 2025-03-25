// setInterval(function () {
//     $.ajax({
//         url: "Public/script/sync_db.php",
//         type: "GET",
//         dataType: "json",
//         success: function (response) {
//             if (response.status === "success") {
//                 console.log("Base synchronisée !");
//             } else {
//                 console.error("Erreur de synchronisation :", response.error);
//             }
//         }
//     });
// }, 20000); // Toutes les 20s


function showToast(message) {
    let toast = $("#toast");
    toast.html(message);
    toast.addClass("show");
    setTimeout(() => toast.removeClass("show"), 4000);
}

function checkInternet(callback) {
    fetch("https://www.google.com", {
            mode: "no-cors"
        })
        .then(() => callback(true))
        .catch(() => callback(false));
}

setInterval(function () {
    checkInternet(function (isConnected) {
        if (isConnected) {
            $.ajax({
                url: "Public/script/sync_db.php",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        console.log("Base synchronisée !");
                    } else {
                        console.error("Erreur de synchronisation :", response.error);
                    }
                }
            });
        } else {
            showToast("<b>Pas de connexion Internet</b>");
        }
    });
}, 600000); // Vérification toutes les 60m