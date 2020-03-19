<!DOCTYPE html>
<html>
<head>
    <title>Pdf Read</title>
    <style>
          .pdfobject-container { height: 500px;}
          .pdfobject { border: 1px solid #666; }
   </style>
   <script src="pdfobject.min.js"></script>
</head>
<body>
        <div id="example1"></div>
        <script>PDFObject.embed("<?=$_GET['file']?>", "#example1");</script>
</body>
</html>