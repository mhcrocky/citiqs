function CheckBoxList(name)
{
    this.name = name;
    this.events = {};
    this.init();
}
CheckBoxList.prototype = {
    name:null,
    events:{},
    init:function()
    {
        $('input[aName='+this.name+']').on('change',function(){
            $('input[name=__'+this.name+']').val(JSON.stringify(this.val()));
            this.fireEvent('change',{value:this.val()});                
        }.bind(this));
    },
    val:function()
    {
        var value = [];
        $('input[aName='+this.name+']:checked').each(function(){
            value.push($(this).val());
        });
        return value;
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
        var checkboxes = document.querySelectorAll(
            'input[type="checkbox"][name="' + this.name + '[]"]');
        for (var i=0; i<checkboxes.length; i+=1) {
            checkboxes[i].checked = checkboxes[i].defaultChecked;
        }
    }
};
