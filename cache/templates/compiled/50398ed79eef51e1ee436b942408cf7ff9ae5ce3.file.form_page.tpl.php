<?php /* Smarty version Smarty-3.1.8, created on 2012-07-11 00:33:28
         compiled from "/Users/erik/www/project/Sandbox/application/View/uigen/form_page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:587186444ffd0218dcf335-73750307%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '50398ed79eef51e1ee436b942408cf7ff9ae5ce3' => 
    array (
      0 => '/Users/erik/www/project/Sandbox/application/View/uigen/form_page.tpl',
      1 => 1341981003,
      2 => 'file',
    ),
    'd206deb466b9204f82892f55a4eaa6c62d7d37a7' => 
    array (
      0 => '/Users/erik/www/project/Sandbox/application/View/master.tpl',
      1 => 1341978323,
      2 => 'file',
    ),
    '10a2f742e8b6c6dcab76b6369e57e31bf6980260' => 
    array (
      0 => '/Users/erik/www/project/Sandbox/application/View/uigen/form.tpl',
      1 => 1341981030,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '587186444ffd0218dcf335-73750307',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baseurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4ffd0218f04512_02555425',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ffd0218f04512_02555425')) {function content_4ffd0218f04512_02555425($_smarty_tpl) {?><<?php ?>?php use Alchemy\Adapter\PhtmlView; ?<?php ?>>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>My Page Title</title>
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
assets/framework/css/style.css">
        <!--[if lt IE 9]>
        <script src=<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
assets/framework/js/html5.js"></script>
        <![endif]-->
    </head>

    <body>
        <div class="container">
            
<?php /*  Call merged included template "uigen/form.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('uigen/form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '587186444ffd0218dcf335-73750307');
content_4ffd0218eadae2_91608831($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "uigen/form.tpl" */?>

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

<?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2012-07-11 00:33:28
         compiled from "/Users/erik/www/project/Sandbox/application/View/uigen/form.tpl" */ ?>
<?php if ($_valid && !is_callable('content_4ffd0218eadae2_91608831')) {function content_4ffd0218eadae2_91608831($_smarty_tpl) {?><div class="form-view" style="width:600px">
    <div class="form-header">
        <h3><?php echo $_smarty_tpl->tpl_vars['form']->value->title;?>
</h3>
    </div>
    <div class="form-body form-horizontal">
        <span>
            <form name="<?php echo $_smarty_tpl->tpl_vars['form']->value->name;?>
" action="<?php echo $_smarty_tpl->tpl_vars['form']->value->action;?>
" method="post">
                <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['form']->value->getWidgets(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value){
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                <div class="control-group">
                    <label class="control-label" for="<?php echo $_smarty_tpl->tpl_vars['widget']->value->getId();?>
"><?php echo $_smarty_tpl->tpl_vars['widget']->value->getFieldLabel();?>
</label>
                    <div class="controls"><?php echo $_smarty_tpl->tpl_vars['widget']->value->getGenerated('html');?>
</div>
                </div>
                <?php } ?>
                <hr/>
                <div align="right" style="padding-right: 20px">
                    <button class="btn" type="submit">Save changes</button>
                    <button class="btn">Cancel</button>
                </div>
            </form>
        </span>
    </div>
</div><?php }} ?>