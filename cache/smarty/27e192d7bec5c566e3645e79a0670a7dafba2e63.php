<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /Users/erik/www/project/Sandbox/application/View/Sample/twigTest.twig */
function haanga_27e192d7bec5c566e3645e79a0670a7dafba2e63($vars14fe4a98a25b18, $return=FALSE, $blocks=array())
{
    extract($vars14fe4a98a25b18);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<html>
  <title>Index on Sample Controller</title>
  <body>
  <h1>'.htmlspecialchars($title).'</h1>
  </body>
</html>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}