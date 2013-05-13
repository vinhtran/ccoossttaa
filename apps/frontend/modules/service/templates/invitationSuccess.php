<?php
include_partial('shareFacebook',
array('appID' => $partialVars['appID'],
'title' => $partialVars['title'],
'description' => $partialVars['description'],
'image' => $partialVars['image'],
'url' => $partialVars['url'],
'callbackUrl' => $partialVars['callbackUrl']
))?>