<!DOCTYPE html>
<html>
<head>
    <title>Pdf Read</title>
    <style>
.custom1 {
   margin-left: auto !important;
   margin-right: auto !important;
   margin: 20px;
   padding: 20px;
}
.custom2 {
  position: relative;
  height: 0;
  overflow: hidden;
  padding-bottom: 90%;
}
.custom2 iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  padding: 0;
  margin: 0;
}
#tutorial-pdf-responsive {
  max-width: 900px;
  max-height: 700px;
  overflow: hidden;
}

</style>
   <script src="pdfobject.min.js"></script>
</head>
<body>
        <!--<div id="example1"></div>
        <script>PDFObject.embed("http://<?=$_SERVER['HTTP_HOST'].$_GET['file']?>", "#example1");</script>-->
        
<div id="tutorial-pdf-responsive" class="custom1">
  <div class="custom2">
     <iframe src="http://<?=$_SERVER['HTTP_HOST'].$_GET['file']?>"></iframe>
  </div>
</div>
        
</body>
</html>
