<?php
/* Smarty version 3.1.31, created on 2017-12-02 12:59:11
  from "/home/bzt-user/webroot/web151/src/engine/templates/entry_point.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a22958f1141b8_93567965',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '053d4cfd845f50aa65b844268642fd2132668f22' => 
    array (
      0 => '/home/bzt-user/webroot/web151/src/engine/templates/entry_point.html',
      1 => 1512215595,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.html' => 1,
  ),
),false)) {
function content_5a22958f1141b8_93567965 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="de">

<?php $_smarty_tpl->_subTemplateRender('file:head.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="page-header">
                    <h1><?php echo $_smarty_tpl->tpl_vars['page_header']->value;?>
</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12 col-md-6 col-lg-6">
                <p>Bitte loggen Sie sich ein, um unseren Service zu nutzen.</p>
                <form action="login" method="POST" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email:</label>
                        <div class="col-sm-8">
                            <input type="email" name="email" id="email" class="form-control" value="" required="required" title="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Passwort:</label>
                        <div class="col-sm-8">
                            <input type="password" name="password" id="password" class="form-control" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Mindestens: 8 Zeichen, ein Grossbuchstabe, ein Kleinbuchstabe, eine Zahl" title="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-md-12 col-md-6 col-lg-6">
                <p>Oder registrieren Sie sich kostenlos:</p>
                <a class="btn btn-primary" href="register" role="button">Registrierung</a>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"><?php echo '</script'; ?>
>
    <!-- Bootstrap JavaScript -->
    <?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"><?php echo '</script'; ?>
>
</body>

</html<?php }
}
