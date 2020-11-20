var KoolReport = KoolReport || {};
KoolReport.drilldown = KoolReport.drilldown || {};
KoolReport.drilldown.CustomDrillDown = KoolReport.drilldown.CustomDrillDown || 
function CustomDrillDown(name,options)
{
    this.name = name;
    this.options = options;
    $("#"+this.name+" .btnBack").attr('disabled','disabled');
    this.events = {};
    this.titles = [];
    for(var i=0;i<this.options.subReports.length;i++)
    {
        this.titles.push(null);
    }
    this.levelTitle($("sub-report#"+this.options.subReports[this.reportIndex] +" level-title").text());
}
KoolReport.drilldown.CustomDrillDown.prototype = {
    name:null,
    options:null,
    reportIndex:0,
    titles:null,
    events:null,
    copyObject:function(obj)
    {
        var newObj = {};
        for(var i in obj)
        {
            newObj[i] = obj[i];
        }
        return newObj;
    },
    assign:function(target, varArgs) { // .length of function is 2
        'use strict';
        if (target == null) { // TypeError if undefined or null
            target = {};
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
    },
    next:function(params)
    {
        var total = this.options.subReports.length;
        var dataSent = this.assign(this.copyObject(this.options.scope),params);
        

        if(this.reportIndex<total-1)
        {
            dataSent["@subReport"] = this.options.subReports[this.reportIndex+1];
            dataSent["@drilldown"] = this.name;    
            if(this.fireEvent("nexting",dataSent))
            {
                this.renderLoading();
                $.ajax({
                    method:"POST",
                    data:dataSent,
                    async:true,
                }).done(function(content){
                    this.reportIndex++;
                    var start_mark = "<subreport-partial>";
                    var end_mark = "</subreport-partial>";
                    content = content.substring(content.indexOf(start_mark)+start_mark.length,content.indexOf(end_mark));
                    $('#'+this.name+' .btnBack').attr('disabled',(this.reportIndex>0)?false:'disabled');
                    $("sub-report#"+this.options.subReports[this.reportIndex-1]).hide();
                    $("sub-report#"+this.options.subReports[this.reportIndex]).show().html(content);
                    this.levelTitle($("sub-report#"+this.options.subReports[this.reportIndex] +" level-title").text());
                    this.fireEvent("nexted",{level:this.reportIndex});
                    this.fireEvent("changed",{level:this.reportIndex});
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
            level = this.reportIndex-1;
        }
        if(level>=0 && level<this.reportIndex)
        {
            this.fireEvent("backing",{level:level})
            {
                this.reportIndex = level;
                for(var i=0;i<this.options.subReports.length;i++)
                {
                    if(i==this.reportIndex)
                    {
                        $("sub-report#"+this.options.subReports[i]).show();
                    }
                    else
                    {
                        $("sub-report#"+this.options.subReports[i]).hide();
                    }
                }
                this.redrawLevelWidgets();
                $('#'+this.name+' .btnBack').attr('disabled',(this.reportIndex>0)?false:'disabled');
                this.renderLevelTitles();
                this.fireEvent("backed",{level:this.reportIndex});
                this.fireEvent("changed",{level:this.reportIndex});                        
            }            
        }
    },
    redrawLevelWidgets:function()
    {
        //Redraw any widgets which has redraw() function.
        $("sub-report#"+this.options.subReports[this.reportIndex]+' [id]').each(function(i,el){
            
            if(typeof window[el.id] != 'undefined' && typeof window[el.id].redraw != 'undefined')
            {
                window[el.id].redraw();
            }
        });
    },
    levelTitle:function(title,level)
    {
        
        if(typeof level== 'undefined')
        {
            level = this.reportIndex;
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
        for(var i=0;i<this.reportIndex;i++)
        {
            $('#'+this.name+' .breadcrumb').append("<li class='breadcrumb-item'><a href='javascript:"+this.name+".back("+i+")'>"+this.titles[i]+"</a></li>");
        }
        $('#'+this.name+' .breadcrumb').append("<li class='breadcrumb-item'><span class='custom-drilldown-clevel-title'>"+this.titles[this.reportIndex]+"</span></li>")
    },
    renderLoading:function()
    {
        $('#'+this.name+' .breadcrumb').append($("<li class='breadcrumb-item'><i class='fa fa-spinner fa-spin'></i></li>"));
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
