<div id="feedback_div">
<? if ($mail_sent):
echo "Thank you for your feedback!";
endif;
?>
<span><? if ($user_type == 'Merchant'):
 		echo 'Merchant';
		else: 
		 echo 'Customer'; 
		endif;
		 ?>
         Feedback Center 
</span>
We're here to help you with anything.  
Help us make your experience better or tell us what you like!
<?php echo $form->create('Feedback'); ?>
	<?php echo $form->input('description',array('type'=>'textarea','label'=>false)); ?>
    <? if ($user_type == 'Merchant'):
 		echo $ajax->submit('Send',array('url'=>array('controller'=>'merchants','action'=>'merchant_feedback'),'update'=>'feedback_div'));
		else: 
		echo $ajax->submit('Send',array('url'=>array('controller'=>'users','action'=>'user_feedback'),'update'=>'feedback_div'));
		endif;
		 ?>
<? echo $form->end(); ?>      
</div>