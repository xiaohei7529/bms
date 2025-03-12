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
            text: '图书借阅统计表'
          },
          tooltip: {
            trigger: 'axis'
          },
          legend: {
            data: ['借阅量']
          },
          xAxis: {
            type: 'category',
            data: ['文学的魅力', '科学的未来', '历史的回响', '技术的变迁', '艺术的光辉', '经济学简史']
          },
          yAxis: {
            type: 'value'
          },
          series: [
            {
              name: '借阅量',
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
            text: '分类统计表',
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
                { value: 1048, name: '文学' },
                { value: 735, name: '科技' },
                { value: 580, name: '历史' },
                { value: 484, name: '艺术' },
                { value: 300, name: '哲学' }
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