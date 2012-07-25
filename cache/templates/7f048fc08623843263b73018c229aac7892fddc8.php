<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /Users/erik/www/project/Sandbox/Application/View/templates/Sample/index.tpl */
function haanga_7f048fc08623843263b73018c229aac7892fddc8($vars1500b0acae86b5, $return=FALSE, $blocks=array())
{
    extract($vars1500b0acae86b5);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<html>
  <title>Index on Sample Controller</title>
  <body>
  <h1>{$title}!!!!</h1>
  </body>
</html>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}