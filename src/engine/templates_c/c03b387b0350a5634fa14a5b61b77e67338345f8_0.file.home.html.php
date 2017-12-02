<?php
/* Smarty version 3.1.31, created on 2017-12-02 14:25:58
  from "/home/bzt-user/webroot/web151/src/engine/templates/home.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a22a9e646f236_72182942',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c03b387b0350a5634fa14a5b61b77e67338345f8' => 
    array (
      0 => '/home/bzt-user/webroot/web151/src/engine/templates/home.html',
      1 => 1512221080,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.html' => 1,
    'file:scripts.html' => 1,
  ),
),false)) {
function content_5a22a9e646f236_72182942 (Smarty_Internal_Template $_smarty_tpl) {
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
                <li class="<?php echo $_smarty_tpl->tpl_vars['li_class_kurse']->value;?>
">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['href_kurse']->value;?>
">Kurse</a>
                </li>
                <li class="<?php echo $_smarty_tpl->tpl_vars['li_class_meine_kurse']->value;?>
">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['href_meine_kurse']->value;?>
">Meine Kurse</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_smarty_tpl->tpl_vars['Account_Email']->value;?>
 <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['href_personen']->value;?>
">Personen</a></li>
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
