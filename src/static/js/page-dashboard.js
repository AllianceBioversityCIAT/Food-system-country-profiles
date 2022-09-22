jQuery( document ).ready( ( $ ) => {

  $( '.component-status' ).click( function () {
    $( '.component-status' ).removeClass( 'active' );
    $( this ).addClass( "active" );
  } );

  $( '.note-closed' ).click( function () {
    $( '.note-indicators' ).hide();
  } );

  // Chart Bar Grouped.
  const xLabels           = {
    0: '2010 2019',
    1: '2010 2019',
    2: '2010 2019',
    3: '2010 2019',
  }
  const barGroupContainer = document.getElementById( "bar-chart-grouped" );
  const chartBarGroup     = new Chart( barGroupContainer, {
    type: 'bar',
    data: {
      labels: [ 'Bangladesh', 'Geographic neighbors', 'Countries with similar GDP per capital', 'World average' ],
      datasets: [
        {
          label: '2010',
          backgroundColor: [ '#9049C9', '#DB56F0', '#FF94D4', '#FC50A2' ],
          data: [ 40, 35, 20, 50 ],
          barPercentage: 0.2,
          borderRadius: 8,
          borderSkipped: false,
        }, {
          label: '2019',
          backgroundColor: [ '#9049C9', '#DB56F0', '#FF94D4', '#FC50A2' ],
          data: [ 52, 42, 26, 55 ],
          barPercentage: 0.2,
          borderRadius: 8,
          borderSkipped: false,
        }
      ]
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        y: {
          grid: {
            borderDash: [ 10, 2 ]
          }
        },
        x: {
          beginAtZero: true,
          suggestedMin: 0,
          suggestedMax: 3,
          ticks: {
            font: {
              size: 12,
            },
            color: '#3F3F51',
            callback: function ( value, index, values ) {
              return xLabels[ value ];
            }
          },
          grid: {
            display: false,
            borderDash: [ 10, 2 ]
          }
        },
      }
    }
  } );

  // Chart Radar.
  const radarContainer = document.getElementById( "radar-chart" ).getContext( "2d" );
  const chartRadar     = new Chart( radarContainer, {
    type: 'radar',
    data: {
      labels: [ 'Drivers', 'Outcomes', [ 'Food', 'environment' ], [ 'Consumer', 'behavior' ], [ 'Actors and', 'activities' ] ],
      datasets: [
        {
          label: constantVars.country,
          fill: true,
          backgroundColor: "rgba(144, 73, 201, 0.24)",
          borderColor: "#9049C9",
          pointBorderColor: [ '#4671C3', '#B89612', '#4671C3', '#4671C3', '#4671C3', '#4671C3' ],
          pointBackgroundColor: [ '#55EBFF', '#FFD326', '#55EBFF', '#55EBFF', '#55EBFF', '#55EBFF' ],
          radius: 5,
          data: [ 20, 20, 19, 19, 21 ]
        },
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Distribution in % of world population'
      },
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        r: {
          max: 24,
          min: 10,
          ticks: {
            stepSize: 2,
            display: false
          },
          angleLines: {
            color: "rgba(228, 228, 228, 1)",
          },
          pointLabels: {
            color: '#3F3F51',
            font: {
              size: 10
            }
          }
        }
      }
    }
  } );

  // Bar chart
  const yLabels      = {
    0: ' ',
    1: 'Very concerning',
    2: 'Concerning',
    3: 'Fair',
    4: 'Good',
    5: 'Excellent'
  }
  const barContainer = document.getElementById( "bar-chart" );
  const chartBar     = new Chart( barContainer, {
    type: 'bar',
    data: {
      labels: [ constantVars.country, [ 'Geographic', 'neighbors' ], [ 'Countries with similar', 'GDP per capital' ], 'World average' ],
      datasets: [
        {
          label: constantVars.country,
          backgroundColor: [ '#7732AE', '#B13FC4', '#D56CAB', '#C52B74' ],
          data: [ 4, 2, 3, 3 ],
          barPercentage: 0.3
        }
      ]
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          suggestedMin: 0,
          suggestedMax: 5,
          ticks: {
            font: {
              size: 12,
            },
            color: '#3F3F51',
            callback: function ( value, index, values ) {
              return yLabels[ value ];
            }
          },
        },
        x: {
          ticks: {
            font: {
              size: 12,
            },
            color: '#3F3F51',
          }
        }
      }
    }
  } );

  // Line chart
  const lineContainer = document.getElementById( 'line-chart' );
  const data          = {
    labels: [ '', '2010', '2019', '' ],
    datasets: [
      {
        label: constantVars.country,
        data: [ NaN, 35, 45, NaN ],
        backgroundColor: '#9049C9',
        borderColor: '#9049C9',
        borderWidth: 2,
        pointStyle: 'triangle',
        pointRadius: 5,
      },
      {
        label: 'Geographic neighbors',
        data: [ NaN, 17, 35, NaN ],
        backgroundColor: '#DB56F0',
        borderColor: '#DB56F0',
        borderWidth: 2,
        pointStyle: 'triangle',
        pointRadius: 5,
      },
      {
        label: 'CS GDP per capital',
        data: [ NaN, 14, 25, NaN ],
        backgroundColor: '#FF94D4',
        borderColor: '#FF94D4',
        borderWidth: 2,
        pointStyle: 'triangle',
        pointRadius: 5,
      },
      {
        label: 'World average',
        data: [ NaN, 50, 59, NaN ],
        backgroundColor: '#FC50A2',
        borderColor: '#FC50A2',
        borderWidth: 2,
        pointStyle: 'triangle',
        pointRadius: 5,
      },
    ]
  };
  const myChart       = new Chart( lineContainer, {
      type: 'line',
      data,
      options: {
        plugins: {
          legend: {
            display: false,
          },
        },
        scales: {
          y: {
            beginAtZero: true,
            suggestedMin: 0,
            suggestedMax: 70,
            ticks: {
              stepSize: 15,
            },
            grid: {
              borderDash: [ 10, 5 ]
            }
          },
          x: {
            grid: {
              borderDash: [ 10, 5 ]
            },
          },
        }
      }
    }
  );
} );
