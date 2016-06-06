var localstor = {
	foundKey: "found-"+roundJSON.id,

	init: function(){
        localStorage[this.foundKey] = "[]";
	},

    add: function(inflection){
        var found = this.get(this.foundKey);
        var ids = gridJSON.inflections[inflection.toLowerCase()].ids;
        for (var i = 0; i < ids.length; i++) {
            if($.inArray(ids[i],found) == -1 ){
                found.push(ids[i]);
            }
        }
        this.set(this.foundKey, found);

        return true;
    },

    get: function(key){
        return JSON.parse(localStorage[key]);
    },

    set: function(key, value){
        localStorage[key] = JSON.stringify(value);

        return true;
    }
}
