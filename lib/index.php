<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/lib/Router.php";
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/lib/Emoji.php";
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/lib/DataSetPoster.php";

    function cout($input) {
        echo "<pre>";
        print_r($input);
        echo "</pre>";
    }
?>  