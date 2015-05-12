<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 4/24/2015
 * Time: 5:41 PM
 */

require 'bot.php';

if (isset($_GET['msg'])) {
    send($_GET['msg']);
}
?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Markybot</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!--    <link rel="apple-touch-icon" href="apple-touch-icon.png">-->
    <!-- Place favicon.ico in the root directory -->

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/darkly/bootstrap.min.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <style>
        @import url(http://fonts.googleapis.com/css?family=Lobster);
        .jumbotron h1 {
            font-family: 'Lobster', cursive;
            color: #F39C12;
        }
    </style>
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="jumbotron">
    <div class="container text-center">
        <h1>Markybot</h1>
    </div>
</div>

<?php if ( isset($_GET['msg']) ):
    $msg = htmlspecialchars($_GET['msg']) ?>
<div class="container">
    <div class="alert alert-info" role="alert">
        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
        <span class="sr-only">Info:</span>
        Message Sent: <?php echo $msg ?>
    </div>
</div>
<?php endif; ?>

<!-- Add your site or application content here -->
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form>
                <div class="form-group">
                    <label for="msg">Message</label>
                    <textarea id="msg" name="msg" class="form-control" rows="3" maxlength="1000"></textarea>
                </div>
                <button class="btn btn-primary">Send &raquo;</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>


<script>
    (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='https://www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
    ga('create','UA-62217288-1','auto');ga('send','pageview');
</script>
</body>
</html>

