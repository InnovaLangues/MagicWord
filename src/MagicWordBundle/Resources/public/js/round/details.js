var details = {
    modalSelector: '',
    get: function(id){
        var url = Routing.generate('activity_display', {
            activityId: id
        });
        $.ajax({
              type: 'GET',
              url: url,
          })
          .done(function(data) {
              $("#round-details-modal .details").html(data);
              $("#round-details-modal").modal('show');
          });
    },

}
