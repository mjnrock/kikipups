<?php    
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_header.php";
	
	Router::SetServer($_SERVER);

	Router::QuickGet("/profile", "Profile");
	Router::QuickGet("/message", "Message");
	Router::QuickGet("/event", "Event");
	Router::QuickGet("/article", "Article");
	Router::QuickGet("/articles", "ArticleFeed");

	require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_footer.php";
?>

<?php //    require "./views/ArticleFeed.php"; ?>
<?php //    require "./views/Profile.php"; ?>
<?php //    require "./views/Message.php"; ?>