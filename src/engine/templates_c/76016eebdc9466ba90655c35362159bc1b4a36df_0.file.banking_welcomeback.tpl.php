<?php
/* Smarty version 3.1.31, created on 2017-11-01 16:04:49
  from "/home/bzt-user/webroot/referat/src/engine/templates/banking_welcomeback.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59f9e291279150_35870210',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '76016eebdc9466ba90655c35362159bc1b4a36df' => 
    array (
      0 => '/home/bzt-user/webroot/referat/src/engine/templates/banking_welcomeback.tpl',
      1 => 1509548685,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59f9e291279150_35870210 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
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


    <nav class="navbar navbar-default" role="navigation">
        <a class="navbar-brand" href="/referat">E-Banking</a>
        <ul class="nav navbar-nav">
            <li class="active">
                <a href="#">Home</a>
            </li>
            <li>
                <a href="#">Link</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1>Balance: 4203.75$</h1>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Send to</th>
                            <th>submit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="number">$</td>
                            <td><input type="email" value=""></td>
                            <td>
                                <button type="button" class="btn btn-primary">send</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <a class="btn btn-default" href="/referat/logout" role="button">logout</a>

                </div>
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
