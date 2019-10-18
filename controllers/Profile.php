<?php
    $DataBag = new RecursivePoster([
        [
            "post-type" => "alert",
            "picture-uri" => "./raccoon.png",
            "icon" => "&#x2757",
            "content" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde necessitatibus quasi consequatur aperiam asperiores ab soluta saepe, perspiciatis ut porro excepturi atque, deleniti reiciendis iste distinctio cumque, recusandae dolore ratione?"
        ],
        [
            "post-type" => "mood",
            "picture-uri" => "./pusheen.png",
            "icon" => "&#x1F600",
            "content" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde necessitatibus quasi consequatur aperiam asperiores ab soluta saepe, perspiciatis ut porro excepturi atque, deleniti reiciendis iste distinctio cumque, recusandae dolore ratione?"
        ],
        [
            "post-type" => "question",
            "picture-uri" => "./raccoon.png",
            "icon" => "&#x2754",
            "content" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde necessitatibus quasi consequatur aperiam asperiores ab soluta saepe, perspiciatis ut porro excepturi atque, deleniti reiciendis iste distinctio cumque, recusandae dolore ratione?"
        ]
    ]);
    $DataBag->AddHelper("post-type", function($pt) {
        if($pt == "mood") {
            return "light";
        } else if($pt == "alert") {
            return "danger";
        } else if($pt == "question") {
            return "info";
        }

        return "light";
    });
?>

<ul>
    <?php
        foreach($DataBag->DataSet as $i => $row) {
            $DataBag->Create($i, "Post");
        }
    ?>
</ul>