<?php /* Smarty version Smarty-3.1.8, created on 2012-07-11 00:41:50
         compiled from "/Users/erik/www/project/Sandbox/application/View/Test/contact.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19726233154ffcfd4c1ec170-22664205%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '45303befe003257e11d51299d2c5f345ef645f1e' => 
    array (
      0 => '/Users/erik/www/project/Sandbox/application/View/Test/contact.tpl',
      1 => 1341981709,
      2 => 'file',
    ),
    'd206deb466b9204f82892f55a4eaa6c62d7d37a7' => 
    array (
      0 => '/Users/erik/www/project/Sandbox/application/View/master.tpl',
      1 => 1341978323,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19726233154ffcfd4c1ec170-22664205',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4ffcfd4c292087_17459586',
  'variables' => 
  array (
    'baseurl' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ffcfd4c292087_17459586')) {function content_4ffcfd4c292087_17459586($_smarty_tpl) {?><<?php ?>?php use Alchemy\Adapter\PhtmlView; ?<?php ?>>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title> personalized</title>
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
assets/framework/css/style.css">
        <!--[if lt IE 9]>
        <script src=<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
assets/framework/js/html5.js"></script>
        <![endif]-->
    </head>

    <body>
        <div class="container">
            
    <h1>This is a personalized template</h1>
    <table border="1">
        <tr><td width="30%"><h2>Sample</h2></td>
        <td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['form_widget'][0][0]->formWidget(array('id'=>'contact_form'),$_smarty_tpl);?>
</td></tr>
    </table>

            <footer>
                <p>Powered by <a href="https://www.phpalchemy.org">PHPAlchemy Framework</a></p>
            </footer>
        </div>
        <script src="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
assets/framework/js/jquery.js"></script>
        <script src="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
assets/framework/js/bootstrap.js"></script>
    </body>
</html>

<?php }} ?>