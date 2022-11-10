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
  const componentStatus = {
    5: 'excellent',
    4: 'good',
    3: 'fair',
    2: 'concerning',
    1: 'very-concerning'
  };
  const barGroupContainer = document.getElementById( 'bar-chart-grouped' );
  const lineContainer     = document.getElementById( 'line-chart' );
  const radarContainer    = document.getElementById( 'radar-chart' ).getContext( "2d" );
  const barContainer      = document.getElementById( "bar-chart" );
  const barGroupColors    = [ '#9049C9', '#DB56F0', '#FF94D4', '#FC50A2' ];
  const chartLabels       = [ constantVars.country, 'Geographic neighbors', 'Countries with similar GDP per capita', 'World average' ]
  let barGroupXLabels     = [];
  var chartBarGroup;
  var dataSetInitialGroupBar;
  var dataSetLastGroupBar;
  var chartLine;
  var chartRadar;
  var chartBar;

  // View first indicator chart.
  const firstIndicatorSelected   = $( '#first-indicator-selected' );
  const titleIndicatorSelected   = firstIndicatorSelected.attr( 'data-indicator-title' );
  const contentIndicatorSelected = JSON.parse( firstIndicatorSelected.attr( 'data-indicator' ) );
  chartLineView( contentIndicatorSelected, titleIndicatorSelected, true );
  createChartRadar();

  const firstComponentSelected   = $( '#component-drivers' );
  const titleComponentSelected   = firstComponentSelected.attr( 'data-component-title' );
  const contentComponentSelected = JSON.parse( firstComponentSelected.attr( 'data-component' ) );
  chartBarView( contentComponentSelected, titleComponentSelected, true );

  $( '.component-status' ).click( function () {
    $( '.component-status' ).removeClass( 'active' );
    $( this ).addClass( "active" );
    var $tabId = $( this ).attr( 'data-tab-id' );

    $( "ul.tabs li" ).removeClass( "active" ); //Remove any "active" class
    $( '#' + $tabId ).addClass( "active" ); //Add "active" class to selected tab

    $( ".tab_content" ).hide(); //Hide all tab content
    var $tabContentId = $( '#' + $tabId ).find( "a" ).attr( "href" );
    $( $tabContentId ).fadeIn(); //Fade in the active ID content

    $( '.indicator-option' ).removeClass( 'active' );
    $( $tabContentId + ' .indicator-option:first' ).addClass( "active" );

    var $component      = JSON.parse( $( this ).attr( 'data-component' ) );
    var $componentTitle = $( this ).attr( 'data-component-title' );

    var $indicator      = JSON.parse( $( $tabContentId + ' .indicator-option:first' ).attr( 'data-indicator' ) );
    var $indicatorTitle = $( $tabContentId + ' .indicator-option:first' ).attr( 'data-indicator-title' );

    var $accordionId = $( this ).attr( 'data-accordion-id' );
    $( '.sfsc-radio-component' ).prop( 'checked', false );
    $( '#' + $accordionId + ' input' ).prop( 'checked', true );

    chartLineView( $indicator, $indicatorTitle );
    chartBarView( $component, $componentTitle );
  } );

  $( '.indicator-option' ).click( function () {
    $( '.indicator-option' ).removeClass( 'active' );
    $( this ).addClass( "active" );
    var $indicator      = JSON.parse( $( this ).attr( 'data-indicator' ) );
    var $indicatorTitle = $( this ).attr( 'data-indicator-title' );

    chartLineView( $indicator, $indicatorTitle );
  } );

  $( '.sfsc-accordion' ).click( function () {
    var $tabId = $( this ).attr( 'data-tab-id' );

    $( "ul.tabs li" ).removeClass( "active" ); //Remove any "active" class
    $( '#' + $tabId ).addClass( "active" ); //Add "active" class to selected tab

    $( ".tab_content" ).hide(); //Hide all tab content
    var $tabContentId = $( '#' + $tabId ).find( "a" ).attr( "href" );
    $( $tabContentId ).show();

    $( '.indicator-option' ).removeClass( 'active' );
    $( $tabContentId + ' .indicator-option:first' ).addClass( "active" );

    var $indicator      = JSON.parse( $( $tabContentId + ' .indicator-option:first' ).attr( 'data-indicator' ) );
    var $indicatorTitle = $( $tabContentId + ' .indicator-option:first' ).attr( 'data-indicator-title' );

    var $componentId    = $( this ).attr( 'data-component-id' );
    var $component      = JSON.parse( $( '#' + $componentId ).attr( 'data-component' ) );
    var $componentTitle = $( '#' + $componentId ).attr( 'data-component-title' );

    $( '.component-status' ).removeClass( 'active' );
    $( '#' + $componentId ).addClass( "active" );

    chartLineView( $indicator, $indicatorTitle );
    chartBarView( $component, $componentTitle );
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

  $( '#radar-chart-download' ).click( function () {
    $( '.download-radar' ).remove();

    html2canvas( document.getElementById( 'radar-chart' ), {
      allowTaint: true,
      useCORS: true,
      backgroundColor: 'rgba(255, 255, 255, 1)',
      removeContainer: true,
    } ).then( function ( canvas ) {
      var anchorTag       = document.createElement( 'a' );
      anchorTag.className = 'download-radar'
      document.body.appendChild( anchorTag );
      anchorTag.download = `${ constantVars.country } - Radar.jpg`;
      anchorTag.href     = canvas.toDataURL();
      anchorTag.target   = '_blank';
      anchorTag.click();
    } );
  } );

  $( '#bar-chart-download' ).click( function () {
    const titleGraph = $( '#graph-bar-title' ).text();
    $( '.download-radar' ).remove();

    html2canvas( document.getElementById( 'grid-graph-bar' ), {
      allowTaint: true,
      useCORS: true,
      backgroundColor: 'rgba(255, 255, 255, 1)',
      removeContainer: true,
    } ).then( function ( canvas ) {
      var anchorTag       = document.createElement( 'a' );
      anchorTag.className = 'download-bar'
      document.body.appendChild( anchorTag );
      anchorTag.download = `${ titleGraph } - Bar.jpg`;
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

    var $componentId    = $( this ).attr( 'data-component-id' );
    var $component      = JSON.parse( $( '#' + $componentId ).attr( 'data-component' ) );
    var $componentTitle = $( '#' + $componentId ).attr( 'data-component-title' );
    $( '.component-status' ).removeClass( 'active' );
    $( '#' + $componentId ).addClass( "active" );

    $( '.indicator-option' ).removeClass( 'active' );
    $( activeTab + ' .indicator-option:first' ).addClass( "active" );
    var $indicator      = JSON.parse( $( activeTab + ' .indicator-option:first' ).attr( 'data-indicator' ) );
    var $indicatorTitle = $( activeTab + ' .indicator-option:first' ).attr( 'data-indicator-title' );

    var $accordionId = $( this ).attr( 'data-accordion-id' );
    $( '.sfsc-radio-component' ).prop( 'checked', false );
    $( '#' + $accordionId + ' input.sfsc-radio-component' ).prop( 'checked', true );

    chartLineView( $indicator, $indicatorTitle );
    chartBarView( $component, $componentTitle );

    return false;
  } );

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
          responsive: true,
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

  /**
   * Creates a Radar chart with the components data.
   */
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
            radius: 6,
            data: $data
          },
        ]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: 'Distribution in % of world population'
        },
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                const number = convertPercentage( context.parsed.r );
                return ' ' + componentStatus[ number ];
              },
            }
          }
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
                size: 11
              }
            }
          }
        }
      }
    } );
  }

  /**
   * This function updates the Bar chart with the new data for the selected component.
   *
   * @param component Object Get component data.
   * @param componentTitle String component title.
   * @param firstView Boolean If the indicator to be displayed is the first one.
   */
  function chartBarView( component, componentTitle, firstView ) {
    const $componentTitle  = `<strong>${ componentTitle }</strong>  (aggregated value across the ${ component.total_component } individual indicators)`;
    const yLabels          = {
      0: ' ',
      1: 'Very concerning',
      2: 'Concerning',
      3: 'Fair',
      4: 'Good',
      5: 'Excellent'
    };
    const $backgroundColor = [ '#7732AE', '#B13FC4', '#D56CAB', '#C52B74' ];

    $( '#graph-bar-title' ).html( $componentTitle );

    const $data = groupValuePercentage( component );

    // Destroys a specific chart instance.
    if ( !firstView ) {
      chartBar.destroy();
    }

    createChartBar( yLabels, $backgroundColor, $data )
  }

  /**
   * Creates a line chart with the indicator data.
   *
   * @param yLabels Array Get the largest Y-labels value.
   * @param $backgroundColor Array Get the largest Y-axis value.
   * @param $data Array Gets the colors for each bar.
   */
  function createChartBar( yLabels, $backgroundColor, $data ) {
    chartBar = new Chart( barContainer, {
      type: 'bar',
      data: {
        labels: [ constantVars.country, [ 'Geographic', 'neighbors' ], [ 'Countries with similar', 'GDP per capita' ], 'World average' ],
        datasets: [
          {
            label: constantVars.country,
            backgroundColor: $backgroundColor,
            data: $data,
            barPercentage: 0.3
          }
        ]
      },
      options: {
        //events: [],
        responsive: true,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return ' ' + yLabels[ context.parsed.y ];
              },
            }
          }
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
  }

  function groupValuePercentage( data ) {
    const percentageC   = Math.round( ( ( data.c / data.total_component ) * 100 ), -2 );
    const percentageGN  = Math.round( ( ( data.gn / data.total_component ) * 100 ), -2 );
    const percentageGDP = Math.round( ( ( data.gdp / data.total_component ) * 100 ), -2 );
    const percentageGA  = Math.round( ( ( data.ga / data.total_component ) * 100 ), -2 );

    return [
      convertPercentage( percentageC ),
      convertPercentage( percentageGN ),
      convertPercentage( percentageGDP ),
      convertPercentage( percentageGA )
    ];
  }

  function convertPercentage( number ) {

    if ( number >= 85 && number <= 100 ) {
      return 5;

    } else if ( number >= 65 && number <= 84 ) {
      return 4;

    } else if ( number >= 50 && number <= 64 ) {
      return 3;

    } else if ( number >= 25 && number <= 49 ) {
      return 2;

    } else if ( number >= 0 && number <= 24 ) {
      return 1;
    }

    return 0
  }
} );
