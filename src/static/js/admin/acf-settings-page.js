jQuery( document ).ready( function ( $ ) {
  const $contentDocument = '<h3>Indications to add information to Excel.</h3>' +
    '<p>The downloaded file allows you to fill in the new indicators for the country, you must follow the guide described below.</p>' +
    '<p>Each column belonging to the downloaded CSV is described.</p>' +
    '<div style="display: flex;" >' +
    ' <div style="width: 50%">' +
    '   <p style="margin-bottom: 1rem"><strong>1. Name:</strong> Is the name of the indicator to be created.</p>' +
    '    <table style="border-collapse: collapse;">' +
    '      <tr><th style="border: 1px solid #dddddd; text-align: center; padding: 8px;">Name</th></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Gini index</td></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Rural population</td></tr>' +
    '    </table>' +
    '   <p style="margin-bottom: 1rem"><strong>2. Component:</strong> Is the component to which the indicator belongs, for example "drivers", the components to be used to relate each indicator is as follows:</p>' +
    '    <table style="border-collapse: collapse;">' +
    '      <tr><th style="border: 1px solid #dddddd; text-align: center; padding: 8px;">Component</th></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">outcomes</td></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">actors-and-activities</td></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">consumer-behavior</td></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">drivers</td></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">food-environment </td></tr>' +
    '    </table>' +
    '   <p style="margin-bottom: 1rem"><strong style="color: red;">Important:</strong> You can only create the indicators with these components, so that the dashboard can perform the calculations with this indicator.</p>' +
    '   <p style="margin-bottom: 1rem"><strong>3. Short description:</strong> A short description for the indicator, be careful not to include any special characters, for example: </p>' +
    '    <table style="border-collapse: collapse;">' +
    '      <tr><th style="border: 1px solid #dddddd; text-align: center; padding: 8px;">short-description </th></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Proxy for the contribution of the food system to economic inclusion </td></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Characteristics of consumers (proportion of rural dwellers) </td></tr>' +
    '    </table>' +
    '   <p style="margin-bottom: 1rem"><strong>4. Indicator units:</strong> Are the units that represent the indicator, for example: </p>' +
    '    <table style="border-collapse: collapse;">' +
    '      <tr><th style="border: 1px solid #dddddd; text-align: center; padding: 8px;">indicator-units</th></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Units (0-100 score)</td></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">% of total population</td></tr>' +
    '    </table>' +
    ' </div>' +
    ' <div style="width: 50%">' +
    '   <p style="margin-bottom: 1rem"><strong>5. Period initial:</strong> Initial period of the indicator for displaying the graphs: </p>' +
    '    <table style="border-collapse: collapse;">' +
    '      <tr><th style="border: 1px solid #dddddd; text-align: center; padding: 8px;">period-initial </th></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">2011</td></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">2010</td></tr>' +
    '    </table>' +
    '   <p style="margin-bottom: 1rem"><strong>6. Period recent:</strong> Recent Period of the indicator for displaying the graphs: </p>' +
    '    <table style="border-collapse: collapse;">' +
    '      <tr><th style="border: 1px solid #dddddd; text-align: center; padding: 8px;">period-recent </th></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">2018</td></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">2018</td></tr>' +
    '    </table>' +
    '   <p style="margin-bottom: 1rem"><strong>7. Type of growth:</strong> The type of growth that the indicator can have, where the growth can be "normal" or "inverted", it is important to write the type of growth in lower case. </p>' +
    '    <table style="border-collapse: collapse;">' +
    '      <tr><th style="border: 1px solid #dddddd; text-align: center; padding: 8px;">type-of-growth</th></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">inverted</td></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">normal</td></tr>' +
    '    </table>' +
    '   <p style="margin-bottom: 1rem"><strong>8.</strong> The columns referring to the initial and final values for the indicator groups, should be numeric as in the following example.</p>' +
    '    <table style="border-collapse: collapse;">' +
    '      <tr><th style="border: 1px solid #dddddd; text-align: center; padding: 8px;">country-initial-measure</th><th style="border: 1px solid #dddddd; text-align: center; padding: 8px;">country-last-measure</th></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">53.4</td><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">48.4</td></tr>' +
    '      <tr><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">36.5</td><td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">21</td></tr>' +
    '    </table>' +
    ' </div>' +
    '</div>' +
    '<h3 style="color: red; margin-bottom: 0;">IMPORTANT:</h3>' +
    '<p style="margin-top: 0;">You must always correctly write each value for the Excel columns, if you write a value that is not the correct one, the creation may fail. </p>';

  if ( $( '#content-download-csv-create' ).length > 0 ) {
    const $content = '<h3 style="margin-bottom: 0;">CSV File</h3>' +
      '<p>Download the csv file to start creating the indicators for the new country.</p>' +
      '<a class="button button-primary button-large" download href="' + ajax_var.fileCreation + '">' +
      ' Download CSV' +
      '</a>';

    $( '#content-download-csv-create' ).html( $content + $contentDocument );
  }

  if ( $( '#content-download-csv-update' ).length > 0 ) {
    const $content = '<h3 style="margin-bottom: 0;">CSV File</h3>' +
      '<p>Download the csv file to update the indicators for the selected country.</p>' +
      '<a id="button-csv-update" class="button button-primary button-large">' +
      ' Download CSV' +
      '</a>';

    $( '#content-download-csv-update' ).html( $content + $contentDocument );

    $( '#button-csv-update' ).on( 'click', function () {
      var selectedCountry = '';
      var dataCSV         = '';

      $( '#acf-field_update_indicator_country option:selected' ).each( function () {
        selectedCountry = $( this ).val();
      } );

      if ( selectedCountry !== '' ) {
        $( '#sfcs-error-update' ).remove();
        let data = {
          action: 'create_csv_all_indicators_from_country',
          nonce: ajax_var.nonce,
          country: selectedCountry,
        };

        $.ajax( {
          url: ajaxurl,
          type: 'POST',
          data: data,
          beforeSend: function () {
            // setting a timeout
            let messageLoad = '<div id="load-update-export" class="acf-notice" style="margin-top: 15px;"><p>Exporting data, please wait a moment...</p></div>';
            $( '.acf-field-download-update-indicators' ).append( messageLoad );
          },
        } )
          .done( function ( response ) {

            if ( response ) {
              response.forEach( function ( row ) {
                dataCSV += row.join( ';' );
                dataCSV += "\n";
              } );

              var hiddenElement       = document.createElement( 'a' );
              hiddenElement.className = 'download-update-indicators';
              hiddenElement.href      = 'data:text/csv;charset=utf-8,' + encodeURI( dataCSV );
              hiddenElement.target    = '_blank';
              hiddenElement.download  = 'update-indicators' + selectedCountry + '.csv';
              hiddenElement.click();
            }

            $( '#load-update-export' ).remove();
          } );
      } else {
        $( '#sfcs-error-update' ).remove();
        var content = '<div id="sfcs-error-update" class="acf-notice -error acf-error-message" style="margin-top: 1rem;">' +
          '<p>Select Country</p></div>';
        $( '.acf-field-update-indicator-country' ).append( content );
      }
    } );
  }

} );