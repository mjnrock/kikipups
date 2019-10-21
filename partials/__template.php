<div class="col text-center">
    <h2><?= $ViewBag[ "key" ]; ?></h2>
    <h3><?= $ViewBag[ "id" ]; ?></h3>

    <div class="row">
        <?php
            foreach($ViewBag[ "children" ] as $childId) {
                $ViewBag[ "@scope" ]->Create($childId, "Post");
            }
        ?>
    </div>
</div>