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

      var canvases = returnedData[0];
      console.log("Canvases: " + JSON.stringify(returnedData) + "\n");


      resultHTML += '<div class="col-md-4"><div class="panel panel-default"><div class="panel-heading"><h4><i class="fa fa-fw fa-check"></i>' + value['canvas_name'] + '</h4></div><div class="panel-body"><p></p><a href="#" class="btn btn-default">View</a>';
      
      resultHTML+= '</div></div></div>';



      $.each(canvases, function(key, value) {
        if(key == 'TAlszs4xcc') {
          console.log(key + " " + value + "; TAlszs4xcc " + "\n");
        } else if (key == 'zBwOdAamnN') {
          console.log(key + " " + value + "; zBwOdAamnN " + "\n");
        }
      }) //end of $.each(returnedData)

    }); // end of $.getJSON
  }); // end of $('.search-box').on('submit' ...
});
