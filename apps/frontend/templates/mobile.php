<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <meta name="viewport" content="width=640, initial-scale=0.5, user-scalable=yes" />
    <meta name="format-detection" content="telephone=no" />
    <?php include_title() ?>

    <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('favicon.ico', true)?>" />
    <link rel="apple-touch-icon" href="<?php echo image_path('apple-touch-icon.png', true)?>" />

    <?php include_stylesheets() ?>
    <!--[if IE]>
    <link type="text/css" rel="stylesheet" href="<?php echo stylesheet_path('ie-css-fix.css', true)?>">
    <![endif]-->

    <?php include_javascripts() ?>

  </head>
  <body>
	  <div class="MbPage">
    	<?php include_component('mobile', 'header')?>

    	<?php echo $sf_content?>

        <?php include_component('mobile', 'footer')?>
      </div>
  </body>
</html>
