function RadioList(name)
{
    this.name = name;
    this.events = {};
    this.init();
}
RadioList.prototype = {
    name:null,
    events:{},
    init:function()
    {
        $('input[name='+this.name+']').on('change',function(){
            var params = {
                value:$('input[name='+this.name+']:checked').val(),
                text:$('input[name='+this.name+']:checked').next().text(),
            };
            this.fireEvent('change',params);                
        }.bind(this));
    },
    val:function()
    {
        return $('input[name='+this.name+']:checked').val();
    },
    on:function(eventName,func)
    {
        this.events[eventName] = func;
    },
    fireEvent:function(eventName,params)
    {
        if(typeof this.events[eventName]!="undefined")
        {
            this.events[eventName](params);
        }
    },
    reset: function() {
        var radios = document.querySelectorAll(
            'input[type="radio"][name="' + this.name + '"]');
        for (var i=0; i<radios.length; i+=1) {
            radios[i].checked = radios[i].defaultChecked;
        }
    }
};