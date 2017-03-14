$(function() {

  /*======================
    Search box
  ======================*/
  $('.search-box').on('submit', function(event) {
    event.preventDefault();
    var url = "php/search.php";
    var query = $('#search-box-input').val();
    $.getJSON(url, {query: query}, function(returnedData) {
      var resultHTML = '';

      var canvases = JSON.parse(returnedData);

      $.each(canvases, function(index, value) {
        console.log(index + " " + value);
      }) //end of $.each(returnedData)

    }); // end of $.getJSON
  }); // end of $('.search-box').on('submit' ...
});
