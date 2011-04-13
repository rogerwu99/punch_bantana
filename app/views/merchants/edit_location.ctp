<?php $div_name = 'div_'.$div_id; 
//echo $form->create(null, array('url' => array('controller'=>'merchants','action' => 'rewards'))); ?>
<? if ($editing): ?>
<div id="<? echo $div_name; ?>">         
<?php echo $form->create('Location'); ?>
	<div class="left-layer15"><?php echo $form->input('Description',array('type'=>'text','label'=>false,'value'=>$results['Location']['description'])); ?></div>
	<div class="left-layer14"><?php echo $form->input('Address',array('type'=>'text','label'=>false,'value'=>$results['Location']['address'])); ?></div>
	<div class="left-layer12"><?php echo $form->input('Zip',array('type'=>'text','label'=>false,'value'=>$results['Location']['zip'], 'style'=>'width:50px')); ?></div>
	<? $max_visits = range(1,10); ?>
    <div>Max. Daily Visits
    <?php echo $form->input('max_visits',array('type' =>'select', 'label'=>false, 'options' => $max_visits,'selected' => $results['Location']['max_visits'])); ?></div>
	<div style="text-align:center">   
	<span style="left-layer15"><? 	echo $ajax->submit('Change',array('url'=>array('controller'=>'merchants','action'=>'edit_location',$results['Location']['id']),'update'=>$div_name)); ?></span>
	<span style="left-layer15"><?	echo $html->link('Cancel',array('controller'=>'merchants','action'=>'dashboard'),array(),'Are you sure you want to abandon changes?', false); 	
		echo $form->end(); 
	?></span>
	</div>
</div>

<? else: ?>
<div class="table-row-even">&nbsp;
<div class="left-layer15"><? 		echo $results['Location']['description']; ?></div>
<div class="left-layer14"><? echo $results['Location']['address']; ?></div>
<div class="left-layer12"><?			echo $results['Location']['zip']; ?></div>		
</div>    
    
<? endif; ?>