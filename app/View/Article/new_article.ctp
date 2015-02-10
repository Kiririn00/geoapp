<!-- this is view -->
<?php
echo $this->Html->script('jquery-1.9.1.min');
echo $this->Html->script('AddRemoveField');
?>

<div id="new_article_container">

	<span id="topic">Create New Article <div id="jp">新日記を作る</div></span>

	<div id="line"></div>

	<form enctype="multipart/form-data" method="post">

	<!--//////////////// new article field //////////////////////////-->
	<div id="new_article_title">
		<span id="input_text">New Title　<span id="jp">日記の名前</span> </span>
		<br/>
		<input type="text"  name="article_title" required />
		<br/>
	</div>

	<div id="summary">
		Summary Detail　<span id="jp">まとめ内容</span>
		<br/>
		<input type="text" name="summary" required />
		<br/>
	</div>

	<div id="new_article_image">
		Article Image　<span id="jp">まとめ画像</span>
		<br/>
		<input type="file" name="ArticleImage" required />
		<br/>
	</div>

	<br/><br/>

	<!--//////////////// new article content set field //////////////////////////-->

	<div id="location_name">
	Location Name　<span id="jp">場所の名前</span>
	<br/>
	<input type="text" name="location_name_0" required />
	<br/>
	</div>

	<div id="new_article_detail">
	Location Detail　<span id="jp">場所内容</span>
	<br/>
	<textarea rows="4" cols="50" name="article_detail_0" required></textarea>
	<br/>
	</div>

	<div id="article_content_image">
	Upload Location image　<span id="jp">ファイルアップロード</span>
	<?php echo $this->Form->input('Article.file', array(
			'type' => 'file', 'multiple',
			'name' => 'data[ArticleImage_0][]',
			'label' => false
	)); ?>
	</div>

	<br/><br/>

	<div id="PasteImageField" class="1"></div>

	<div id="PasteField"></div>
	<div id="addfield_cover"><a href="#" id="AddField">Add New Location <br/> <span id="jp">登録場所を増やす</span></a></div>
	<input type="hidden" name="set_feild_count" value="1">
	<br/><br/>

	<input type="submit" />

	</form>



</div><!-- end div new article container -->



















