$(document).ready(function () {

    $('#pos_id').on('change',function(){
        let pos_id = $(this).val();
        alert(pos_id)
        if(pos_id){
            $.ajax({
                type:'POST',
                url:'Public/script/join2.php',
                data:'pos_id='+pos_id,
                success:function(d){
                    $('#caisse_id').html(d);
                }

            });
        }
    });



});