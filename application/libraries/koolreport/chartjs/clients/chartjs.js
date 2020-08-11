if(typeof ChartJS =="undefined")
{
    function ChartJS(name,settings)
    {
        var ctx = document.getElementById(name).getContext("2d");
        
        if(settings.type=="scatter")
        {
            var tooltips = settings.options.tooltips || {};
            tooltips.callbacks = tooltips.callbacks || {};
            if (! tooltips.callbacks.label) {
                tooltips.callbacks.label = function(item,data){
                    var piece = data.datasets[item.datasetIndex].data[item.index];
                    return "(x,y)".replace("x",piece.x).replace("y",piece.y);
                }
            };
            settings.options.tooltips = tooltips;
        }
        else if(settings.type=="bubble")
        {
            var tooltips = settings.options.tooltips || {};
            tooltips.callbacks = tooltips.callbacks || {};
            if (! tooltips.callbacks.label) {
                tooltips.callbacks.label = function(item,data){
                    var piece = data.datasets[item.datasetIndex].data[item.index];
                    return "(x,y,v)".replace("x",piece.x).replace("y",piece.y).replace("v",piece.v);
                }
            };
            settings.options.tooltips = tooltips;
        }
        else
        {
            var tooltips = settings.options.tooltips || {};
            tooltips.callbacks = tooltips.callbacks || {};
            if (! tooltips.callbacks.label) {
                tooltips.callbacks.label = function(item,data){
                    return data.datasets[item.datasetIndex].label+" : " + data.datasets[item.datasetIndex].fdata[item.index];
                };
            }
            settings.options.tooltips = tooltips;
        }
        settings.options.onClick = function(e,items)
        {
            var firstPoint = this.chart.getElementAtEvent(e)[0];
            if (firstPoint) {
                var index = firstPoint._index;
                var datasetIndex = firstPoint._datasetIndex;
                var selectedLabel = this.chart.data.labels[firstPoint._index];
                var selectedValue = this.chart.data.datasets[datasetIndex].data[index];
                var selectedRow = [selectedLabel];
                for(var j=0;j<this.chart.data.datasets.length;j++)
                {
                    selectedRow.push(this.chart.data.datasets[j].data[index]);    
                }
                this.cKeys.forEach(function(cKey,i){
                    if(typeof selectedRow[i]!= "undefined")
                    {
                        selectedRow[cKey] = selectedRow[i];
                    }
                });
                this.fireEvent("itemSelect",{
                    selectedLabel:selectedLabel,
                    selectedValue:selectedValue,
                    selectedRowIndex:index,
                    selectedColumnIndex:datasetIndex+1,
                    selectedRow:selectedRow,
                });            
            }
        }.bind(this);
    
    
        if(settings.type=="polar")
        {
            this.chart = new Chart.PolarArea(ctx,settings);
        }
        else if(settings.type=="scatter")
        {
            settings.type="bubble";
            this.chart = new Chart(ctx,settings);
        }
        else
        {
            if(settings.type=="bubble")
            {
                settings.options.elements = settings.options.elements||{};
                settings.options.elements.point = settings.options.elements.point||{};
                settings.options.elements.point.radius = function(context)
                {
                    var value = context.dataset.data[context.dataIndex];
                    var size = context.chart.width;
                    var base = Math.abs(value.v) * value.s/100;
                    return (size / 24) * base;
                }
            }
            
            this.chart = new Chart(ctx,settings);
        }
        this.events = {};
        this.cKeys = settings.cKeys;
    }
    ChartJS.prototype = {
        chart:null,
        events:null,
        cKeys:null,
        on:function(name,handler)
        {
            if(typeof this.events[name]=='undefined')
            {
                this.events[name] = [];
            }
            this.events[name].push(handler);
        },
        fireEvent:function(name,params)
        {
            if(typeof this.events[name]!='undefined')
            {
                for(var i in this.events[name])
                {
                    this.events[name][i](params);
                }
            }
        }
    }
}