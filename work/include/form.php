<!DOCTYPE HTML>
<html lang="en">
 <head>
  <title>Argo</title>
  <!-- Named after the ship on which Jason and the Argonauts sailed -->
  <meta charset="utf-8">
  <meta name="author" content="Houruck">
  <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="/js/scripts.js" type="text/javascript"></script>
 </head>

<body>
 <div id="wrapper">
  <div id="grid">
   <div id="doll"></div>

   <h2>Health Resource</h2>

   <form name="values" action="" method="post">
<?php
//mapping CSV to array
$csv = array_map('str_getcsv', file('../work/in/'.$gear.'.csv'));
include("../work/include/bones.php");

foreach ($parts as $desc => $part) {
echo '	<label class="bone">'.$desc.'</label> <input type="number" min="1" max="5000" name="value['.$part.']" value="'.$$part.'" onmouseover="g'.$part.'()" onmouseout="gDoll()" onfocus="g'.$part.'()" onblur="gDoll()" required>', PHP_EOL;
}
echo '	<input type="hidden" name="gear" value="'.$gear.'">', PHP_EOL;
?>
    <input type="submit" value="Download">
   </form>
<?php
include ("fluff.html");
?>

  </div>
 </div>
</body>
</html>