<html>
<head>
<title>Problema</title>
</head>
<body>
<?php
  $dir = 'mvme' ;
  if ( isset( $_REQUEST['m_dosier'] ) )
		{ $dir = $_REQUEST['m_dosier'] ; }
  copy($_FILES['foto']['tmp_name'],'./'.$dir.'/'.$_FILES['foto']['name']);
  $nom=$_FILES['foto']['name'];
  echo "El archivo ".$nom." se copio en el servidor.<br>";
  //echo "<img src=\"$nom\">";
?>
</body>
</html>
