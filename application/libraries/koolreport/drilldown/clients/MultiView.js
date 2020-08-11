var KoolReport = KoolReport || {};
KoolReport.drilldown = KoolReport.drilldown || {};
KoolReport.drilldown.MultiView = KoolReport.drilldown.MultiView || 
function MultiView(name,settings)
{
    this.name = name;
    this.settings = settings,
    this.viewIndex = this.settings.viewIndex;
    this.events = {};
    this.init();
}
KoolReport.drilldown.MultiView.prototype = {
    name:null,
    settings:null,
    viewIndex:0,
    events:null,
    init:function()
    {
        $('#'+this.name+' .multiview-handler').on('click',function(e){
            var index = $(e.currentTarget).attr("data-value");
            this.changeView(index);
        }.bind(this));
    },
    changeView:function(index)
    {
        if(index>=this.settings.totalViews)
        {
            index = this.settings.totalViews-1;
        }
        if(index!=this.viewIndex)
        {
            if(this.fireEvent("changing",{
                index:index,
                fromIndex:this.viewIndex
            }))
            {
                $('#'+this.name+' .multiview-widget-'+this.viewIndex).hide();
                $('#'+this.name+' .multiview-widget-'+index).show();
                $('#'+this.name+' .multiview-handler-'+this.viewIndex).removeClass('active').removeClass('focus');
                $('#'+this.name+' .multiview-handler-'+index).addClass('active');
                this.viewIndex = index;
                this.redrawWidget(this.viewIndex);
                this.fireEvent("changed",{
                    index:this.viewIndex,
                });                    
            }
        }
    },
    redrawWidget:function(index)
    {
        if(window[this.settings.widgetNames[index]] && window[this.settings.widgetNames[index]].redraw)
        {
            window[this.settings.widgetNames[index]].redraw();
        }
    },
    on:function(name,func){
        if(typeof this.events[name] == "undefined")
        {
            this.events[name] = [];
        }
        this.events[name].push(func);
    },
    fireEvent:function(name,params)
    {
        if(typeof this.events[name] !="undefined")
        {
            for(var i in this.events[name])
            {
                if(this.events[name][i](params)==false)
                {
                    return false;
                }
            }
        }
        return true;
    }        
}