var constraints = {
    add: function(){
        var constraints = $('#constraints');
        var constraint = constraints.data('prototype');
        constraint = constraint.replace(/__name__/g, $(".constraint-objective").length);
        constraints.append(constraint);
    },
    checkAll: function(){
        $( "#constraints-tab select" ).each(function() {
            constraints.checkOne($(this));
        });
    },
    checkOne: function(constraint){
        var span = constraint.parent("span");
        if (constraint.val() != "") {
            span.addClass("notempty");
        } else{
            span.removeClass("notempty");
        }
    }
};

$( "#constraints-tab" ).on( "change", "select", function(){
    constraints.checkOne($(this));
});

$( "#constraints-tab" ).ready(function() {
    constraints.checkAll();
});
