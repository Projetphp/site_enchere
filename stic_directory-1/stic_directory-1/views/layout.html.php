<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>STIC Directory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?= url_for('public/css/bootstrap.min.css') ?>" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="<?= url_for('public/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= url_for('public/css/jquery.Jcrop.css') ?>" type="text/css">
   
    

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <!-- <link rel="shortcut icon" href="public/ico/favicon.ico" /> -->
  </head>

  <body data-spy="scroll" data-target=".subnavspy">

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?= url_for('/') ?>">STIC Directory</a>
          <div class="nav-collapse collapse">
            <ul class="nav"><!-- menu header -->
              <li class="<?= current_menu('/') ?>"><a href="<?= url_for('/') ?>">Home</a></li>
              <!--<li class="<?= current_menu('/people') ?>"><a href="<?= url_for('/people') ?>">People</a></li>-->
              <li class="<?= current_menu('/catalog') ?>"><a href="<?= url_for('/catalog') ?>">Products</a></li>
              <li class="<?= current_menu('/about') ?>"><a href="<?= url_for('/about') ?>">society</a></li>

              <?php if (empty($user)): ?>
              <li class="<?= current_menu('/signup') ?>"><a href="<?= url_for('/signup') ?>">Sign up</a></li>
              <?php else: ?>
              <li class="<?= current_menu('/my_product') ?>"><a href="<?= url_for('/my_product') ?>">my products</a></li>
              <li class="<?= current_menu('/my_bid') ?>"><a href="<?= url_for('/my_bid') ?>">my bid</a></li>
              <li class="<?= current_menu('/my_profile') ?>"><a href="<?= url_for('/my_profile') ?>">Profile</a></li>
              <?php endif; ?>
            </ul><!-- fin menu-->
            <?php if (isset($user)): ?>
            <p class="navbar-text pull-right">
              Logged in as <a href="<?= url_for('/my_profile') ?>" class="navbar-link"><?= $user['prenomUser'] . ' ' . $user['nomUser'] ?></a>
            </p>
            <?php else: ?>
            <form class="navbar-form pull-right" action="<?= url_for('/signin_action') ?>" method="post">
              <input class="span2" type="text" placeholder="Email" name="user[email]" />
              <input class="span2" type="password" placeholder="Password" name="user[password]" />
              <button type="submit" class="btn">Sign in</button>
            </form>
            <?php endif; ?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
    
      <?php if (flash_now('success')): ?>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <?= flash_now('success') ?>
        </div>
      <?php endif; ?>

      <?= $content ?>

      <hr>

      <footer>
        <p>&copy; Company 2012</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?= url_for('public/js/jquery.min.js') ?>"></script>
    <script src="<?= url_for('public/js/bootstrap.js') ?>"></script>
    <script src="<?= url_for('public/js/jquery.Jcrop.js') ?>"></script>

    <script type="text/javascript">
      jQuery(function($) {
        $('.subnavspy .nav-list li').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');
        })
      });
      ////////////////////////////////
      //AUTO COMPLETION

      $(function(){
          $('.typeahead').typeahead({
              items:4,
              minLength:1,
              source: <?php $i=1; echo '['; 
                        $i=0;
                                        while ($i <= count($pseudos, COUNT_RECURSIVE)){
                                          $j=0;
                                          while($j <= count($pseudos, COUNT_RECURSIVE)){
                                              //if($i == count($pseudos) && $j == count($pseudos) && isset($pseudos[$i][$j])){
                                              //}
                                              if (isset($pseudos[$i][$j]) && $pseudos != " " && $i != count($pseudos) && $j != count($pseudos)){
                                                @$pseudo .="'".$pseudos[$i][$j]."',";
                                              }
                                              else if ($i === count($pseudos) && $j === count($pseudos)){
                                                @$pseudo .="'".$pseudos[$i][$j]."'";
                                              }
                                              $j++;
                                          }
                                          $i++;
                                        }
                                        print_r($pseudo);
                                        echo ']'; ?>
          });
      });
      /////////////////////////////
</script>
  </body>
</html>