	  <h1 id="branding">
			<? 
				if(!empty($_Auth['User']['start_date'])):
					
						 echo $html->link("Bantana", 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/merchants/dashboard'); 
				else:
						 echo $html->link("Bantana", 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']); 
				endif;
	
						 echo $html->image('default.jpg', array('alt'=>'Moo Cow','width'=>50,'height'=>50,'class'=>'top'));?>
		</h1>
	
              <div class="content1">
		     	<div class="bodycopy">
				<div id="container" style="width:100%;">
					<div id="row">
						<div id="middle">
		
							</div>
					</div>
				</div>
				</div>
              </div>
			  
	