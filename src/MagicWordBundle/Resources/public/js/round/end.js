var sortFoundables = {

    sort: function(target, criteria, btn){
        var toSort = $("#"+target+" div.foundable");
        var order = btn.getAttribute("data-order");

        var asc = (order == "asc") ? true : false;

        btn.setAttribute("data-order", asc ? "desc" : "asc" );

        console.log(order);

        toSort.sort(function(a, b) {
            return $(a).data(criteria) < $(b).data(criteria) ? asc ? 1 : -1 : asc ? -1 : 1;
        });
        $("#"+target).html(toSort);
    }

}
