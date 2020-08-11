var KoolReport = KoolReport || {};
KoolReport.drilldown = KoolReport.drilldown || {};
KoolReport.drilldown.DrillDown = KoolReport.drilldown.DrillDown || 
function DrillDown(name,options)
{
    this.name = name;
    this.options = options;
    this.params = [];
    this.titles = [];
    this.levelIndex = 0;
    this.events = {};
    this.init();
}
KoolReport.drilldown.DrillDown.prototype = {
    name:null,
    options:null,
    params:null,
    titles:null,
    levelIndex:null,
    events:null,
    init:function()
    {
        $('#'+this.name+' .btnBack').attr('disabled','disabled');
        this.levelTitle($('#'+this.name+' .drilldown-level-'+this.levelIndex+' level-title').text());
    },
    levelTitle:function(title,level)
    {
        
        if(typeof level== 'undefined')
        {
            level = this.levelIndex;
        }
        if(title==null||title=="")
        {
            title = "Level "+level;
        }
        this.titles[level] = title;
        this.renderLevelTitles();
    },
    renderLevelTitles:function()
    {
        $('#'+this.name+' .breadcrumb').empty();
        for(var i=0;i<this.levelIndex;i++)
        {
            $('#'+this.name+' .breadcrumb').append("<li class='breadcrumb-item'><a href='javascript:"+this.name+".back("+i+")'>"+this.titles[i]+"</a></li>");
        }
        $('#'+this.name+' .breadcrumb').append("<li class='breadcrumb-item'><span class='drilldown-clevel-title'>"+this.titles[this.levelIndex]+"</span></li>")
    },
    renderLoading:function()
    {
        $('#'+this.name+' .breadcrumb').append($("<li class='breadcrumb-item'><i class='fa fa-spinner fa-spin'></i></li>"));
    },
    next:function(_addedParams)
    {
        if(this.levelIndex<this.options.totalLevels-1)
        {
            var params = {};
            for(var i in this.params[this.levelIndex])
            {
                params[i] = this.params[this.levelIndex][i];
            }
            for(var i in _addedParams)
            {
                params[i] = _addedParams[i];
            }
            var data = {};
            data[this.name] ={
                currentLevel:[this.levelIndex+1,params],
                scope:this.scope,
                partialRender:1,
            };
            if(this.fireEvent("nexting",data))
            {
                this.renderLoading();
                $.ajax({
                    method:"POST",
                    data:data,
                    async:true,
                }).done(function(content){
                    this.levelIndex++;
                    this.params[this.levelIndex] = params;
                    var start_mark = "<drilldown-partial>";
                    var end_mark = "</drilldown-partial>";
                    content = content.substring(content.indexOf(start_mark)+start_mark.length,content.indexOf(end_mark));
                    $('#'+this.name+' .drilldown-level').hide()
                    $('#'+this.name+' .drilldown-level-'+this.levelIndex).show().html(content);
                    $('#'+this.name+' .btnBack').attr('disabled',(this.levelIndex>0)?false:'disabled');
                    this.levelTitle($('#'+this.name+' .drilldown-level-'+this.levelIndex+' level-title').text(),this.levelIndex);
                    this.fireEvent("nexted",{level:this.levelIndex});
                    this.fireEvent("changed",{level:this.levelIndex});
                }.bind(this)).fail(function(e){
                    console.log(e);
                    this.renderLevelTitles();
                }.bind(this));  
            }    
        }
    },
    back:function(level)
    {
        if(typeof level== 'undefined')
        {
            level = this.levelIndex-1;
        }
        if(level>=0 && level<this.levelIndex)
        {
            if(this.fireEvent("backing",{level:level}))
            {
                $('#'+this.name+' .drilldown-level-'+this.levelIndex).hide();
                $('#'+this.name+' .drilldown-level-'+level).show();
                $('#'+this.name+' .btnBack').attr('disabled',(level>0)?false:'disabled');
                this.levelIndex = level;
                this.renderLevelTitles();

                this.redrawLevelWidgets();
                this.fireEvent("backed",{level:level});
                this.fireEvent("changed",{level:level});
            }
        }
    },
    redrawLevelWidgets:function()
    {
        //Redraw any widgets which has redraw() function.
        $('#'+this.name+' .drilldown-level-'+this.levelIndex+' [id]').each(function(i,el){
            
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