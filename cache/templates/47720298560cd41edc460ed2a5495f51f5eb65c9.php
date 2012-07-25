<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /Users/erik/www/project/Sandbox/Application/View/templates/footer.djt */
function haanga_47720298560cd41edc460ed2a5495f51f5eb65c9($vars1500b122ff1f02, $return=FALSE, $blocks=array())
{
    extract($vars1500b122ff1f02);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<footer>
    <p>Powered by <a href="http://phpalchemy.org">PhpAlchemy</a> Framework</p>
</footer>';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}