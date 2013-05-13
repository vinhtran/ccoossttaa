<div class="DkTxtInfo">
  <p class="Dktxt04">Augmentez vos chances<br />de gagner en invitant vos amis :</p>
  <p class="Dktxt05">s’ils gagnent un Nokia LUMIA vous  gagnez aussi</p>
  <a id="inviteBtn" class="BtnJe" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(url_for('@service_invitation?inviter_id='.$sf_user->getFbUserId(), TRUE));?>" onclick="_gaq.push(['_trackEvent', 'Je parraine bouton', 'cliqué'])"><span>je parraine</span></a>
  <p class="DkAbtxt">DAS : 0.94 W/Kg <span>Photo non contractuelle</span></p>
</div>
<?php include_partial('inviteBlock.js')?>
