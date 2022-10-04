jQuery( document ).ready( ( $ ) => {
  const colorCountry      = '#9049C9';
  const colorGN           = '#DB56F0';
  const colorGDP          = '#FF94D4';
  const colorGA           = '#FC50A2';
  const colorStatus       = {
    'excellent': '#8EF041',
    'good': '#55EBFF',
    'fair': '#FFD326',
    'concerning': '#F1B51B',
    'very-concerning': '#F15B1B'
  };
  const colorBorderStatus = {
    'excellent': '#37A842',
    'good': '#4671C3',
    'fair': '#B89612',
    'concerning': 'rgba(188, 68, 0, 1)',
    'very-concerning': 'rgba(188, 23, 0, 1)'
  };
  const barGroupContainer = document.getElementById( 'bar-chart-grouped' );
  const lineContainer     = document.getElementById( 'line-chart' );
  const radarContainer    = document.getElementById( 'radar-chart' ).getContext( "2d" );
  const barGroupColors    = [ '#9049C9', '#DB56F0', '#FF94D4', '#FC50A2' ];
  const chartLabels       = [ constantVars.country, 'Geographic neighbors', 'Countries with similar GDP per capita', 'World average' ]
  let barGroupXLabels     = [];
  var chartBarGroup;
  var dataSetInitialGroupBar;
  var dataSetLastGroupBar;
  var chartLine;
  var chartRadar;

  // View first indicator chart.
  const firstIndicatorSelected   = $( '#first-indicator-selected' );
  const titleIndicatorSelected   = firstIndicatorSelected.attr( 'data-indicator-title' );
  const contentIndicatorSelected = JSON.parse( firstIndicatorSelected.attr( 'data-indicator' ) );
  chartGroupBar( contentIndicatorSelected, titleIndicatorSelected, true );
  chartLineView( contentIndicatorSelected, titleIndicatorSelected, true );
  createChartRadar();

  $( '.component-status' ).click( function () {
    $( '.component-status' ).removeClass( 'active' );
    $( this ).addClass( "active" );
  } );

  $( '.indicator-option' ).click( function () {
    $( '.indicator-option' ).removeClass( 'active' );
    $( this ).addClass( "active" );
    var $indicator      = JSON.parse( $( this ).attr( 'data-indicator' ) );
    var $indicatorTitle = $( this ).attr( 'data-indicator-title' );
    chartGroupBar( $indicator, $indicatorTitle, );
    chartLineView( $indicator, $indicatorTitle );
  } );

  $( '.note-closed' ).click( function () {
    $( '.note-indicators' ).hide();
  } );

  $( '#group-bar-chart-download' ).click( function () {
    const titleGraph = $( '#title-bar-chart' ).text();
    $( '.download-comparative-bars' ).remove();

    html2canvas( document.getElementById( 'graph-comparative-bars' ), {
      allowTaint: true,
      useCORS: true,
      backgroundColor: 'rgba(255, 255, 255, 1)',
      removeContainer: true,
    } ).then( function ( canvas ) {
      var anchorTag       = document.createElement( 'a' );
      anchorTag.className = 'download-comparative-bars';
      document.body.appendChild( anchorTag );
      anchorTag.download = `${ titleGraph } - Comparative Bars.jpg`;
      anchorTag.href     = canvas.toDataURL();
      anchorTag.target   = '_blank';
      anchorTag.click();
    } );
  } );

  $( '#line-chart-download' ).click( function () {
    const titleGraph = $( '#title-line-chart' ).text();
    $( '.download-line' ).remove();

    html2canvas( document.getElementById( 'graph-line' ), {
      allowTaint: true,
      useCORS: true,
      backgroundColor: 'rgba(255, 255, 255, 1)',
      removeContainer: true,
    } ).then( function ( canvas ) {
      var anchorTag       = document.createElement( 'a' );
      anchorTag.className = 'download-line'
      document.body.appendChild( anchorTag );
      anchorTag.download = `${ titleGraph } - Line.jpg`;
      anchorTag.href     = canvas.toDataURL();
      anchorTag.target   = '_blank';
      anchorTag.click();
    } );
  } );

  //When page loads...
  $( ".tab_content" ).hide(); //Hide all content
  $( "ul.tabs li:first" ).addClass( "active" ).show(); //Activate first tab
  $( ".tab_content:first" ).show(); //Show first tab content

  //On Click Event
  $( "ul.tabs li" ).click( function () {

    $( "ul.tabs li" ).removeClass( "active" ); //Remove any "active" class
    $( this ).addClass( "active" ); //Add "active" class to selected tab
    $( ".tab_content" ).hide(); //Hide all tab content

    var activeTab = $( this ).find( "a" ).attr( "href" ); //Find the href attribute value to identify the active tab +
                                                          // content
    $( activeTab ).fadeIn(); //Fade in the active ID content
    return false;
  } );

  /**
   * This function updates the comparative bar chart with the new data for the selected indicator.
   *
   * @param indicator Object Get indicator data.
   * @param indicatorTitle String Indicator Title.
   * @param firstView Boolean If the indicator to be displayed is the first one.
   */
  function chartGroupBar( indicator, indicatorTitle, firstView ) {
    barGroupXLabels        = {
      0: `${ indicator.period_initial }  ${ indicator.period_recent }`,
      1: `${ indicator.period_initial }  ${ indicator.period_recent }`,
      2: `${ indicator.period_initial }  ${ indicator.period_recent }`,
      3: `${ indicator.period_initial }  ${ indicator.period_recent }`,
    }
    dataSetInitialGroupBar = [ indicator.country_initial_measure, indicator.gn_initial_measure, indicator.gdp_initial_measure, indicator.ga_initial_measure ];
    dataSetLastGroupBar    = [ indicator.country_last_measure, indicator.gn_last_measure, indicator.gdp_last_measure, indicator.ga_last_measure ];
    $( '#title-bar-chart' ).text( indicatorTitle );

    // Destroys a specific chart instance.
    if ( !firstView ) {
      chartBarGroup.destroy();
    }

    // We re-create the graph instance.
    createBarGroupChart(
      chartLabels,
      indicator.period_initial,
      indicator.period_recent,
      dataSetInitialGroupBar,
      dataSetLastGroupBar,
      barGroupColors,
      barGroupXLabels
    );
  }

  /**
   * Creates a bar chart image with the indicator data.
   *
   * @param barLabels Array Get titles labels.
   * @param dataLabelInitial String Initial indicator value.
   * @param dataLabelLAst String Final indicator value.
   * @param dataInitial Array Get initial indicator data.
   * @param dataLast Array Get final indicator data.
   * @param colors Array Get color bars.
   * @param xLabels Array Get label data.
   */
  function createBarGroupChart( barLabels, dataLabelInitial, dataLabelLAst, dataInitial, dataLast, colors, xLabels ) {
    const $borderDashInit  = 10;
    const $borderDashFinal = 2;
    const $barPercentage   = 0.2;
    const $borderRadius    = 8;

    chartBarGroup = new Chart( barGroupContainer, {
      type: 'bar',
      data: {
        labels: barLabels,
        datasets: [
          {
            label: dataLabelInitial,
            backgroundColor: colors,
            data: dataInitial,
            barPercentage: $barPercentage,
            borderRadius: $borderRadius,
            borderSkipped: false,
          }, {
            label: dataLabelLAst,
            backgroundColor: colors,
            data: dataLast,
            barPercentage: $barPercentage,
            borderRadius: $borderRadius,
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
              borderDash: [ $borderDashInit, $borderDashFinal ]
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
              borderDash: [ $borderDashInit, $borderDashFinal ]
            }
          },
        }
      }
    } );
  }

  /**
   * This function updates the line chart with the new data for the selected indicator.
   *
   * @param indicator Object Get indicator data.
   * @param indicatorTitle String Indicator Title.
   * @param firstView Boolean If the indicator to be displayed is the first one.
   */
  function chartLineView( indicator, indicatorTitle, firstView ) {
    const $borderWidth = 2;
    const $pointStyle  = 'triangle';
    const $pointRadius = 5;
    $( '#title-line-chart' ).text( indicatorTitle );

    // Destroys a specific chart instance.
    if ( !firstView ) {
      chartLine.destroy();
    }

    const values      = Math.max( ...[ indicator.country_initial_measure, indicator.gn_initial_measure, indicator.gdp_initial_measure, indicator.ga_initial_measure, indicator.country_last_measure, indicator.gn_last_measure, indicator.gdp_last_measure, indicator.ga_last_measure ] );
    const higherValue = values <= 5 ? ( values + 0.5 ) : ( values + 5 );
    const data        = {
      labels: [ '', indicator.period_initial, indicator.period_recent, '' ],
      datasets: [
        {
          label: constantVars.country,
          data: [ NaN, indicator.country_initial_measure, indicator.country_last_measure, NaN ],
          backgroundColor: colorCountry,
          borderColor: colorCountry,
          borderWidth: $borderWidth,
          pointStyle: $pointStyle,
          pointRadius: $pointRadius,
        },
        {
          label: 'Geographic neighbors',
          data: [ NaN, indicator.gn_initial_measure, indicator.gn_last_measure, NaN ],
          backgroundColor: colorGN,
          borderColor: colorGN,
          borderWidth: $borderWidth,
          pointStyle: $pointStyle,
          pointRadius: $pointRadius,
        },
        {
          label: 'CS GDP per capita',
          data: [ NaN, indicator.gdp_initial_measure, indicator.gdp_last_measure, NaN ],
          backgroundColor: colorGDP,
          borderColor: colorGDP,
          borderWidth: $borderWidth,
          pointStyle: $pointStyle,
          pointRadius: $pointRadius,
        },
        {
          label: 'World average',
          data: [ NaN, indicator.ga_initial_measure, indicator.ga_last_measure, NaN ],
          backgroundColor: colorGA,
          borderColor: colorGA,
          borderWidth: $borderWidth,
          pointStyle: $pointStyle,
          pointRadius: $pointRadius,
        },
      ]
    };

    createChartLine( data, higherValue );
  }

  /**
   * Creates a line chart with the indicator data.
   *
   * @param data Array Get data to build the graph.
   * @param yMax Int Get the largest Y-axis value.
   */
  function createChartLine( data, yMax ) {
    const $borderDashInit  = 10;
    const $borderDashFinal = 5;

    chartLine = new Chart( lineContainer, {
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
              suggestedMax: yMax,
              ticks: {
                beginAtZero: true,
                steps: 5,
              },
              grid: {
                borderDash: [ $borderDashInit, $borderDashFinal ]
              }
            },
            x: {
              grid: {
                borderDash: [ $borderDashInit, $borderDashFinal ]
              },
            },
          }
        }
      }
    );
  }

  function createChartRadar() {
    const $componentDriver   = $( '#component-drivers' )
    const $componentActors   = $( '#component-actors-and-activities' )
    const $componentFood     = $( '#component-food-environment' )
    const $componentConsumer = $( '#component-consumer-behavior' )
    const $componentOutcomes = $( '#component-outcomes' )

    const $pointBackgroundColor = [
      colorStatus[ $componentDriver.attr( 'data-component-status' ) ],
      colorStatus[ $componentOutcomes.attr( 'data-component-status' ) ],
      colorStatus[ $componentFood.attr( 'data-component-status' ) ],
      colorStatus[ $componentConsumer.attr( 'data-component-status' ) ],
      colorStatus[ $componentActors.attr( 'data-component-status' ) ],

    ];
    const $pointBorderColor     = [
      colorBorderStatus[ $componentDriver.attr( 'data-component-status' ) ],
      colorBorderStatus[ $componentOutcomes.attr( 'data-component-status' ) ],
      colorBorderStatus[ $componentFood.attr( 'data-component-status' ) ],
      colorBorderStatus[ $componentConsumer.attr( 'data-component-status' ) ],
      colorBorderStatus[ $componentActors.attr( 'data-component-status' ) ],
    ];
    const $data                 = [
      $componentDriver.attr( 'data-component-percentage' ),
      $componentOutcomes.attr( 'data-component-percentage' ),
      $componentFood.attr( 'data-component-percentage' ),
      $componentConsumer.attr( 'data-component-percentage' ),
      $componentActors.attr( 'data-component-percentage' ),
    ];

    chartRadar = new Chart( radarContainer, {
      type: 'radar',
      data: {
        labels: [ 'Drivers', 'Outcomes', [ 'Food', 'environment' ], [ 'Consumer', 'behavior' ], [ 'Actors and', 'activities' ] ],
        datasets: [
          {
            label: constantVars.country,
            fill: true,
            backgroundColor: 'rgba(144, 73, 201, 0.24)',
            borderColor: '#9049C9',
            pointBorderColor: $pointBorderColor,
            pointBackgroundColor: $pointBackgroundColor,
            radius: 5,
            data: $data
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
            max: 100,
            min: 0,
            ticks: {
              stepSize: 10,
              display: false
            },
            angleLines: {
              color: 'rgba(228, 228, 228, 1)',
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
  }

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
      labels: [ constantVars.country, [ 'Geographic', 'neighbors' ], [ 'Countries with similar', 'GDP per capita' ], 'World average' ],
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
} );
