<?php
/* Smarty version 3.1.31, created on 2017-09-19 15:46:31
  from "/home/bzt-user/webroot/web151/src/engine/templates/login_form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59c11fb7ed6741_89636439',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '60c859b83d247c2ed824b150f0ff5c1aed82bc9c' => 
    array (
      0 => '/home/bzt-user/webroot/web151/src/engine/templates/login_form.tpl',
      1 => 1505828768,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59c11fb7ed6741_89636439 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
    <body>
        <h1>Login</h1>
        <form action="login_try" method="POST">
            <label>Username: <input type="text" name="login"></label>
            <label>Passwort: <input type="password" name="passwort"></label>
            <button type="submit">login</button>
        </form>
    </body>
</html><?php }
}
