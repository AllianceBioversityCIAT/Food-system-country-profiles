jQuery( document ).ready( function ( $ ) {

  if ( $( '#content-download-csv-create' ).length > 0 ) {
    const $content = '<h3 style="margin-bottom: 0;">CSV File</h3>' +
      '<p>Download the csv file to start creating the indicators for the new country.</p>' +
      '<a class="button button-primary button-large" download href="' + ajax_var.fileCreation + '">' +
      ' Download CSV' +
      '</a>';

    $( '#content-download-csv-create' ).html( $content );
  }

  if ( $( '#content-download-csv-update' ).length > 0 ) {
    const $content = '<h3 style="margin-bottom: 0;">CSV File</h3>' +
      '<p>Download the csv file to update the indicators for the selected country.</p>' +
      '<a id="button-csv-update" class="button button-primary button-large">' +
      ' Download CSV' +
      '</a>';

    $( '#content-download-csv-update' ).html( $content );

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