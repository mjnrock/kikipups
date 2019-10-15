<?php    
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_header.php";
	
	Router::SetServer($_SERVER);

	Router::QuickGet("/profile", "Profile");
	Router::QuickGet("/message", "Message");
	Router::QuickGet("/event", "Event");
	Router::QuickGet("/articles", "ArticleFeed");
	Router::QuickGet("/article", "Article");

	require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_footer.php";
?>

//! Use HTML in a PHP function
<!-- <php function TestBlockHTML($replStr) { ob_start(); ?>
    <div>
        <h1> <=$replStr ?> </h1>
    </div>
<php return ob_get_clean(); } ?>
<= TestBlockHTML("cat"); ?> -->

//! Recursive DataPost-Generator Function
<!-- <php
    function CreateDataPost($partial, $id, $lookup) {
        $ViewBag = $lookup[ $id ];

        include "./partials/${partial}.php";
    }
?>
<php   // ${partial}.php ?>
<div>
    <p>
        <= $ViewBag[ "name" ]; ?>
    </p>
    <php
        foreach($ViewBag[ "children "] as $childId) {
            CreateDataPost($ViewBag[ "@partial" ], $childId, $ViewBag[ "@lookup" ]);
        }
    ?>
</div> -->

<?php //    require "./views/ArticleFeed.php"; ?>
<?php //    require "./views/Profile.php"; ?>
<?php //    require "./views/Message.php"; ?>