jQuery( document ).ready( ( $ ) => {

  /**** screen Post Country Profile ****/
  if ( $( 'body.post-php' ).length >= 1 || $( 'body.post-new-php' ).length >= 1 ) {
    acf.addAction( 'load', function () {

      // Fields Country
      $( '#acf-field_country_difference' ).attr( 'readonly', true );
      $( '#acf-field_country_growth_rate' ).attr( 'readonly', true );
      $( '#acf-field_country_score_better' ).attr( 'readonly', true );
      $( '#acf-field_country_final_status' ).attr( 'readonly', true );
      $( '#acf-field_country_better_than_world' ).attr( 'readonly', true );
      $( '#acf-field_country_comparison_with_world' ).attr( 'readonly', true );

      // Fields Geographic neighbors.
      $( '#acf-field_gn_difference' ).attr( 'readonly', true );
      $( '#acf-field_gn_growth_rate' ).attr( 'readonly', true );
      $( '#acf-field_gn_consolidated_value' ).attr( 'readonly', true );
      $( '#acf-field_gn_final_status' ).attr( 'readonly', true );

      // Fields Countries with similar GDP.
      $( '#acf-field_gdp_difference' ).attr( 'readonly', true );
      $( '#acf-field_gdp_growth_rate' ).attr( 'readonly', true );
      $( '#acf-field_gdp_consolidated_value' ).attr( 'readonly', true );
      $( '#acf-field_gdp_final_status' ).attr( 'readonly', true );

      // Fields Global average.
      $( '#acf-field_ga_difference' ).attr( 'readonly', true );
      $( '#acf-field_ga_growth_rate' ).attr( 'readonly', true );
      $( '#acf-field_ga_consolidated_value' ).attr( 'readonly', true );
      $( '#acf-field_ga_final_status' ).attr( 'readonly', true );
    } );
  }

} );
