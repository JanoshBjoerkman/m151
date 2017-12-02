<?php
/* Smarty version 3.1.31, created on 2017-12-02 12:32:08
  from "/home/bzt-user/webroot/web151/src/engine/templates/home.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a228f388fb9f9_20300238',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c03b387b0350a5634fa14a5b61b77e67338345f8' => 
    array (
      0 => '/home/bzt-user/webroot/web151/src/engine/templates/home.html',
      1 => 1512141121,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a228f388fb9f9_20300238 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_smarty_tpl->tpl_vars['tab_title']->value;?>
</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"><?php echo '</script'; ?>
>
            <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
        <![endif]-->
</head>

<body>

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <ul class="nav navbar-nav">
            <li class="<?php echo $_smarty_tpl->tpl_vars['li_class_kurse']->value;?>
">
                <a href="<?php echo $_smarty_tpl->tpl_vars['href_kurse']->value;?>
">Kurse</a>
            </li>
            <li class="<?php echo $_smarty_tpl->tpl_vars['li_class_meine_kurse']->value;?>
">
                </liclass>
                <a href="<?php echo $_smarty_tpl->tpl_vars['href_meine_kurse']->value;?>
">Meine Kurse</a>
            </li>
        </ul>
    </nav>


    <!-- jQuery -->
    <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"><?php echo '</script'; ?>
>
    <!-- Bootstrap JavaScript -->
    <?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"><?php echo '</script'; ?>
>
</body>

</html><?php }
}
