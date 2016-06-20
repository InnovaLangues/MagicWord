$(function() {
    $('[data-toggle="tooltip"]').tooltip();
})


$('a.please-wait').on("click",function(){
    var msg = $(this).data('message');
    wait.start(msg);
})
