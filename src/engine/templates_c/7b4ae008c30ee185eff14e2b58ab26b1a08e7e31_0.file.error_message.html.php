<?php
/* Smarty version 3.1.31, created on 2017-12-02 13:54:02
  from "/home/bzt-user/webroot/web151/src/engine/templates/error_message.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a22a26a213042_92337022',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7b4ae008c30ee185eff14e2b58ab26b1a08e7e31' => 
    array (
      0 => '/home/bzt-user/webroot/web151/src/engine/templates/error_message.html',
      1 => 1512219113,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.html' => 1,
    'file:scripts.html' => 1,
  ),
),false)) {
function content_5a22a26a213042_92337022 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="de">

<?php $_smarty_tpl->_subTemplateRender('file:head.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="text-center"><?php echo $_smarty_tpl->tpl_vars['h1']->value;?>
</h1>

                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong><?php echo $_smarty_tpl->tpl_vars['alert_title']->value;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['alert_body']->value;?>

                </div>
            </div>
        </div>
    </div>
    <?php $_smarty_tpl->_subTemplateRender("file:scripts.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>

</html><?php }
}
