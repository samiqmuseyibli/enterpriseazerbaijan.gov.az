$(document).ready(function () {

//Toggle button
$('.toggle_check').bootstrapToggle();
$('.toggle_check').change(function(){
  var status = $(this).prop('checked');
  var id = $(this).attr('dataID');
  var base_url = $(this).attr('dataURL');
  $.post(base_url , {id:id,status:status}, function(response){});
});



  $('.sidebar-menu').tree()

  $(function () {
  $('#example1').DataTable()
  $('#example2').DataTable({
    'paging'      : true,
    'lengthChange': false,
    'searching'   : false,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false
  })
})
  CKEDITOR.replace('editor1');
  CKEDITOR.replace('editor2');
  CKEDITOR.replace('editor3');
  CKEDITOR.replace('editor4');
  CKEDITOR.replace('editor5');
  CKEDITOR.replace('editor6');
  CKEDITOR.replace('editor7');
  CKEDITOR.replace('editor8');
  CKEDITOR.replace('editor9');
  CKEDITOR.replace('editor10');
  CKEDITOR.replace('editor11');
  CKEDITOR.replace('editor12');
  CKEDITOR.replace('editor13');
  CKEDITOR.replace('editor14');
  CKEDITOR.replace('editor15');
})
