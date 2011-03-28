      <div id="leftcolumn">
     <div class="bodycopy">
     
     
          Hi <? echo $_Auth['User']['name']; ?> </div>
			     <br />
                 <table><tr><th>REWARDS <? echo $html->link('(Add)', array('controller'=>'merchants','action'=>'rewards')); ?></th></tr>     
               <?php foreach ($reward_list as $key=>$value){
			
			if ($reward_list[$key]['deleted']==0):
			?>
            <tr><td> <?php $div_name = 'rewdiv_'.$reward_list[$key]['id']; ?>
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
             <? $location_list_copy = $location_list; ?>
               <?php foreach ($location_list as $key=>$value){
				   if ($location_list[$key]['Location']['deleted']==0):
			?>
            <tr><td><?php $div_name = 'locdiv_'.$location_list[$key]['Location']['id']; ?>
 			<div id="<? echo $div_name; ?>">
            <? echo $location_list[$key]['Location']['address'];
			echo $location_list[$key]['Location']['zip'];
			echo $location_list[$key]['Location']['description'];
	?>		</div></td><td><? echo $ajax->link('Edit',array('controller'=>'merchants','action'=>'edit_location',$location_list[$key]['Location']['id']), array('update'=>$div_name));?></td><td><?php echo $html->link('Delete', array('controller'=>'merchants', 'action'=>'delete_location',$location_list[$key]['Location']['id']),array(),'Are you sure you want to delete this location?', false); ?></td></tr>
	<?	endif;
	}?></table>
    
                 <table><tr><th>MY QR CODES </th></tr>  
            <tr>     
                   <?php foreach ($location_list_copy as $key=>$value){
				   if ($location_list_copy[$key]['Location']['deleted']==0):
			?>
            <td>
				<?php $div_name = 'qrdiv_'.$location_list_copy[$key]['Location']['id']; ?>
             	<?	echo $location_list_copy[$key]['Location']['description']; ?>
				<div id="<? echo $div_name; ?>">
				<? echo $html->image('qrcodes/'.$location_list_copy[$key]['Location']['qr_path'], array('alt'=>'QR_Code', 'width'=>'87', 'height'=>'87'));
	?>			</div>
    		<? echo $ajax->link('Refresh',array('controller'=>'merchants','action'=>'qr_refresh',$location_list_copy[$key]['Location']['id']), array('update'=>$div_name));?></td>
	<?	endif;
	}?></tr>
                 
                 
                 
                 
                 
                    
 </table>
    
                
                
                    <div class="content1">
                    <div class="content18">
                      <div class="floatleft"><? echo $html->image("create_my_account_button.jpg", array('alt'=>'Create my account', 'width'=>'205', 'height'=>'38')); ?></div><div class="floatleft"><?php echo $form->submit('submit_now_button.jpg');?></div>
                    </div></div>
		<?php echo $form->end(); ?>
                
                  
                </div>
                <div id="rightcolumn">
                </div>



