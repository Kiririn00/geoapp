<!-- this is view -->
<?php
echo $this->Html->css('login');
?>

<div id="login_container">

<div id="topic">Login</div>
<div id="line"></div>

<?php
echo $this->Form->create('User',array('type' => 'post'));
echo $this->Session->flash();
?>
<div id="pen_name">
<?php
echo $this->Form->input('PenName',array(
	'label' => false,
	'placeholder' => 'PenName'
	));
?>
</div>

<?php
echo $this->Form->input('Password',array(
	'type' => 'password',
	'label' => false,
	'placeholder' => 'Password'
));
?>

<?php
//in future may be I will add forgot password system
echo $this->Form->end('Login');
?>

</div>