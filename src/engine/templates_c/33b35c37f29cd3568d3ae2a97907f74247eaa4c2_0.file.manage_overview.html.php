<?php
/* Smarty version 3.1.31, created on 2017-12-02 17:02:21
  from "/home/bzt-user/webroot/web151/src/engine/templates/manage_overview.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a22ce8dad41f9_18378682',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '33b35c37f29cd3568d3ae2a97907f74247eaa4c2' => 
    array (
      0 => '/home/bzt-user/webroot/web151/src/engine/templates/manage_overview.html',
      1 => 1512229021,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.html' => 1,
    'file:scripts.html' => 1,
  ),
),false)) {
function content_5a22ce8dad41f9_18378682 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="de">

<?php $_smarty_tpl->_subTemplateRender('file:head.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<body>
    <nav class="navbar navbar-default " role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li class="<?php echo $_smarty_tpl->tpl_vars['li_class_overview']->value;?>
">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['href_overview']->value;?>
">Übersicht</a>
                </li>
                <li class="<?php echo $_smarty_tpl->tpl_vars['li_class_events']->value;?>
">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['href_events']->value;?>
">Events</a>
                </li>
                <li class="<?php echo $_smarty_tpl->tpl_vars['li_class_kurse']->value;?>
">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['href_kurse']->value;?>
">Kurse</a>
                </li>
                <li class="<?php echo $_smarty_tpl->tpl_vars['li_class_benutzer']->value;?>
">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['href_benutzer']->value;?>
">Benutzer</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_smarty_tpl->tpl_vars['Account_Email']->value;?>
 <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['href_einstellungen']->value;?>
">Einstellungen</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['href_logout']->value;?>
">Abmelden</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <?php $_smarty_tpl->_subTemplateRender("file:scripts.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>

</html><?php }
}
