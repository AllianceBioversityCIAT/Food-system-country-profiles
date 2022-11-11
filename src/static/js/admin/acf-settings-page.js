jQuery( document ).ready(function($) {

  var $content = '<h3 style="margin-bottom: 0;">CSV File</h3>' +
    '<p>Download the csv file to start creating the indicators for the new country.</p>' +
    '<a class="button button-primary button-large" download href="' + ajax_var.fileCreation + '">' +
    ' Download CSV' +
    '</a>';

  $( '#conent-download-csv-create' ).html($content);
});