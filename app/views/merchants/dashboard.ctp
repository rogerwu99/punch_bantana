      <div id="leftcolumn">
     <div class="bodycopy">
     
     
          Hi <? echo $_Auth['User']['name']; ?> </div>
			     <br />
                 <table><tr><th>REWARDS <? echo $html->link('(Add)', array('controller'=>'merchants','action'=>'rewards')); ?></th></tr>     
               <?php foreach ($reward_list as $key=>$value){
			
			if ($reward_list[$key]['deleted']==0):
			?>
            <tr><td> <?php $div_name = 'div_'.$reward_list[$key]['id']; ?>
 			<div id="<? echo $div_name; ?>">
            
            <? echo $reward_list[$key]['description'];
			echo $reward_list[$key]['threshold'];
			echo $reward_list[$key]['start_date'];
			echo $reward_list[$key]['end_date'];
	?>		</td><td><? echo $ajax->link('Edit',array('controller'=>'merchants','action'=>'edit_reward',$reward_list[$key]['id']), array('update'=>$div_name));?></td><td><?php echo $html->link('Delete', array('controller'=>'merchants', 'action'=>'delete_reward',$reward_list[$key]['id']),array(),'Are you sure you want to delete this reward?', false); ?>
</td></tr>
	<?	
	endif;
	}?></table>
              <table><tr><th>LOCATIONS <? echo $html->link('(Add)', array('controller'=>'merchants','action'=>'locations')); ?></th></tr>     
               <?php foreach ($location_list as $key=>$value){
				   if ($location_list[$key]['Location']['deleted']==0):
			?>
            <tr><td><?php $div_name = 'div_'.$location_list[$key]['Location']['id']; ?>
 			<div id="<? echo $div_name; ?>">
            <? echo $location_list[$key]['Location']['address'];
			echo $location_list[$key]['Location']['zip'];
			echo $location_list[$key]['Location']['description'];
	?>		</div></td><td><? echo $ajax->link('Edit',array('controller'=>'merchants','action'=>'edit_location',$location_list[$key]['Location']['id']), array('update'=>$div_name));?></td><td><?php echo $html->link('Delete', array('controller'=>'merchants', 'action'=>'delete_location',$location_list[$key]['Location']['id']),array(),'Are you sure you want to delete this location?', false); ?></td></tr>
	<?	endif;
	}?></table>
    
                 <table><tr><th>MY QR CODES </th></tr>     
 </table>
    
                
                
                    <div class="content1">
                    <div class="content18">
                      <div class="floatleft"><? echo $html->image("create_my_account_button.jpg", array('alt'=>'Create my account', 'width'=>'205', 'height'=>'38')); ?></div><div class="floatleft"><?php echo $form->submit('submit_now_button.jpg');?></div>
                    </div></div>
		<?php echo $form->end(); ?>
                
                  
                </div>
                <div id="rightcolumn">
                </div>



