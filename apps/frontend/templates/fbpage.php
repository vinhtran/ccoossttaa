<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>

        <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('favicon.ico', true) ?>" />

        <?php include_stylesheets() ?>
        <!--[if IE]>
        <link type="text/css" rel="stylesheet" href="<?php echo stylesheet_path('ie-fix.css', true) ?>">
        <![endif]-->

        <?php include_javascripts() ?>
        <?php include_partial('googleAnalytics.js', array('gaAccount' => sfConfig::get('app_googleAnalytics_account'))) ?>
    </head>
    <body>
        <div id="outer_wrapper">
            <div id="inner_wrapper">
                
                <?php has_slot('shareBlock') && get_slot('shareBlock') && include_component('fbapp', 'shareBlock') ?>
                <?php echo $sf_content ?>
                <?php
                include_component('fbapp', 'footer', array(
                    'firstNote' => get_slot('firstNote', NULL),
                    'secondNote' => get_slot('secondNote', NULL)
                ))
                ?>
                <?php
                include_component('facebookBase', 'initScript', array(
                    'lang' => 'fr_FR',
                    'fbFuncName' => get_slot('fbFuncName', 'fb_resize_event')
                        )
                )
                ?>
            </div>   
        </div>
    </body>
</html>
