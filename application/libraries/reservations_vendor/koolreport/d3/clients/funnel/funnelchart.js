var KoolReport = KoolReport || {};
KoolReport.d3 = KoolReport.d3 || {};
KoolReport.d3.FunnelChart = KoolReport.d3.FunnelChart ||
function (name,data,settings) {
    this.name = name;
    this.data = data;
    this.events = {};
    this.settings = settings;
    this.settings.events = {
        click:{
            block:this.onClick.bind(this)
        }
    };
    this.coreChart = new D3Funnel('#'+name);
    this.draw();
    window.addEventListener("resize",this.onResize.bind(this));
};

KoolReport.d3.FunnelChart.prototype = {
    coreChart: null,
    data:null,
    settings:null,
    name:null,
    events:null,
    core: function () {
      return this.coreChart;
    },
    draw (data, settings) {
        var d = data?data:this.data;
        var s = settings?settings:this.settings;
        this.coreChart.draw(d,s);
    },
    onResize:function() {
        this.draw();
    },
    onClick:function(d) {
        var selectedRow = [
            this.data[d.index].label,
            this.data[d.index].value,
        ];
        selectedRow[this.settings.cKeys[0]] = this.data[d.index].label;
        selectedRow[this.settings.cKeys[1]] = this.data[d.index].value;
        var params = {
            selectedRowIndex:d.index,
            selectedRatio:d.ratio,
            selectedValue:d.value,
            selectedLabel:d.label.raw,
            selectedRow:selectedRow,
        };
        this.fireEvent("itemSelect",params);
    },
    registerEvent:function(name,handler)
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
};