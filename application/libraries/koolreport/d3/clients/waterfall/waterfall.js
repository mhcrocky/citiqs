var KoolReport = KoolReport || {};
KoolReport.d3 = KoolReport.d3 || {};
KoolReport.d3.Waterfall = KoolReport.d3.Waterfall ||
    function (name, settings) {
        this.name = name;
        this.settings = settings;
        this.events = {};
        window.addEventListener("resize", this.onResize.bind(this));
    };

KoolReport.d3.Waterfall.prototype = {
    settings: null,
    name: null,
    events:null,
    draw: function () {
        const settings = this.settings;
        const boundRect = d3.select("#" + this.name).node().getBoundingClientRect();
        const margin = settings.margin;

        const width = boundRect.width - margin.left - margin.right;
        const height = boundRect.height - margin.top - margin.bottom;
        const padding = 0.3;

        const x = d3
            .scaleBand()
            .rangeRound([0, width])
            .padding(padding);

        const y = d3
            .scaleLinear()
            .range([height, 0]);

        const xAxis = d3.axisBottom(x);

        const yAxis = d3
            .axisLeft(y)
            .tickFormat((settings.yAxis && settings.yAxis.format) ? settings.yAxis.format : function (d) {
                return d;
            });

        d3.selectAll('#' + this.name + '>svg').remove();
        const chart = d3
            .select('#' + this.name).append("svg")
            .attr('width', width + margin.left + margin.right)
            .attr('height', height + margin.top + margin.bottom)
            .append('g')
            .attr('transform', `translate(${margin.left},${margin.top})`);

        const drawWaterfall = (data) => {
            x.domain(data.map(function (d) {
                return d.name;
            }));

            var min = d3.min(data, function (d) {
                return d.end;
            });
            var max = d3.max(data, function (d) {
                return d.end;
            });

            var extra = (max - min) * 0.1;

            y.domain([min < 0 ? min - extra : min, max + extra]);

            chart
                .append('g')
                .attr('class', 'x axis')
                .attr('transform', `translate(0,${height})`)
                .call(xAxis);

            chart
                .append('g')
                .attr('class', 'y axis')
                .call(yAxis);

            if (settings.title) {
                chart
                    .append('text')
                    .attr('class','title')
                    .attr('x',0)
                    .attr('y',-20)
                    .text(settings.title);
            }

            const bar = chart.selectAll('.bar')
                .data(data)
                .enter().append('g')
                .attr('class', (d) => {
                    return `bar ${d.class}`;
                })
                .attr('transform', (d) => {
                    return `translate(${x(d.name)},0)`;
                });

            bar
                .append('rect')
                .attr('style', function (d) {
                    if (d.class === 'total') {
                        return "fill:" + ((d.start > d.end) ? settings.colors[2] : settings.colors[3]);
                    }
                    else {
                        return "fill:" + ((d.start < d.end) ? settings.colors[0] : settings.colors[1]);
                    }
                })
                .attr('y', function (d) {
                    return y(Math.max(d.start, d.end));
                })
                .attr('height', function (d) {
                    return Math.abs(y(d.start) - y(d.end));
                })
                .attr('width', x.bandwidth())
                .on("click",this.onClick.bind(this));

            // Add the value on each bar
            bar
                .append('text')
                .attr('x', x.bandwidth() / 2)
                .attr('y', function (d) {
                    return (d.end > d.start) ? y(d.end) : y(d.start);
                })
                .attr('dy', '-.5em')
                .text(function (d) {
                    return d.class === 'total' ? settings.label.format(d.start - d.end) : settings.label.format(d.end - d.start);
                })
                .style('fill', 'black');

            // bar
            //     .filter((d, i) => {
            //         // filter out first bar and total bars
            //         return (d.class !== 'total' && i !== 0);
            //     })
            //     .append('ellipse')
            //     .attr('class', 'bubble')
            //     .attr('class', 'ellipse')
            //     .attr('cx', x.bandwidth() / 2)
            //     .attr('cy', (0 - margin.top) / 2)
            //     .attr('rx', 30)
            //     .attr('ry', '1em');

            // bar
            //     .filter((d, i) => {
            //         // filter out first bar and total bars
            //         return (d.class !== 'total' && i !== 0);
            //     })
            //     .append('text')
            //     .attr('x', x.bandwidth() / 2)
            //     .attr('y', (0 - margin.top) / 2)
            //     .attr('dy', '.3em')
            //     .attr('class', 'bubble')
            //     .text((d) => {
            //         const percentage = d3.format('.1f')(((100 * (d.end - d.start)) / d.start));
            //         return `${percentage}%`;
            //     });

            // Add the connecting line between each bar
            bar
                .filter(function (d, i) {
                    return i !== data.length - 1;
                })
                .append('line')
                .attr('class', 'connector')
                .attr('x1', x.bandwidth() + 5)
                .attr('y1', function (d) {
                    return d.class === 'total' ? y(d.start) : y(d.end);
                })
                .attr('x2', (x.bandwidth() / (1 - padding)) - 5)
                .attr('y2', function (d) {
                    return d.class === 'total' ? y(d.start) : y(d.end);
                });
        }; // drawWaterfall

        var data = [];
        for (var i = 0; i < settings.data.length; i++) {
            data.push(settings.data[i]);
        }
        var data = this.prepData(data, settings.summary);
        drawWaterfall(data);
    },
    prepData: function (data, summary) {
        // create stacked remainder
        const insertStackedRemainderAfter = (dataName, newDataName) => {
            const index = data.findIndex(function (datum) {
                return datum.name === dataName;
            }); // data.findIndex

            return data.splice(index + 1, 0, {
                name: newDataName,
                start: data[index].end,
                end: 0,
                class: 'total',
            }); // data.splice
        }; // insertStackedRemainder

        // retrieve total value
        let cumulative = 0;

        // Transform data (i.e., finding cumulative values and total) for easier charting
        data.map(function (datum) {
            datum.start = cumulative;
            cumulative += datum.value;
            datum.end = cumulative;
            return datum.class = datum.value >= 0 ? 'positive' : 'negative';
        }); // data.map

        for (var i = 0; i < summary.length; i++) {
            if (summary[i][1] === "end") {
                data.push({
                    name: summary[i][0],
                    start: data[data.length - 1].end,
                    end: 0,
                    class: 'total',
                });
            }
            else if (summary[i][1] < data.length) {
                data.splice(summary[i][1], 0, {
                    name: summary[i][0],
                    start: data[summary[i][1] - 1].end,
                    end: 0,
                    class: 'total',
                }); // data.splice    
            }

        }
        return data;
    },
    onResize: function () {
        this.draw();
    },
    onClick:function(d,index) {

        var params = null;
        if(d.class=="total") {
            params = {
                selectedRowIndex:null,
                selectedName:d.name,
                selectedValue:d.start,
                selectedRow:null,
                isSummaryColumn:true,
            };
        } else {
            selectedRowIndex = index;
            this.settings.summary.forEach(function(v){
                if(v[1]!=="end" && v[1]<index) {
                    selectedRowIndex--;
                }
            });
            var selectedRow = [
                this.settings.data[selectedRowIndex].name,
                this.settings.data[selectedRowIndex].value,
            ];
            selectedRow[this.settings.cKeys[0]] = this.settings.data[selectedRowIndex].name;
            selectedRow[this.settings.cKeys[1]] = this.settings.data[selectedRowIndex].value;    
            params = {
                selectedRowIndex:selectedRowIndex,
                selectedName:d.name,
                selectedValue:d.value,
                selectedRow:selectedRow,
                isSummaryColumn:false,
            };    
        }


        
        
        this.fireEvent("itemSelect",params);
    },
    registerEvent:function(name, handler)
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