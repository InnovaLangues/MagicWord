var builder = {
    reorder: function(){
        wait.start("Réordonnancement des manches");
    },
    export: function(id){
        wait.start("Génération JSON");
        var url = Routing.generate('game_export', {id: id});
        $.ajax({
            type: "GET",
            url: url,
            success: function (json) {
                wait.stop();
                $("#json-export").val(JSON.stringify(json));
                $('#export-modal').modal('show');
            }
        });
    }
}
