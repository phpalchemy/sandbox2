<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /Users/erik/www/project/Sandbox/Application/View/templates/master.djt */
function haanga_b53118b7aa3219bc5094bc33e75a425013aad5ef($vars1500b434d85535, $return=FALSE, $blocks=array())
{
    extract($vars1500b434d85535);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>';
    $buffer1  = 'Welcome!';
    echo (isset($blocks['title']) ? (strpos($blocks['title'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['title'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['title'])) : $buffer1).'</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="assets/css/docs.css" rel="stylesheet">
    <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body data-spy="scroll" data-target=".subnav" data-offset="50">
    ';
    $buffer1  = '';
    echo (isset($blocks['body']) ? (strpos($blocks['body'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['body'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['body'])) : $buffer1).'
    <script src="'.htmlspecialchars($baseurl).'/assets/framework/js/jquery.js"></script>
    <script src="'.htmlspecialchars($baseurl).'/assets/js/bootstrap.js"></script>
    <script src="'.htmlspecialchars($baseurl).'/assets/js/codemirror.js"></script>
    <script src="'.htmlspecialchars($baseurl).'/assets/js/showdown.js"></script>
    <script src="'.htmlspecialchars($baseurl).'/assets/js/main.js"></script>
  </body>
</html>

';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}