<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<link rel="stylesheet" href="css_print/960.css" type="text/css" media="screen">
<link rel="stylesheet" href="css_print/screen.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css_print/print-preview.css" type="text/css" media="screen">
<link rel="stylesheet" href="css_print/print.css" type="text/css" media="print" />
<link rel="shortcut icon" href="css_print/images/icon-print.png">
<script src="css_print/jquery.tools.min.js"></script>
<script src="css_print/jquery.print-preview.js" type="text/javascript" charset="utf-8"></script>
   
<script type="text/javascript">
$(function() {

$("#feature > div").scrollable({interval: 2000}).autoscroll();

$('#aside').prepend('<a class="print-preview">Cetak </a>');
$('a.print-preview').printPreview();

//$(document).bind('keydown', function(e) {
var code = 80;
//if (code == 80 && !$('#print-modal').length) {
$.printPreview.loadPrintPreview();
//return false;
//}
//});
});
</script>

</head>

