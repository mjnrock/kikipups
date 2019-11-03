<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_header.php";
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/server/db/Select.php";
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/server/db/Insert.php";
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/server/db/Result.php";
	

	// $r1 = new Result([
	// 	"A" => 57,
	// 	546,
	// 	657,
	// 	23489
	// ]);
	// $r2 = new Result([
	// 	"asdf",
	// 	"werds",
	// 	"vxsadffgser",
	// 	"2345fsd3c"
	// ]);

	// $rs = new ResultSet([
	// 	$r1,
	// 	$r2
	// ], [
	// 	"cat",
	// 	"dog",
	// 	"fish",
	// 	"bird"
	// ]);

	// cout($r1->A());
	// cout($rs->Cell(0, "cat"));

    
    $Select = Select::Start([
        "{{1}}",
        "dog"
    ])
        ->From("Cats")
        ->InnerJoin("Cats", "t0.bob", "t1.{{1}}")
        ->RightJoin("{{0}}", "t0.bob", "t1.weasel")
        ->OuterApply("Cats", [
            "1asd",
            "2sgfre",
            "3fsadfsad"
        ])
        ->Where("t0.Bob = '{{0}}'")
        ->GroupBy([
            "fish",
            "bread"
        ]);
        // ->Having("t1.Bob = 'c@ts'")
        // ->OrderBy([
        //     "cheese ASC",
        //     "cheese DESC"
        // ])
    ;

    echo "-------------------------";
    cout(
        $Select->Process()
    );
    echo "-------------------------";
	
    $Insert = Insert::Start("Cats", [
		"cat",
		"dog"
	])
		// ->From("Cats")
		// ->InnerJoin("Cats", "t0.bob", "t1.{{1}}")
		// ->RightJoin("{{0}}", "t0.bob", "t1.weasel")
		// ->OUterApply("Cats", [
		// 	"1asd",
		// 	"2sgfre",
		// 	"3fsadfsad"
		// ])
		// ->Where("t0.Bob = '{{0}}'")
		// ->GroupBy([
		// 	"fish",
		// 	"bread"
		// ]);
		// ->From($Select)
		->Values([
			1, 2, 3
		]);
		// ->Values([
		// 	[ 1, 2, 3 ],
		// 	[ 4, 5, 6 ]
		// ]);

    echo "-------------------------";
    cout(
        $Insert->Process()
    );
	echo "-------------------------";

	// $router = new Router(new Request);

	
	// $router->get("/profile", $router->callRoute("Profile"));
	// $router->get("/message", $router->callRoute("Message"));
	// $router->get("/event", $router->callRoute("Event"));
	// $router->get("/articles", $router->callRoute("ArticleFeed"));
	// $router->get("/article", $router->callRoute("Article"));	


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