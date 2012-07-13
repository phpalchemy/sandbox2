<?php use Alchemy\Adapter\PhtmlView; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>{block name=title}Default Page Title{/block}</title>
        <link rel="stylesheet" type="text/css" href="{$baseurl}assets/framework/css/style.css">
        <!--[if lt IE 9]>
        <script src={$baseurl}assets/framework/js/html5.js"></script>
        <![endif]-->
    </head>

    <body>
        <div class="container">
            {block name=body}{/block}
            <footer>
                <p>Powered by <a href="https://www.phpalchemy.org">PHPAlchemy Framework</a></p>
            </footer>
        </div>
        <script src="{$baseurl}assets/framework/js/jquery.js"></script>
        <script src="{$baseurl}assets/framework/js/bootstrap.js"></script>
    </body>
</html>

