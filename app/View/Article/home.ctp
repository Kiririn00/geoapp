<?php
echo $this->Html->link('Login Page',array(
	'controller' => 'User',
	'action' => 'Login'
));

echo "<br/>";

echo $this->Html->link('Register',array(
	'controller' => 'User',
	'action' => 'Register'
));

echo "<br/>";

echo $this->Html->link('Locate Current Location',array(
	'controller' => 'Location',
	'action' => 'CurrentLocation'
));

echo "<br/>";

echo $this->Html->link('Search Location',array(
	'controller' => 'Location',
	'action' => 'SearchLocation'
));

echo "<br/>";

	
echo $this->Html->link('My page マイページ',array(
			'controller' => 'User',
			'action' => 'UserPage',$UserId
			),
			array(
				'id' => 'menu_link'
			)
		);

echo "<br/>";

echo $this->Html->link('Logout',array(
	'controller' => 'User',
	'action' => 'Logout'
));

?>


<h2>Search Field</h2>

<?php
echo $this->Form->create('Article',array(
	'type' => 'post',
	'url' => array('controller' => 'Article','action' => 'Search'),
));
?>

  <input class="search_bar" 
	 name="data[Article][search]" 
	 type="search"
	  placeholder="Title Name" 
	>

<?php	
	
echo $this->Form->input('Search',array('type' => 'submit','label' => false,'id' => 'search_button'));
echo $this->Form->end();
?>

<h2>List of Article</h2>
