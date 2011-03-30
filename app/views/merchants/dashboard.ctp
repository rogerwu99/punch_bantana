      <div id="leftcolumn">
     <div class="bodycopy">Hi <? echo $_Auth['User']['name']; ?> </div>
			     <br />
                 <div class="base-container base-layer">
                 <h4 class="table-caption">
REWARDS <? echo $ajax->link('(Add)', array('controller'=>'merchants','action'=>'rewards'), array('update'=>'new_reward')); ?></h4>     
       <div class="table-row">
<div class="left-layer11"> <div id="new_reward"></div></div></div>
               <?php foreach ($reward_list as $key=>$value){
			
			if ($reward_list[$key]['deleted']==0):
			$div_name = 'rewdiv_'.$reward_list[$key]['id'];
			?>
            <div id="<? echo $div_name; ?>">
            <div class="table-row">
            <div class="left-layer11"> 
            <? echo $reward_list[$key]['description'];
			echo $reward_list[$key]['threshold'];
			echo $reward_list[$key]['start_date'];
			echo $reward_list[$key]['end_date'];
			?>	
		    </div>	
   			<div class="left-layer12"> <? echo $ajax->link('Edit',array('controller'=>'merchants','action'=>'edit_reward',$reward_list[$key]['id']), array('update'=>$div_name));?>
            </div>
   			<div class="right-layer11">    <? echo $html->link('Delete', array('controller'=>'merchants', 'action'=>'delete_reward',$reward_list[$key]['id']),array(),'Are you sure you want to delete this reward?', false); ?>
			</div>
			</div>
            <div class="space-line"></div>

	<?	
	endif;
	}?>
    
    
              <h4 class="table-caption">LOCATIONS <? echo $ajax->link('(Add)', array('controller'=>'merchants','action'=>'locations'),array('update'=>'new_location')); ?></h4>   <div class="table-row">
<div class="left-layer11"> <div id="new_location"></div></div> </div>  
             <? $location_list_copy = $location_list; ?>
               <?php foreach ($location_list as $key=>$value){
				   if ($location_list[$key]['Location']['deleted']==0):
			 $div_name = 'locdiv_'.$location_list[$key]['Location']['id']; ?>
 			<div id="<? echo $div_name; ?>">
            <div class="table-row">

            <div class="left-layer11"> 
            <? echo $location_list[$key]['Location']['address'];
			echo $location_list[$key]['Location']['zip'];
			echo $location_list[$key]['Location']['description'];
	?>		</div>
    <div class="left-layer12"><? echo $ajax->link('Edit',array('controller'=>'merchants','action'=>'edit_location',$location_list[$key]['Location']['id']), array('update'=>$div_name));?></div>
    <div class="right-layer11"><?php echo $html->link('Delete', array('controller'=>'merchants', 'action'=>'delete_location',$location_list[$key]['Location']['id']),array(),'Are you sure you want to delete this location?', false); ?></div></div>
	 <div class="space-line"></div>
	<?	endif;
	}?>  

    
                 <h4 class="table-caption">MY QR CODES </h4>  
               
                   <?php foreach ($location_list_copy as $key=>$value){
				   if ($location_list_copy[$key]['Location']['deleted']==0):
			?>
           	<?php $div_name = 'qrdiv_'.$location_list_copy[$key]['Location']['id']; ?>
             	<div class="table-row">
<div class="left-layer11">
				<?	echo $location_list_copy[$key]['Location']['description']; ?>
				<div id="<? echo $div_name; ?>">
				<? echo $html->image('qrcodes/'.$location_list_copy[$key]['Location']['qr_path'], array('alt'=>'QR_Code', 'width'=>'87', 'height'=>'87'));
	?>			</div>
    		<? echo $ajax->link('Refresh',array('controller'=>'merchants','action'=>'qr_refresh',$location_list_copy[$key]['Location']['id']), array('update'=>$div_name));?></div></div>
             <div class="space-line"></div>
	<?	endif;
	}?>
                 
                 </div>
                 
                 
                    
            <div style="float:right;">
           
            <? echo $this->element('feedback',array("user_type" => "Merchant")); ?>     
</div>    
                
         </div></div>         
</div>
