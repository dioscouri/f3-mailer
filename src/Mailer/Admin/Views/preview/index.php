<div><?php echo $contents['subject']?></div>
<div><?php echo $contents['body'][0]?></div>


<br>
<br>
<br>
<br>
<br>


<hr>
<h2>Email</h2>
<?php echo \Dsc\System::instance()->renderMessages(); ?>
<form action="/admin/mailer/template/preview/<?php echo $id; ?>/email">
<input name="email" type="text"><button type="submit"> SEND EMAIL</button> 
</form>