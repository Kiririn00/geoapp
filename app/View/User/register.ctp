
	<?php
		echo $this->Form->create('User',array(
			'enctype' => 'multipart/form-data'
		));
		echo $this->Session->flash();
	?>
	Pen Name ペンネーム<br/>
	<?php	
		echo $this->Form->input('Pen Name',array('label' => false));
	?>
	Password　パスワード<br/>
	<?php	
		echo $this->Form->input('Password',array('type' => 'password','label' => false));
	?>
	Email　メール<br/>
	<?php	
		echo $this->Form->input('Email',array('label' => false));
	?>	
	<input type="file" name="DisplayImage" />
	<?php 
		echo $this->Form->end('Register　登録');
		
	?>

