<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>UQx Relective Journal</title>

    <!-- Bootstrap -->
    <link href="www/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="www/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="www/jqcloud/jqcloud.min.css" />
    <script type="text/javascript" src="www/jqcloud/jqcloud.min.js"></script>
    <script src="www/js/validator.min.js"></script>
    <script src="www/js/summernote/summernote.min.js"></script>
    <link rel="stylesheet" type="text/css" href="www/js/summernote/summernote.css" />
    <style>
    .word {
    	font-family: Verdana, Tahoma, Arial;
    	padding: 4px 4px 4px 4px;
    	letter-spacing: 3px;
    	text-decoration: none;
    	font-weight: normal;
    }
    .size9 {
    	color: #000;
    	font-size: 30px;
    }
    .size8 {
    	color: #111;
    	font-size: 28px;
    }
    .size7 {
    	color: #222;
    	font-size: 26px;
    }
    .size6 {
    	color: #333;
    	font-size: 24px;
    }
    .size5 {
    	color: #444;
    	font-size: 22px;
    }
    .size4 {
    	color: #555;
    	font-size: 20px;
    }
    .size3 {
    	color: #666;
    	font-size: 18px;
    }
    .size2 {
    	color: #777;
    	font-size: 16px;
    }
    .size1 {
    	color: #888;
    	font-size: 10px;
    }
    .size0 {
       color: #999;
       font-size: 7px;
    }
    </style>
  </head>
  <body>
    <div class="container">

      <div class="row">
        <div class="header clearfix">
          <?php if ($warning_msg!='') { ?>
            <div class="alert alert-info" role="alert"><?php echo $warning_msg ?></div>
          <?php } ?>
          <?php if ($config['is_dev']) { ?>
            <div class="alert alert-danger" role="alert">Dev Version - DO NOT USE IN COURSES - contact UQx Technical Team</div>
          <?php } ?>
        </div>
      </div>
      <?php require_once('routes.php'); ?>

    </div><!-- /.container -->
  </body>
</html>
