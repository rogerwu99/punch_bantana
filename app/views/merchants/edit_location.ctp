

<?php $div_name = 'div_'.$div_id; 
//echo $form->create(null, array('url' => array('controller'=>'merchants','action' => 'rewards'))); ?>
<? if ($editing): ?>
<div id="<? echo $div_name; ?>">         
<?php echo $form->create('Location'); ?>
	<table><tr><td colspan=3>
	<?php echo $form->input('Description',array('type'=>'text','label'=>'Description','value'=>$results['Location']['description'])); ?>
	</td></tr>
	<tr><td colspan=3>
	<?php echo $form->input('Address',array('type'=>'text','label'=>'Address','value'=>$results['Location']['address'])); ?>
	</td></tr>
    <tr><td colspan=3>
	<?php echo $form->input('Zip',array('type'=>'text','label'=>'Zip','value'=>$results['Location']['zip'])); ?>
	</td></tr>
<? $max_visits = range(1,10); ?>
        	  
              <div class="bodycopy">Maximum Visits Per Day(required)</div>
        
        <div class='bodycopy' style='color:red'><?php echo $form->input('max_visits',array('type' =>'select', 'label'=>false, 'options' => $max_visits,'selected' => $results['Location']['max_visits'])); ?>
</div>
   
<tr><td   colspan=2>
	<?php echo $ajax->submit('Change',array('url'=>array('controller'=>'merchants','action'=>'edit_location',$results['Location']['id']),'update'=>$div_name)); ?>
	</td><td  colspan=2 align='right'>
	<?php echo $html->link('Cancel',array('controller'=>'merchants','action'=>'dashboard'),array(),'Are you sure you want to abandon changes?', false); ?>
<?php echo $form->end(); ?>
	</td></tr>
	</table>
    
    
    
</div>

<? else: ?>

<? echo $results['Location']['address'];
			echo $results['Location']['zip'];
			echo $results['Location']['description'];
	?>		
    
    
<? endif; ?>