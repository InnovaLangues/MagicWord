var wait = {
    start: function(message){
        $('#please-wait-message').html(message);
        $('#please-wait').modal('show');
    },

    stop: function(){
        $('#please-wait').modal('hide');
    }
}
