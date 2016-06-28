$(function() {
    $('[data-toggle="tooltip"]').tooltip();
})

$('.please-wait').on("click",function(){
    var msg = $(this).data('message');
    wait.start(msg);
})
