<h3>EMAIL:</h3>
<br/> 
<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
<br/>
----------------------------------------------------------------------------------
<br/>
<h3>CATEGORY:</h3> 
<br/>
<?php echo $category; ?>
<br/>
----------------------------------------------------------------------------------
<br/>
<h3>MESSAGE:</h3> 
<br/>
<?php echo nl2br(html_entity_decode($message)); ?>
<br/>
----------------------------------------------------------------------------------
