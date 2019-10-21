<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_header.php";	

	$router = new Router(new Request);

	
	$router->get("/profile", $router->render("Profile"));
	$router->get("/message", $router->render("Message"));
	$router->get("/event", $router->render("Event"));
	$router->get("/articles", $router->render("ArticleFeed"));
	$router->get("/article", $router->render("Article"));	


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

        include "{$_SERVER["DOCUMENT_ROOT"]}/partials/${partial}.php";
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

<?php //    require "{$_SERVER["DOCUMENT_ROOT"]}/views/ArticleFeed.php"; ?>
<?php //    require "{$_SERVER["DOCUMENT_ROOT"]}/views/Profile.php"; ?>
<?php //    require "{$_SERVER["DOCUMENT_ROOT"]}/views/Message.php"; ?>