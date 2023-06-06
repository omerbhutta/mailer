<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
require_once "Database.php";

$db = new Database();

$page = isset($_POST['page'])? intval($_POST['page']) : 1;
$side = isset($_POST['side'])? htmlspecialchars($_POST['side']) : "press";

$press_object = $db->getPress($page,$side);
$posts = $press_object['posts'];

$ret_posts = array('posts'=>"",'pages'=>$press_object['pages']);
foreach ($posts as $post){
    $ret_posts['posts'] .="<div class=\"row\">
					<div class=\"col-sm-12\">
						<h2 class=\"blue bold font18 uppercase mt30\">".$post->getNazva()."</h2>
						<a href=\"press-post.php?id=".$post->getId()."&side=".$side."\">
							<img src=\"".$post->getImg()."\" class=\"img-responsive\">
						</a>
						<br>
						<div data-description=\"".$post->getDescription()."\" data-title=\"".$post->getNazva()."\" data-url=\"http://astra-management.ca/press-post.php?id=".$post->getId()."\" class=\"pluso\" data-background=\"#ebebeb\" data-options=\"small,round,line,horizontal,counter,theme=04\" data-services=\"facebook,twitter,google,linkedin,tumblr\"></div>
						<p>".$post->getDescription()."</p>
						<a href=\"press-post.php?id=".$post->getId()."\">Read more</a>
					</div>
				</div>
					<hr>";
}
echo json_encode($ret_posts);