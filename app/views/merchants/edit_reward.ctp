

<?php $div_name = 'div_'.$div_id; 
	if ($editing): ?>
<div id="<? echo $div_name; ?>">         
<?php echo $form->create('Reward'); ?>
	<div class="left-layer14">
	<?php echo $form->input('description',array('type'=>'text','label'=>'Description','value'=>$results['Reward']['description'])); ?>
	</div>
	<div class="left-layer22">
	  <?php $points=range(0,100); 
		 echo $form->select('threshold', $points, array('label'=>'Points','selected'=>$results['Reward']['threshold'])); ?>

	</div>
    <div class="left-layer22">
	    <? echo $form->select('smonth', $months, array('selected'=>date('M',strtotime($results['Reward']['start_date']))));?>
	    <? echo $form->select('sdate', $dates,array('selected'=>date('j',strtotime($results['Reward']['start_date']))));?>
	    <? echo $form->select('syear', $years,array('selected'=>date('Y',strtotime($results['Reward']['start_date']))));?>
	</div>
    <div class="left-layer22">
     <? $options=array('Yes'=>'Yes','No'=>'No');
		$attributes = array('legend'=>false,'value'=>'No');
		echo $form->radio('expires',$options,$attributes);
	 	?>
        <? echo $form->select('emonth', $months, array('selected'=>date('M',strtotime($results['Reward']['end_date']))));?>
	    <? echo $form->select('edate', $dates,array('selected'=>date('j',strtotime($results['Reward']['end_date']))));?>
	    <? echo $form->select('eyear', $years,array('selected'=>date('Y',strtotime($results['Reward']['end_date']))));?>
	</div>
	    
           
	
	<?
	?>
	<div class="left-layer22"> 
   
	<?php echo $ajax->submit('Change',array('url'=>array('controller'=>'merchants','action'=>'edit_reward',$results['Reward']['id']),'update'=>$div_name)); ?>
    </div>
    <div class="right-layer11">
	<?php echo $html->link('Cancel',array('controller'=>'merchants','action'=>'dashboard'),array(),'Are you sure you want to abandon changes?', false); ?>
<?php echo $form->end(); ?>
	
    
    
</div>

<? else: ?>
	<div class="left-layer14"><? echo $results['Reward']['description'];?></div>
	<div class="left-layer22"><? echo $results['Reward']['threshold']; ?></div>
	<div class="left-layer22"><? echo $results['Reward']['start_date']; ?></div>
	<? $end_date = (is_null($results['Reward']['end_date'])) ? 'none' : date('Ymd',strtotime($reults['Reward']['end_date'])); ?>
	<div class="left-layer22"><? echo $end_date; ?></div>
    
    
<? endif; ?>