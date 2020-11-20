var KoolReport = KoolReport || {};
KoolReport.d3 = KoolReport.d3 || {};
KoolReport.d3.C3Chart = KoolReport.d3.C3Chart ||
function (settings) {
    settings.data.onclick = this.onClick.bind(this);
    this.settings = settings;
    this.events = {};
    this.c3chart = c3.generate(settings);
};

KoolReport.d3.C3Chart.prototype = {
    settings: null,
    c3chart: null,
    events:null,
    chart: function () {
      return this.c3chart;
    },
    onClick:function(d,element){
      var params = {};

      // console.log(d);
      // return;
      switch(this.settings.data.type)
      {
        case "scatter":
          var selectedRow = [
            d.x,d.value
          ];
          for(var i in this.settings.cKeys)
          {
            selectedRow[this.settings.cKeys[i]] = (i==0)?d.x:d.value;
          }
          params = {
            selectedX:d.x,
            selectedY:d.value,
            selectedRow:selectedRow,
          };
          break;
        case "gauge":
        case "pie":
        case "donut":
          var selectedRow = this.settings.data.columns[d.index];
          for(var i in this.settings.cKeys)
          {
            selectedRow[this.settings.cKeys[i]] = this.settings.data.columns[d.index][i];
          }
          params = {
            selectedRowIndex:d.index,
            selectedValue:d.value,
            selectedRatio:d.ratio,
            selectedRow:selectedRow,
          };
          break;
        default:
          var selectedRow = [];
          // console.log(this.settings.cKeys);
          this.settings.cKeys.forEach(function(v,i){
            selectedRow.push(this.settings.data.json[d.index][v]);
            selectedRow[v] = this.settings.data.json[d.index][v];
          }.bind(this));
          params = {
            selectedRowIndex:d.index,
            columnName:d.name,
            selectedValue:d.value,
            selectedRow:selectedRow,
          };
      }
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