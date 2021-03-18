/* globals Chart:false, feather:false */

(function () {
    'use strict'
  
    feather.replace()
  
    // Graphs
    var ctx = document.getElementById('user_watch_chart')
    var data_1 = document.getElementById('user_watch_1').innerHTML.trim()
    var data_2 = document.getElementById('user_watch_2').innerHTML.trim()
    var data_3 = document.getElementById('user_watch_3').innerHTML.trim()
    var data_4 = document.getElementById('user_watch_4').innerHTML.trim()
    var data_5 = document.getElementById('user_watch_5').innerHTML.trim()
    // eslint-disable-next-line no-unused-vars
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [{
            data: [data_1, data_2, data_3],
            backgroundColor: ['#ff6384','#36a2eb','#ffce56'],
            borderColor: '#ffffff',
            borderWidth: 2
        }],
        labels: [
            'n≦'.concat(data_5),data_5.concat('<n≦',data_4),'n≧'.concat(data_4)
        ]
      },
      options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.labels[tooltipItem.index] || '';
                    if (label) {
                        label +=': ';
                    }
                    label +=  data.datasets[0].data[tooltipItem.index] +'%';
                    return label;
                }
            }
        }
    }
    })


    // Graphs
    var ctx = document.getElementById('user_rate_chart')
    var data_1 = document.getElementById('user_rate_1').innerHTML.trim()
    var data_2 = document.getElementById('user_rate_2').innerHTML.trim()
    var data_3 = document.getElementById('user_rate_3').innerHTML.trim()
    var data_4 = document.getElementById('user_rate_4').innerHTML.trim()
    var data_5 = document.getElementById('user_rate_5').innerHTML.trim()
    // eslint-disable-next-line no-unused-vars
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [{
            data: [data_1, data_2, data_3],
            backgroundColor: ['#ff6384','#36a2eb','#ffce56'],
            borderColor: '#ffffff',
            borderWidth: 2
        }],
        labels: [
            'n≦'.concat(data_5),data_5.concat('<n≦',data_4),'n≧'.concat(data_4)
        ]
      },
      options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.labels[tooltipItem.index] || '';
                    if (label) {
                        label +=': ';
                    }
                    label +=  data.datasets[0].data[tooltipItem.index] +'%';
                    return label;
                }
            }
        }
    }
    })


    // Graphs
    var ctx = document.getElementById('user_tag_chart')
    var data_1 = document.getElementById('user_tag_1').innerHTML.trim()
    var data_2 = document.getElementById('user_tag_2').innerHTML.trim()
    var data_4 = document.getElementById('user_tag_4').innerHTML.trim()
    var data_5 = document.getElementById('user_tag_5').innerHTML.trim()
    // eslint-disable-next-line no-unused-vars
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [{
            data: [data_1, data_2],
            backgroundColor: ['#ff6384','#36a2eb'],
            borderColor: '#ffffff',
            borderWidth: 2
        }],
        labels: [
            data_4,data_5
        ]
      },
      options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.labels[tooltipItem.index] || '';
                    if (label) {
                        label +=': ';
                    }
                    label +=  data.datasets[0].data[tooltipItem.index] +'%';
                    return label;
                }
            }
        }
    }
    })




  })()
  