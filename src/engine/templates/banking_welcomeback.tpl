<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$title}</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>