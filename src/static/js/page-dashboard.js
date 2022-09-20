jQuery( document ).ready( ( $ ) => {

  $( '.component-status' ).click(function() {
    $( '.component-status' ).removeClass('active');
    $( this ).addClass( "active" );
  });

  // Chart Bar Grouped.
  const barGroupContainer = document.getElementById( "bar-chart-grouped" );
  const chartBarGroup = new Chart( barGroupContainer, {
    type: 'bar',
    data: {
      labels: [ "1900", "1950", "1999", "2050" ],
      datasets: [
        {
          label: "Africa",
          backgroundColor: "#3e95cd",
          data: [ 133, 221, 783, 2478 ]
        }, {
          label: "Europe",
          backgroundColor: "#8e5ea2",
          data: [ 408, 547, 675, 734 ]
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Population growth (millions)'
      }
    }
  } );

  // Chart Radar.
  const radarContainer = document.getElementById( "radar-chart" ).getContext("2d");
  const chartRadar = new Chart( radarContainer ,
    {
    type: 'radar',
    data: {
      labels: [ 'Drivers', 'Outcomes', ['Food', 'environment'], ['Consumer', 'behavior'], ['Actors and', 'activities'] ],
      datasets: [
        {
          label: constantVars.country,
          fill: true,
          backgroundColor: "rgba(144, 73, 201, 0.24)",
          borderColor: "#9049C9",
          pointBorderColor: ['#4671C3', '#B89612', '#4671C3', '#4671C3', '#4671C3', '#4671C3'],
          pointBackgroundColor: ['#55EBFF', '#FFD326', '#55EBFF', '#55EBFF', '#55EBFF', '#55EBFF'],
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
  const barContainer = document.getElementById( "bar-chart" );
  const chartBar = new Chart( barContainer, {
    type: 'bar',
    data: {
      labels: [ "Africa", "Asia", "Europe", "Latin America", "North America" ],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: [ "#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850" ],
          data: [ 2478, 5267, 734, 784, 433 ]
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Predicted world population (millions) in 2050'
      }
    }
  } );
} );
