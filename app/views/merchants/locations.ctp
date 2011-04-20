<div id="nww_location">
	       <? foreach($errors as $key=>$value){ ?>
       <div class='smallercopy_err' style='color:red'> 	<? echo $errors[$key]; ?> </div>
	   <? } ?>


<? if (!$confirm): ?>          
  	<?php echo $form->create('Merchant'); ?>
         <div class="left-layer15"> Name / Description<?php echo $form->input('name', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?></div>
         <div class="left-layer14"> Address <?php echo $form->input('Address', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?></div>
         <div class="left-layer12"> City<?php echo $form->input('City', array('label'=>false, 'class'=>'required', 'style'=>'width:150px')); ?></div>
         <div class="right-layer11"> State<? echo $form->select('State', $states);?></div>	
		<? $max_visits = range(1,10); ?>
        <div class="left-layer15">Max. Daily Visits
        <?php echo $form->input('max_visits',array('type' =>'select', 'label'=>false, 'options' => $max_visits,'selected' => 0)); ?>
		</div>
		<div class="left-layer12"><?php echo $ajax->submit('Add',array('url'=>array('controller'=>'merchants','action'=>'locations'),'update'=>'new_location'));
?><?php echo $html->link('Cancel',array('controller'=>'merchants','action'=>'dashboard')); ?><?php echo $form->end(); ?>
		</div>
                     
<? else: ?>
	<div class="left-layer31">
    <article>
    </article>
	<input id="myLat" type="hidden" value="<? echo $lat; ?>">
	<input id="myLong" type="hidden"  value="<? echo $long; ?>">
	<script type="text/javascript">
		drawMap();
    </script>   	
	</div>
	<div class="left-layer32">
	<? 	echo $html->link('Confirm',array('controller'=>'merchants','action'=>'dashboard')); ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?	echo $html->link('Delete', array('controller'=>'merchants', 'action'=>'delete_location',$loc_id),array(),'Are you sure you want to delete this location?', false); ?>
     </div>
<? endif; ?>              
</div>

