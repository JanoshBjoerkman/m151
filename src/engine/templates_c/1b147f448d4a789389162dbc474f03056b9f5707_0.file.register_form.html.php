<?php
/* Smarty version 3.1.31, created on 2017-12-02 13:00:41
  from "/home/bzt-user/webroot/web151/src/engine/templates/register_form.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2295e95a00f5_32961976',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1b147f448d4a789389162dbc474f03056b9f5707' => 
    array (
      0 => '/home/bzt-user/webroot/web151/src/engine/templates/register_form.html',
      1 => 1512216006,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.html' => 1,
  ),
),false)) {
function content_5a2295e95a00f5_32961976 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="">

<?php $_smarty_tpl->_subTemplateRender('file:head.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</h1>
                <form action="register" method="POST" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email:</label>
                        <div class="col-sm-5">
                            <input type="email" name="email" id="email" class="form-control" value="" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password1" class="col-sm-2 control-label">Passwort:</label>
                        <div class="col-sm-5">
                            <input type="password" name="password1" id="password1" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Mindestens: 8 Zeichen, ein Grossbuchstabe, ein Kleinbuchstabe, eine Zahl" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password2" class="col-sm-2 control-label">Passwort bestätigen:</label>
                        <div class="col-sm-5">
                            <input type="password" name="password2" id="password2" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Mindestens: 8 Zeichen, ein Grossbuchstabe, ein Kleinbuchstabe, eine Zahl" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Rechnungsaddresse:</label>
                        <div class="col-sm-5">
                            <input type="text" name="address" id="address" class="form-control" value="" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="plz" class="col-sm-2 control-label">PLZ:</label>
                        <div class="col-sm-2">
                            <input type="number" name="plz" id="plz" min="1000" max="9999" class="form-control" required="required" title="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ort" class="col-sm-2 control-label">Ort:</label>
                        <div class="col-sm-3">
                            <input type="text" name="ort" id="ort" class="form-control" value="" required="required" title="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <button type="submit" class="btn btn-primary">Registrieren</button>
                        </div>
                    </div>
                </form>

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

</html><?php }
}
