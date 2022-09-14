jQuery( document ).ready( ( $ ) => {
  console.log( 'Page Dashboard' );

  new Chart( document.getElementById( "bar-chart-grouped" ), {
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

  // radar-chart
  new Chart( document.getElementById( "radar-chart" ), {
    type: 'radar',
    data: {
      labels: [ "Africa", "Asia", "Europe", "Latin America", "North America" ],
      datasets: [
        {
          label: "1950",
          fill: true,
          backgroundColor: "rgba(179,181,198,0.2)",
          borderColor: "rgba(179,181,198,1)",
          pointBorderColor: "#fff",
          pointBackgroundColor: "rgba(179,181,198,1)",
          data: [ 8.77, 55.61, 21.69, 6.62, 6.82 ]
        }, {
          label: "2050",
          fill: true,
          backgroundColor: "rgba(255,99,132,0.2)",
          borderColor: "rgba(255,99,132,1)",
          pointBorderColor: "#fff",
          pointBackgroundColor: "rgba(255,99,132,1)",
          pointBorderColor: "#fff",
          data: [ 25.48, 54.16, 7.61, 8.06, 4.45 ]
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Distribution in % of world population'
      }
    }
  } );

  // Bar chart
  new Chart( document.getElementById( "bar-chart" ), {
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
