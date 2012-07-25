<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /Users/erik/www/project/Sandbox/Application/View/templates/navbar.djt */
function haanga_384a9ba687432e71b8fa88c8f761d9d9f50a01f9($vars1500b122ff1f02, $return=FALSE, $blocks=array())
{
    extract($vars1500b122ff1f02);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<!-- Navbar ================================================== -->
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button"class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="./index.html">Bootstrap</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="">
                <a href="./index.html">Overview</a>
              </li>
              <li class="active">
                <a href="./scaffolding.html">Scaffolding</a>
              </li>
              <li class="">
                <a href="./base-css.html">Base CSS</a>
              </li>
              <li class="">
                <a href="./components.html">Components</a>
              </li>
              <li class="">
                <a href="./javascript.html">Javascript plugins</a>
              </li>
              <li class="">
                <a href="./less.html">Using LESS</a>
              </li>
              <li class="divider-vertical"></li>
              <li class="">
                <a href="./download.html">Customize</a>
              </li>
              <li class="">
                <a href="./examples.html">Examples</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}