<!DOCTYPE html>
<meta charset="utf-8">
<style>
body {
  font-family: sans-serif;
  font-size: 12px;
  font-weight: 400;
}

.bar.total rect {
  fill: steelblue;
}

.bar.positive rect {
  fill: darkolivegreen;
}
.bar.negative rect {
  fill: crimson;
}

.bar line.connector {
  stroke: grey;
  stroke-dasharray: 3;
}

.bar text {
  text-anchor: middle;
}

.axis text {
  font: 10px sans-serif;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

div.tooltip {
  position: absolute;
  text-align: center;
  width: 60px;
  height: 16px;
  padding: 2px;
  font: 15px sans-serif;
  background: lightgrey;
  border: 0px;
  border-radius: 8px;
  pointer-events: none;
}

.bubble {
  font-weight: bold;
}

.ellipse {
  fill:none;
  stroke:black;
  stroke-width:2;
}
</style>

<body>
<svg class="chart"></svg>
    <script src="/Reporting/koolreport/d3/clients/d3/d3.v5.min.js"></script>
<script>
const margin = { top: 80, right: 30, bottom: 30, left: 50 };
const width = 960 - margin.left - margin.right;
const height = 500 - margin.top - margin.bottom;
const padding = 0.3;

const x = d3
  .scaleBand()
  .rangeRound([ 0, width ])
  .padding(padding);

const y = d3
  .scaleLinear()
  .range([ height, 0 ]);

const xAxis = d3.axisBottom(x);

const yAxis = d3
  .axisLeft(y)
  .tickFormat((d) => {
    return d;
  });

const chart = d3
  .select('.chart')
  .attr('width', width + margin.left + margin.right)
  .attr('height', height + margin.top + margin.bottom)
  .append('g')
  .attr('transform', `translate(${ margin.left },${ margin.top })`);

const type = (d) => {
  d.value = +d.value;
  return d;
}; // type

const eurFormat = (amount) => {
  if (Math.abs(amount) > 1000000) {
    return `${ Math.round(amount / 1000000) }M€`;
  }
  if (Math.abs(amount) > 1000) {
    return `${ Math.round(amount / 1000) }K€`;
  }
  return `${ amount }€`;
}; // eurFormat

const drawWaterfall = (data) => {
  x.domain(data.map((d) => {
    return d.name;
  }));

  y.domain([
    0,
    d3.max(data, (d) => {
      return d.end;
    })
  ]);

  chart
    .append('g')
    .attr('class', 'x axis')
    .attr('transform', `translate(0,${ height })`)
    .call(xAxis);

  chart
    .append('g')
    .attr('class', 'y axis')
    .call(yAxis);

  const bar = chart.selectAll('.bar')
    .data(data)
    .enter().append('g')
    .attr('class', (d) => {
      return `bar ${ d.class }`;
    })
    .attr('transform', (d) => {
      return `translate(${ x(d.name) },0)`;
    });

  bar
    .append('rect')
    .attr('y', (d) => {
      return y(Math.max(d.start, d.end));
    })
    .attr('height', (d) => {
      return Math.abs(y(d.start) - y(d.end));
    })
    .attr('width', x.bandwidth());

  // Add the value on each bar
  bar
    .append('text')
    .attr('x', x.bandwidth() / 2)
    .attr('y', (d) => {
      return d.class === 'positive' ? y(d.end) : y(d.start);
    })
    .attr('dy', '-.5em')
    .text((d) => {
      return d.class === 'total' ? eurFormat(d.start - d.end) : eurFormat(d.end - d.start);
    })
    .style('fill', 'black');

  bar
    .filter((d, i) => {
      // filter out first bar and total bars
      return (d.class !== 'total' && i !== 0);
    })
    .append('ellipse')
    .attr('class', 'bubble')
    .attr('class', 'ellipse')
    .attr('cx', x.bandwidth() / 2)
    .attr('cy', (0 - margin.top) / 2)
    .attr('rx', 30)
    .attr('ry', '1em');

  bar
    .filter((d, i) => {
      // filter out first bar and total bars
      return (d.class !== 'total' && i !== 0);
    })
    .append('text')
    .attr('x', x.bandwidth() / 2)
    .attr('y', (0 - margin.top) / 2)
    .attr('dy', '.3em')
    .attr('class', 'bubble')
    .text((d) => {
      const percentage = d3.format('.1f')(((100 * (d.end - d.start)) / d.start));
      return `${ percentage }%`;
    });

  // Add the connecting line between each bar
  bar
    .filter((d, i) => {
      return i !== data.length - 1;
    })
    .append('line')
    .attr('class', 'connector')
    .attr('x1', x.bandwidth() + 5)
    .attr('y1', (d) => {
      return d.class === 'total' ? y(d.start) : y(d.end);
    })
    .attr('x2', (x.bandwidth() / (1 - padding)) - 5)
    .attr('y2', (d) => {
      return d.class === 'total' ? y(d.start) : y(d.end);
    });
}; // drawWaterfall

const prepData = (data) => {
  // create stacked remainder
  const insertStackedRemainderAfter = (dataName, newDataName) => {
    const index = data.findIndex((datum) => {
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
  data.map((datum) => {
    datum.start = cumulative;
    cumulative += datum.value;
    datum.end = cumulative;
    return datum.class = datum.value >= 0 ? 'positive' : 'negative';
  }); // data.map

  // insert stacked remainders where approriate
  insertStackedRemainderAfter('3rd revenue', 'intermediate total');
  insertStackedRemainderAfter('4th revenue', 'final total');

  return drawWaterfall(data);
}; // prepData


prepData([
  {name:"1st revenu",value:6000000},
  {name:"2nd revenue",value:2000000},
  {name:"1st spend",value:-3000000},
  {name:"3rd revenue",value:4000000},
  {name:"2nd spend",value:5500000},
  {name:"4th revenue",value:800000}
]);
</script>