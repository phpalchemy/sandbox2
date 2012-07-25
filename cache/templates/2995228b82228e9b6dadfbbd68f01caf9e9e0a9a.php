<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /Users/erik/www/project/Sandbox/Application/View/templates/Main/index.djt */
function haanga_2995228b82228e9b6dadfbbd68f01caf9e9e0a9a($vars1500b122ff1f02, $return=FALSE, $blocks=array())
{
    extract($vars1500b122ff1f02);
    if ($return == TRUE) {
        ob_start();
    }
    $buffer1  = '
    '.Haanga::Load('navbar.djt', $vars1500b122ff1f02, TRUE, $blocks).'

    <div class="container">
        '.htmlspecialchars($title).'
        <hr />
        '.Haanga::Load('footer.djt', $vars1500b122ff1f02, TRUE, $blocks).'
    </div>
';
    $blocks['body']  = (isset($blocks['body']) ? (strpos($blocks['body'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['body'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['body'])) : $buffer1);
    echo Haanga::Load('master.djt', $vars1500b122ff1f02, TRUE, $blocks);
    if ($return == TRUE) {
        return ob_get_clean();
    }
}