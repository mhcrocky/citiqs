if(typeof CommonInput =="undefined")
{
    if (typeof Object.assign != 'function') {
        Object.assign = function(target, varArgs) { // .length of function is 2
          'use strict';
          if (target == null) { // TypeError if undefined or null
            throw new TypeError('Cannot convert undefined or null to object');
          }
      
          var to = Object(target);
      
          for (var index = 1; index < arguments.length; index++) {
            var nextSource = arguments[index];
      
            if (nextSource != null) { // Skip over if undefined or null
              for (var nextKey in nextSource) {
                // Avoid bugs when hasOwnProperty is shadowed
                if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
                  to[nextKey] = nextSource[nextKey];
                }
              }
            }
          }
          return to;
        };
    }    
    function CommonInput(name)
    {
        this.name = name;
        this.events = {};
        this.init();
    }
    CommonInput.prototype = {
        name:null,
        events:{},
        init:function(){},
        val:function()
        {
            return null;
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
    
    function RadioList(name)
    {
        CommonInput.call(this,name);
    }
    RadioList.prototype = Object.create(CommonInput.prototype);
    Object.assign(RadioList.prototype,{
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
        }
    });


    function CheckBoxList(name)
    {
        CommonInput.call(this,name);
    }
    CheckBoxList.prototype = Object.create(CommonInput.prototype);
    Object.assign(CheckBoxList.prototype,{
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
        reset: function() {
            var checkboxes = document.querySelectorAll(
                'input[type="checkbox"][name="' + this.name + '[]"]');
            for (var i=0; i<checkboxes.length; i+=1) {
                checkboxes[i].checked = checkboxes[i].defaultChecked;
            }
        }
    });
}