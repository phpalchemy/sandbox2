<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /Users/erik/www/project/Sandbox/app/views/Sample/twigTest.twig */
function haanga_2ba6551544b2245ea6677977f92dcc4066322957($vars14fdb4b45a1af2, $return=FALSE, $blocks=array())
{
    extract($vars14fdb4b45a1af2);
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