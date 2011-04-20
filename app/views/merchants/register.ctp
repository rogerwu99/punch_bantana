<? if (is_null($step) || $step==1): ?>
<span class="smallercopy_nav"><span class="smallercopy_nav_sel">General</span> | Reward | Location | Plan</span>
		<? $session->flash(); ?>
            <div class="bodycopy_reg">Sign up</div>
		<?php echo $form->create('Merchant'); ?>
                  <div class="smallercopy_reg">Name</div>
                  <div class='smallercopy_err' style='color:red'><?php echo $form->input('name', array('label'=>false, 'class'=>'required', 'style'=>'width:255px')); ?></div>
                  <div class="smallercopy_reg">Email Address</div>
 				  <div class='smallercopy_err' style='color:red'><?php echo $form->input('email', array('class'=>'required', 'title'=>'Please enter a valid email address', 'style'=>'width:255px', 'label'=>false)); ?></div>
			      <div class="smallercopy_reg">Password</div>
 				  <div class='smallercopy_err' style='color:red'><?php echo $form->input('new_password', array('type' => 'password', 'label'=>false, 'class'=>'required validate-password', 'style'=>'width:255px', 'title'=>'Enter a password greater than 6 characters')); ?></div>
                  <div class="smallercopy_reg">Re-type Password</div>
                  <div class='smallercopy_err' style='color:red'><?php echo $form->input('confirm_password', array('label'=>false, 'type' => 'password', 'class'=>'required validate-password-confirm', 'style'=>'width:255px','title'=>'Enter the same password for confirmation')); ?></div>
                  <div class="smallercopy_reg">Business Name</div>
                  <div class='smallercopy_err' style='color:red'><?php echo $form->input('business_name', array('label'=>false, 'class'=>'required validate-password-confirm', 'style'=>'width:255px','title'=>'Enter the same password for confirmation')); ?></div>
                  <div class="smallercopy_reg">Business Phone</div>
                  <div class='smallercopy_err' style='color:red'><?php echo $form->input('business_phone', array('label'=>false, 'class'=>'required validate-password-confirm', 'style'=>'width:255px','title'=>'Enter the same password for confirmation')); ?></div>
                  <div class="smallercopy_reg">Website</div>
                  <div class='smallercopy_err' style='color:red'><?php echo $form->input('website', array('label'=>false, 'class'=>'required validate-password-confirm', 'style'=>'width:255px','title'=>'Enter the same password for confirmation')); ?></div>
                  <div class="smallercopy_reg">
                             <? echo '<div class="smallercopy_err" style="color:red; margin:10px 0px -20px 0px;">'.$form->error('Merchant.accept').'</div><br />'; ?>
	<?php echo $form->checkbox('Merchant.accept', array('class'=>'required validate-one-required', 'title'=>'Please agree to terms and conditions'));?>Please read our <?php echo $html->link('Terms of Use', array('controller'=>'pages', 'action'=>'terms')); ?> and our <?php echo $html->link('Privacy Policy', array('controller'=>'pages', 'action'=>'privacy')); ?> before accepting.<br /><br />
                      </div>
                  <div class="smallercopy_reg" style="text-align:center;">
    	<?php echo $ajax->submit('Create my Account!', array('url'=>array('controller'=>'merchants','action'=>'register/1'),'update'=>'reg_content'));?>
 	   	
		<?php echo $form->end(); ?>
                  
</div>       
<? elseif ($step==2): ?>
        <span class="smallercopy_nav">General | <span class="smallercopy_nav_selected">Reward</span> | <?php echo $ajax->link('Location',array('controller'=>'merchants','action'=>'register/3'),array('update'=>'reg_content')); ?> | <?php echo $ajax->link('Plan',array('controller'=>'merchants','action'=>'register/5'),array('update'=>'reg_content')); ?></span>
<div class="bodycopy_reg">Create a Reward</div>
		<?php 	$points=range(0,100); 
				$months = array(
							"Jan"=>"Jan",
							"Feb"=>"Feb",
							"Mar"=>"Mar",
							"Apr"=>"Apr",
							"May"=>"May",
							"Jun"=>"Jun",
							"Jul"=>"Jul",
							"Aug"=>"Aug",
							"Sep"=>"Sep",
							"Oct"=>"Oct",
							"Nov"=>"Nov",
							"Dec"=>"Dec"
				);
				$dates=range(1,31);
				$years=range((int)date('Y'),2020);
				  foreach($errors as $key=>$value){ ?>
       <div class='smallercopy_err' style='color:red'> 	<? echo $errors[$key]; ?> </div>
	   <? } 
			  echo $form->create('Merchant');?>
 	              <div class="smallercopy_reg">Enter a Description:</div>
                  <div><?php echo $form->input('reward', array('label'=>false, 'class'=>'required', 'style'=>'width:200px')); ?></div>
                  <div class="smallercopy_reg">Points to Redeem:</div>
 				  <div><? echo $form->select('points',$points); ?></div>
			      <div class="smallercopy_reg">Start Date</div>
 				  <span class="smallercopy_reg"><? 	$options=array('Now'=>'Now','Later'=>'Later');
							$attributes = array('legend'=>false,'value'=>'Now');
							echo $form->radio('start',$options,$attributes);
 							echo $form->select('smonth', $months);
							echo $form->select('sdate', $dates);
							echo $form->select('syear', $years);
						?>
				  </span>
                  <div class="smallercopy_reg">Expiration</div>
                  <div class="smallercopy_reg"><? 	$options=array('No'=>'No','Yes'=>'Yes');
							$attributes = array('legend'=>false,'value'=>'No');
							echo $form->radio('expires',$options,$attributes);
 							echo $form->select('emonth', $months);
							echo $form->select('edate', $dates);	
							echo $form->select('eyear', $years);
						?>
                  </div>
                  <input id="from" name="data[Merchants][from]" type="hidden" value="reg">
                  <div class="smallercopy_reg" style="text-align:center;">
    				<?php echo $ajax->submit('Enter!', array('url'=>array('controller'=>'merchants','action'=>'register/2'),'update'=>'reg_content'));?>
 	   				<?php echo $form->end(); ?>
				    <?php echo $ajax->link('Skip',array('controller'=>'merchants','action'=>'register/3'),array('update'=>'reg_content')); ?>
   			     </div>
<? elseif ($step==3): ?>
			<span class="smallercopy_nav">General | Reward | <span class="smallercopy_nav_selected">Location</span> | <?php echo $ajax->link('Plan',array('controller'=>'merchants','action'=>'register/5'),array('update'=>'reg_content')); ?></span>
 			<div class="bodycopy_reg">Add a Location<br /><span class="smallercopy_cap">(You'll be able to add and modify later)</span></div>
			<?php $states = array(
							"AK"=>"AK",
							"AL"=>"AL",
							"AR"=>"AR",
							"AZ"=>"AZ",
							"CA"=>"CA",
							"CO"=>"CO",
							"CT"=>"CT",
							"DC"=>"DC",
							"DE"=>"DE",
							"FL"=>"FL",
							"GA"=>"GA",
							"HI"=>"HI",
							"IA"=>"IA",
							"ID"=>"ID",
							"IL"=>"IL",
							"IN"=>"IN",
							"KS"=>"KS",
							"KY"=>"KY",
							"LA"=>"LA",
							"MA"=>"MA",
							"MD"=>"MD",	
							"ME"=>"ME",
							"MI"=>"MI",
							"MN"=>"MN",
							"MO"=>"MO",
							"MS"=>"MS",
							"MT"=>"MT",
							"NC"=>"NC",
							"ND"=>"ND",
							"NE"=>"NE",
							"NH"=>"NH",
							"NJ"=>"NJ",
							"NM"=>"NM",
							"NV"=>"NV",
							"NY"=>"NY",
							"OH"=>"OH",
							"OK"=>"OK",
							"OR"=>"OR",
							"PA"=>"PA",
							"RI"=>"RI",
							"SC"=>"SC",
							"SD"=>"SD",
							"TN"=>"TN",
							"TX"=>"TX",
							"UT"=>"UT",
							"VA"=>"VA",
							"VT"=>"VT",
							"WA"=>"WA",
							"WI"=>"WI",
							"WV"=>"WV",
							"WY"=>"WY"
							);
			 
			  echo $form->create('Merchant');?>
 	              <div class="smallercopy_reg"> Name or Description :</div>
                  <div><?php echo $form->input('des', array('label'=>false, 'class'=>'required', 'style'=>'width:200px')); ?></div>
                  <div class="smallercopy_reg"> Address:</div>
 				  <div><?php echo $form->input('Address', array('label'=>false, 'class'=>'required', 'style'=>'width:200px')); ?></div>
			      <div class="smallercopy_reg">City:</div>
				  <div><?php echo $form->input('City', array('label'=>false, 'class'=>'required', 'style'=>'width:150px')); ?></div>
                  <div class="smallercopy_reg" style="float:right;margin-right:-140px;margin-top:-44px;">State:</div>
                  <div style="float:right;margin-right:65px;margin-top:-24px;"><? echo $form->select('State', $states);?></div></span>
                  <? $max_visits = range(1,10); ?>
        		  <div class="smallercopy_reg">Maximum Visits Per Day</div>
        		  <div><?php echo $form->input('max_visits',array('type' =>'select', 'label'=>false, 'options' => $max_visits,'selected' => 0)); ?></div>
                  <div class="smallercopy_reg" style="text-align:center;">
    				<?php echo $ajax->submit('Enter!', array('url'=>array('controller'=>'merchants','action'=>'register/3'),'update'=>'reg_content'));?>
 	   				<?php echo $form->end(); ?>
				    <?php echo $ajax->link('Skip',array('controller'=>'merchants','action'=>'register/5'),array('update'=>'reg_content')); ?>
   			     </div> 
<? elseif ($step==4): ?>
				<span class="smallercopy_nav">General | Reward | <span class="smallercopy_nav_selected">Location</span> | <?php echo $ajax->link('Plan',array('controller'=>'merchants',	'action'=>'register/5'),array('update'=>'reg_content')); ?></span>
<div class="bodycopy_reg">Location Created</div>
	 	    <div class="smallercopy_reg"> QR Code for Location: <? echo $loc_name; ?></div>
                  <div class="smallercopy_reg" style="text-align:center;">
                  <? echo $html->image('qrcodes/'.$qr_path, array('alt' => 'qr_code', 'width' => 87, 'height' => 87, 'class' => 'top')); ?>
                  <br />
			    <?	 echo $ajax->link('Next',array('controller'=>'merchants','action'=>'register/5'),array('update'=>'reg_content')); ?>
   			     <br />
                 Print this QR Code for your customers to scan.  You can also display this code on your mobile device.  A copy can be emailed to you.  
                 <br />
                 <a href="JavaScript:window.print();">Print </a>  / <? echo $ajax->link('Email',array('controller'=>'merchants','action'=>'register/4'),array('update'=>'reg_content')); ?>
                 </div>   
<? elseif ($step==5): ?>

			<span class="smallercopy_nav">General | Reward | Location | <span class="smallercopy_nav_selected">Plan</span></span>
<? if ($mail_sent): ?>
<div class="smallercopy_err" style='color:red'>Your email was sent!</div>
<? endif; ?>
 			<div class="bodycopy_reg">Select a Plan</div>
            <? echo $form->create('Merchant', array('action'=>'register/6')); ?>

            <div class="smallercopy_reg">Select a plan from the options below.<br />
            	<input type="radio" name="data[Merchant][plan]" value="Basic" disabled="disabled"><span style="text-decoration: line-through; ">Basic Membership</span><br>
				<input type="radio" name="data[Merchant][plan]" value="Pro" disabled="disabled"><span style="text-decoration: line-through; ">Pro Membership</span> <br>
				<input type="radio" name="data[Merchant][plan]" value="Free" checked> 2 Month FREE Trial<br />
			<span class="smallercopy">Monthly Fees per location.</span>
            </div>
 	              <div class="smallercopy_reg" style="text-align:center;">
    				<?php echo $form->submit('Enter!', array('url'=>array('controller'=>'merchants','action'=>'register/6')));?>
 	   				<?php echo $form->end(); ?>
	   			     </div> 
	


<? endif; ?>