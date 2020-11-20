var _linkedpicker = {
    callbacks:{},
    values:{},
    register:function(name,callback)
    {
        if(!_linkedpicker.callbacks[name])
        {
            _linkedpicker.callbacks[name] = [];
        }
        _linkedpicker.callbacks[name].push(callback);
        if(_linkedpicker.values[name])
        {
            callback(_linkedpicker.values[name]);
        }
    },
    fire:function(name,date)
    {
        _linkedpicker.values[name] = date;
        if(_linkedpicker.callbacks[name])
        {
            _linkedpicker.callbacks[name].map(function(callback){
                callback(date);
            });
        }
    }
}