var KoolReport = KoolReport || {};
KoolReport.drilldown = KoolReport.drilldown || {};
KoolReport.drilldown.LegacyDrillDown = KoolReport.drilldown.LegacyDrillDown || 
function DrillDown(name,options)
{
    this.name = name;
    this.options = options;
    this.init();
}
KoolReport.drilldown.LegacyDrillDown.prototype = {
    name:null,
    options:null,
    level:null,
    titles:null,
    events:null,
    init:function()
    {
        this.level = 0;
        this.titles = [];
        this.events = {};
        for(var i=0;i<this.options.totalLevels;i++)
        {
            this.titles.push(null);
        }
        $('#'+this.name+' .btnBack').attr('disabled','disabled');
    },
    next:function(params)
    {
        if(this.level<this.options.totalLevels-1)
        {
            var _data = {};
            _data[this.name] = {
                partialRender:true,
                currentLevel:[this.level+1,params],
                scope:this.options.scope,
            };

            if(this.fireEvent("nexting",_data))
            {
                this.renderLoading();
                $.ajax({
                    method:"POST",
                    data:_data,
                }).done(function(content){
                    this.level++;
                    var start_mark = "<drilldown-partial>";
                    var end_mark = "</drilldown-partial>";
                    content = content.substring(content.indexOf(start_mark)+start_mark.length,content.indexOf(end_mark));
                    $('#'+this.name+' .legacy-drilldown-level').hide();
                    $('#'+this.name+' .legacy-drilldown-level-'+this.level).show().html(content);
                    $('#'+this.name+' .btnBack').attr('disabled',(this.level>0)?false:'disabled');
                    this.fireEvent("nexted",{level:this.level});
                    this.fireEvent("changed",{level:this.level});
                }.bind(this)).fail(function(e){
                    console.log(e);
                    this.renderLevelTitles();
                }.bind(this));    
            }

        }
    },
    levelTitle:function(title,level)
    {
        if(typeof level== 'undefined')
        {
            level = this.level;
        }
        this.titles[level] = title;
        this.renderLevelTitles();
    },
    renderLevelTitles:function()
    {
        $('#'+this.name+' .breadcrumb').empty();
        for(var i=0;i<this.level;i++)
        {
            $('#'+this.name+' .breadcrumb').append("<li class='breadcrumb-item'><a href='javascript:"+this.name+".back("+i+")'>"+this.titles[i]+"</a></li>");
        }
        $('#'+this.name+' .breadcrumb').append("<li class='breadcrumb-item'><span class='legacy-drilldown-clevel-title'>"+this.titles[this.level]+"</span></li>")
    },
    renderLoading:function()
    {
        $('#'+this.name+' .breadcrumb').append($("<li class='breadcrumb-item'><i class='fa fa-spinner fa-spin'></i></li>"));
    },
    back:function(level)
    {
        if(typeof level== 'undefined')
        {
            level = this.level-1;
        }
        if(level>=0 && level<this.level)
        {
            if(this.fireEvent("backing",{level:level}))
            {
                $('#'+this.name+' .legacy-drilldown-level-'+this.level).hide();
                $('#'+this.name+' .legacy-drilldown-level-'+level).show();
                this.level = level;
                $('#'+this.name+' .btnBack').attr('disabled',(this.level>0)?false:'disabled');
                this.renderLevelTitles();
                this.redrawLevelWidgets();
                this.fireEvent("backed",{level:level});
                this.fireEvent("changed",{level:this.level});
            }
        }        
    },
    redrawLevelWidgets:function()
    {
        //Redraw any widgets which has redraw() function.
        $('#'+this.name+' .legacy-drilldown-level-'+this.level+' [id]').each(function(i,el){
            
            if(typeof window[el.id] != 'undefined' && typeof window[el.id].redraw != 'undefined')
            {
                window[el.id].redraw();
            }
        });
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
};  
