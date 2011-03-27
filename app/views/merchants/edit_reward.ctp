

<?php $div_name = 'div_'.$div_id; 
//echo $form->create(null, array('url' => array('controller'=>'merchants','action' => 'rewards'))); ?>
<? if ($editing): ?>
<div id="<? echo $div_name; ?>">         
<?php echo $form->create('Reward'); 

?>
	<table><tr><td colspan=3>
	<?php echo $form->input('description',array('type'=>'text','label'=>'Description','value'=>$results['Reward']['description'])); ?>
	</td></tr>
	<tr><td colspan=3>
	  <?php $points=range(0,100); 
		 echo $form->select('threshold', $points, array('label'=>'Points','selected'=>$results['Reward']['threshold'])); ?>

</td></tr>
    <tr><td colspan=3>
	
    
Start Date
 <? 
	?>
    <? echo $form->select('smonth', $months, array('selected'=>date('M',strtotime($results['Reward']['start_date']))));?>
	    <? echo $form->select('sdate', $dates,array('selected'=>date('j',strtotime($results['Reward']['start_date']))));?>
	    <? echo $form->select('syear', $years,array('selected'=>date('Y',strtotime($results['Reward']['start_date']))));?>
	
    
     <br />
     Expires
     <? $options=array('Yes'=>'Yes','No'=>'No');
		$attributes = array('legend'=>false,'value'=>'No');
		echo $form->radio('expires',$options,$attributes);
		
 	?>
        <? echo $form->select('emonth', $months, array('selected'=>date('M',strtotime($results['Reward']['end_date']))));?>
	    <? echo $form->select('edate', $dates,array('selected'=>date('j',strtotime($results['Reward']['end_date']))));?>
	    <? echo $form->select('eyear', $years,array('selected'=>date('Y',strtotime($results['Reward']['end_date']))));?>
	
	    
           
	
	<?
	?>
	</td></tr>
   
<tr><td   colspan=2>
	<?php echo $ajax->submit('Change',array('url'=>array('controller'=>'merchants','action'=>'edit_reward',$results['Reward']['id']),'update'=>$div_name)); ?>
	</td><td  colspan=2 align='right'>
	<?php echo $html->link('Cancel',array('controller'=>'merchants','action'=>'dashboard'),array(),'Are you sure you want to abandon changes?', false); ?>
<?php echo $form->end(); ?>
	</td></tr>
	</table>
    
    
    
</div>

<? else: ?>

<? echo $results['Reward']['description'];
			echo $results['Reward']['threshold'];
			echo $results['Reward']['start_date'];
			echo $results['Reward']['end_date'];
?>		
    
    
<? endif; ?>