<div class="MbMainCont">
	<h1 class="Hide">Register</h1>
	<div class="MbFrmWrap">
        <?php
      !isset($form) && $form = new nfWinnerContactForm();

      $msgs = array();
      foreach ($form->getErrorSchema()->getErrors() as $error) {
        $msg = $error->getMessage();
        !in_array($msg, $msgs) && ($msgs[] = '<p class="Error">'.$msg.'</p>');
      }

      count($msgs)/*  && sort($msgs) */;?>
      <?php echo $form->renderFormTag(url_for('@mobile_winner_contact', true), array('method' => 'post', 'id' => 'coordinatesForm', 'class' => 'MbFrm'))?>
      		<?php $lastName = $form['last_name'];?>
            <div class="MbInputWrap ShowHideLabel <?php echo $lastName->hasError() ? ' Error' : '';?>">
                <span>nom</span>
                <?php

                echo $lastName->render(array(
                  'class' => 'MbInputSt AutoBlurText',
                  'alt' => 'nom',
                  'maxlength' => 255
                ))?>
            </div>
            <?php $firstName = $form['first_name'];?>
            <div class="MbInputWrap ShowHideLabel <?php echo $firstName->hasError() ? ' Error' : '';?>">
            	<span>prénom</span>
            	<?php

                echo $firstName->render(array(
                  'class' => 'MbInputSt AutoBlurText'.($lastName->hasError() ? ' Error' : ''),
                  'alt' => 'prénom',
                  'maxlength' => 255
                ))?>
            </div>
            <?php $emailAddress = $form['email_address'];?>
            <div class="MbInputWrap ShowHideLabel <?php echo $emailAddress->hasError() ? ' Error' : '';?>">
            	<span>votre adresse email</span>
            	<?php

                echo $emailAddress->render(array(
                  'class' => 'MbInputSt AutoBlurText'.($emailAddress->hasError() ? ' Error' : ''),
                  'alt' => 'votre adresse email',
                  'maxlength' => 255
                ))?>
            </div>
            <?php $mailingAddress = $form['mailing_address'];?>
            <div class="MbInputWrap ShowHideLabel <?php echo $mailingAddress->hasError() ? ' Error' : '';?>">
            	<span>adresse postale</span>
            	<?php

                echo $mailingAddress->render(array(
                  'class' => 'MbInputSt AutoBlurText'.($mailingAddress->hasError() ? ' Error' : ''),
                  'alt' => 'adresse postale',
                  'maxlength' => 500
                ))?>
            </div>
            <?php $zipCode = $form['zip_code'];?>
            <div class="MbInputWrap ShowHideLabel <?php echo $zipCode->hasError() ? ' Error' : '';?>">
            	<span>code postal</span>
            	<?php

                echo $zipCode->render(array(
                  'class' => 'MbInputSt AutoBlurText'.($zipCode->hasError() ? ' Error' : ''),
                  'alt' => 'code postal',
                  'maxlength' => 5
                ))?>
            </div>
            <?php $form->isCSRFProtected() && print($form['_csrf_token']->render())?>
            <div class="MbBtnWrap">
                <input type="submit" value="je valide" class="MbSubmitSt" />
            </div>
        </form>
    </div>
</div>