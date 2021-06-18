

<?php $cou = count($tags); ?>
<div class="table-responsive mb-3">
        <div id="amountChart" style="height: <?php echo $cou * 150; ?>px;border:1px solid #ccc;padding:10px;"></div>
        <div id="soldTicketsChart" style="height: <?php echo $cou * 150; ?>px;border:1px solid #ccc;padding:10px;"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/2.2.7/echarts-all.js"></script>


<script>

(function(){
    const tags = JSON.parse('<?php echo json_encode($tags); ?>');
    if(tags.length > 0) return buildGraph(tags);
})();


function buildGraph(tags) {
    

const sold_tickets = JSON.parse('<?php echo json_encode($sold_tickets_graph); ?>');
const sold_amount = JSON.parse('<?php echo json_encode($sold_amount_graph); ?>');
const events = JSON.parse('<?php echo json_encode($events); ?>');




var amountChartDom = document.getElementById('amountChart');
var soldTicketsChartDom = document.getElementById('soldTicketsChart');
var amountChart = echarts.init(amountChartDom);
var soldTicketsChart = echarts.init(soldTicketsChartDom);
var amountOption;
var soldTicketsOption;

soldTicketsOption = {
    title: {
    text: 'Sold Tickets per tags',
    subtext: ''
  },
    tooltip: {
        trigger: 'axis',
        axisPointer: {            // Use axis to trigger tooltip
            type: 'shadow'        // 'shadow' as default; can also be 'line' or 'shadow'
        }
    },
    legend: {
        data: events
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis: {
        type: 'value',
        axisLabel: {
            formatter: "{value}"
        }
    },
    yAxis: {
        type: 'category',
        data: tags
    },
    series: sold_tickets
};

amountOption = {
    title: {
    text: 'Sold Amount per tags',
    subtext: ''
  },
    tooltip: {
        trigger: 'axis',
        axisPointer: {            // Use axis to trigger tooltip
            type: 'shadow'        // 'shadow' as default; can also be 'line' or 'shadow'
        }
    },
    legend: {
        data: events
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis: {
        type: 'value',
        axisLabel: {
            formatter: "€{value}.00"
        }
    },
    yAxis: {
        type: 'category',
        data: tags
    },
    series: sold_amount
};

amountChart.setOption(amountOption);
soldTicketsChart.setOption(soldTicketsOption);
}
</script>