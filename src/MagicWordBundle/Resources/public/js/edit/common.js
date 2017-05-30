var editor = {
    isFormValid: function(formId){
        return document.getElementById(formId).checkValidity();
    },
    saveAll: function(){
        gridHandler.autofill();
        objectives.save(gridHandler.save);
    }
}
