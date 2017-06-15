var gridPatternHandler = {
    list: function(){
        var url = Routing.generate('get_all_patterns');
        $.ajax({
            type: 'GET',
            url: url,
        })
        .done(function(data) {
            modalHandler.createModale("patterns", "patterns_list", data);
        });
    },

    delete: function(id) {
        var url = Routing.generate('pattern_delete', { id : id});
        $.ajax({
            type: 'DELETE',
            url: url,
        })
        .done(function(data) {
            gridPatternHandler.list();
        });
    },

    edit: function(id){
        var url = Routing.generate('pattern_form', { id : id});
        $.ajax({
            type: 'GET',
            url: url,
        })
        .done(function(data) {
            modalHandler.createModale("patterns", "pattern_edit", data);
        });
    },

    displayCreateForm: function(){
        var url = Routing.generate('pattern_create_form');
        $.ajax({
            type: 'GET',
            url: url,
        })
        .done(function(data) {
            modalHandler.createModale("patterns", "pattern_create", data);
        });
    },

    create: function(){
        var formId = "gridpattern";
        if(editor.isFormValid(formId)){
            $("#pattern-save-btn").attr("onclick", "");
            var url = Routing.generate('pattern_create');
            var data = $("#"+formId).serializeArray();
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
            })
            .done(function() {
                gridPatternHandler.list();
            });
        }
    },

    addString: function(){
        var strings = $('#strings');
        var string = strings.data('prototype');
        var length = $(".list-group-item.string").length;
        string = string.replace(/__name__/g, length);
        strings.append(string);
    },

    removeString: function(btn){
        btn.closest('li').remove();
    },

    save: function(){
        var formId = "gridpattern";
        if(editor.isFormValid(formId)){
            $("#pattern-save-btn").attr("onclick", "");
            var url = Routing.generate('pattern_save', {id: $('#pattern-id').val()});
            var data = $("#"+formId).serializeArray();
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
            })
            .done(function() {
                gridPatternHandler.list();
            });
        }
    },

    use: function(btn){
        var strings = btn.getAttribute("data-strings");
        var strings = strings.split(",");

        var time = 1000;
        var generator = Generator();
        var best = new generator(4, strings, time).run();

        var x = 0;
        for (var i = best.grid.length - 1; i >= 0; i--) {
            for (var j = best.grid[i].length - 1; j >= 0; j--) {
                $("#square-"+x).val(best.grid[i][j]);
                x++;
            };
        };
    }
};
