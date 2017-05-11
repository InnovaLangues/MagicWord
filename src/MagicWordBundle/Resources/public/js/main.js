$(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover()
})

$('.please-wait').on("click",function(){
    var msg = $(this).data('message');
    wait.start(msg);
})

var sorter = {
    sort: function(criteria, btn, container, element){
        var toSort = $(element);
        var order = btn.getAttribute("data-order");
        var asc = (order == "asc") ? true : false;
        btn.setAttribute("data-order", asc ? "desc" : "asc" );
        toSort.sort(function(a, b) {
            return $(a).data(criteria) < $(b).data(criteria) ? asc ? 1 : -1 : asc ? -1 : 1;
        });
        $(container).html(toSort);
    }
}

var deviceSize = {
    get: function(){
        return $('#users-device-size').find('div:visible').first().attr('id');
    }
}
