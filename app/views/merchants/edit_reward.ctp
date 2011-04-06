

<?php $div_name = 'div_'.$div_id; 
	if ($editing): ?>
<div id="<? echo $div_name; ?>">         
<?php echo $form->create('Reward'); ?>
	<div class="left-layer24">
	<?php echo $form->input('description',array('type'=>'text','label'=>false,'value'=>$results['Reward']['description'])); ?>
	</div>
	<div class="left-layer22">
	  <?php $points=range(1,100); 
		 echo $form->select('threshold', $points, array('label'=>false,'selected'=>$results['Reward']['threshold']-1),array('empty'=>false)); ?>

	</div>
    <div class="left-layer22">
	    <? echo $form->select('smonth', $months, array('selected'=>date('M',strtotime($results['Reward']['start_date']))));?>
	    <? echo $form->select('sdate', $dates,array('selected'=>date('j',strtotime($results['Reward']['start_date']))));?>
	    <? echo $form->select('syear', $years,array('selected'=>(int)date('Y',strtotime($results['Reward']['start_date']))-(int)date('Y')));?>
	</div>
    <div class="left-layer22">
     <? $options=array('Yes'=>'Yes','No'=>'No');
		if (is_null($results['Reward']['end_date'])){
			$attributes = array('legend'=>false,'value'=>'No');
			echo $form->radio('expires',$options,$attributes);
			echo $form->select('emonth', $months);?><br />
	    	<? echo $form->select('edate', $dates);?><br />
	    	<? echo $form->select('eyear', $years);
	
	
		}
		else {
			$attributes = array('legend'=>false,'value'=>'Yes');
			echo $form->radio('expires',$options,$attributes);
	        echo $form->select('emonth', $months, array('selected'=>date('M',strtotime($results['Reward']['end_date']))-(int)date('M'))); ?><br />
		    <? echo $form->select('edate', $dates,array('selected'=>date('j',strtotime($results['Reward']['end_date'])))); ?><br />
	    	<? echo $form->select('eyear', $years,array('selected'=>(int)date('Y',strtotime($results['Reward']['end_date']))-(int)date('Y')));
	
		}
		
	 	?>
</div>
	<div class="left-edit-layer22"> 
   
	<?php echo $ajax->submit('Change',array('url'=>array('controller'=>'merchants','action'=>'edit_reward',$results['Reward']['id']),'update'=>$div_name)); ?>
    </div>
    <div class="right-layer11">
	<?php echo $html->link('Cancel',array('controller'=>'merchants','action'=>'dashboard'),array(),'Are you sure you want to abandon changes?', false); ?>
<?php echo $form->end(); ?>
	</div>
    
</div>

<? else: ?>
	<div class="left-layer24"><? echo $results['Reward']['description'];?></div>
	<div class="left-layer22"><? echo $results['Reward']['threshold']; ?></div>
	<div class="left-layer22"><? echo $results['Reward']['start_date']; ?></div>
	<? $end_date = (is_null($results['Reward']['end_date'])) ? 'none' : date('Ymd',strtotime($reults['Reward']['end_date'])); ?>
	<div class="left-layer22"><? echo $end_date; ?></div>
    
    
<? endif; ?>