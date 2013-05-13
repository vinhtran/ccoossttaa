<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title><?php echo $title; ?></title>
    <meta property="og:title" content="<?php echo $title; ?>"/>
    <meta property="og:description" content="<?php echo $description?>" />
    <meta property="og:type" content="game"/>
    <meta property="og:image" content="<?php echo $image?>"/>
    <!-- <meta property="og:site_name" content=""/> -->
    <meta property="fb:app_id" content="<?php echo $appID?>"/>
    <!-- <meta property="fb:admins" content="1245056983"/> -->
    <meta property="og:url" content="<?php echo $url ?>"/>

    <!-- <meta property="og:video" content="<?php //echo $videoUrl; ?>"/>
    <meta property="og:video:width" content="<?php //echo $videoWidth?>" />
    <meta property="og:video:height" content="<?php //echo $videoHeight?>" />
    <meta property="og:video:type" content="application/x-shockwave-flash" /> -->
    <meta http-equiv="refresh" content="0; url='<?php echo $callbackUrl?>'" />
  </head>
  <body></body>
</html>
