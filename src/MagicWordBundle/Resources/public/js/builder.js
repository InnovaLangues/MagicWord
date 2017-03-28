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
    },

    import: function(){
        wait.start("Import en cours");
        var json = $("#import-json").val();
        var url = Routing.generate('json_import');

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'json' : json
            },
            success: function (data) {
                var url = Routing.generate('massive_builder', {id: data.id});
                location.href = url;
            }
        });
    }
}
