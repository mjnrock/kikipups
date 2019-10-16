<?php
    $RP = new RecursivePoster([
        [ "a" => 0, "b" => 1, "c" => 2, "d" => [ 1, 2 ], "e" => 4 ],
        [ "a" => 10, "b" => 11, "c" => 12, "d" => 13, "e" => 14 ],
        [ "a" => 20, "b" => 21, "c" => 22, "d" => 23, "e" => 24 ],
    ], RecursivePoster::ProcessRow(
        "a",
        "b",
        "c",
        "d",
        "e"
    ));

    $RP->Create(0, "Post");
?>

<?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/Profile.php"; ?>