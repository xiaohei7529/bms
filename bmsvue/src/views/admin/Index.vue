<template>
    <div style="display: flex;">
        <div id="chart" style="width: 600px; height: 400px;"></div>
        <div id="chart1" style="width: 600px; height: 400px;"></div>
    </div>
  </template>
  
  <script>
//   import echarts from 'echarts'
  
  export default {
    name: 'Chart',
    mounted() {
      this.initChart()
    },
    methods: {
      initChart() {
        const chart = this.$echarts.init(document.getElementById('chart'))
  
        const option = {
          title: {
            text: 'ECharts 示例'
          },
          tooltip: {
            trigger: 'axis'
          },
          legend: {
            data: ['销量']
          },
          xAxis: {
            type: 'category',
            data: ['衬衫', '羊毛衫', '雪纺衫', '裤子', '高跟鞋', '袜子']
          },
          yAxis: {
            type: 'value'
          },
          series: [
            {
              name: '销量',
              type: 'bar',
              data: [5, 20, 36, 10, 10, 20]
            }
          ]
        }
  
        chart.setOption(option)


        var chartDom = document.getElementById('chart1');
        var myChart = this.$echarts.init(chartDom);
        var option1;

        option1 = {
        title: {
            text: 'Referer of a Website',
            subtext: 'Fake Data',
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            orient: 'vertical',
            left: 'left'
        },
        series: [
            {
            name: 'Access From',
            type: 'pie',
            radius: '50%',
            data: [
                { value: 1048, name: 'Search Engine' },
                { value: 735, name: 'Direct' },
                { value: 580, name: 'Email' },
                { value: 484, name: 'Union Ads' },
                { value: 300, name: 'Video Ads' }
            ],
            emphasis: {
                itemStyle: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
            }
        ]
        };

        option1 && myChart.setOption(option1);

      }
    }
  }
  </script>