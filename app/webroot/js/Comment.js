function check()
{
	
}

var UsePenName;
var UseComment;

function CallComment(UseArticleId)
{
	var items = [];
	
	$.getJSON("/CakePHP/Article/Comment.json", function(data){
			
			$.each(data.CommentJSON, function(key,value) {
								
				var ArticleId = value.Comment.article_id;
				var PenName = value.Comment.pen_name;
				var Comment = value.Comment.comment;
				
				if(UseArticleId == ArticleId)
				{
					UsePenName = PenName;
					UseComment = Comment;
				
				
				  items.push(
						  "<img id='display' src='/CakePHP/app/webroot/files/"+UsePenName+"_display.jpg'><br/><div>"+UsePenName+"</div><br/><div>"+UseComment+"</div><br/>"
				  );
				}  
				
			});//end each function
			
			 $("#get_comment").html( items.join(""));
			 
	});//end getJSON function	
}