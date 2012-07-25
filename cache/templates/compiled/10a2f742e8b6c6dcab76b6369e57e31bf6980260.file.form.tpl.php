<?php /* Smarty version Smarty-3.1.8, created on 2012-07-11 00:33:36
         compiled from "/Users/erik/www/project/Sandbox/application/View/uigen/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5791216714ffcb6366e41b9-64583339%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10a2f742e8b6c6dcab76b6369e57e31bf6980260' => 
    array (
      0 => '/Users/erik/www/project/Sandbox/application/View/uigen/form.tpl',
      1 => 1341981030,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5791216714ffcb6366e41b9-64583339',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4ffcb63672a473_50704780',
  'variables' => 
  array (
    'form' => 0,
    'widget' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ffcb63672a473_50704780')) {function content_4ffcb63672a473_50704780($_smarty_tpl) {?><div class="form-view" style="width:600px">
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