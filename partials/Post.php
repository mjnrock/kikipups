<li kp-pt="<?= $ViewBag[ "payload" ][ "post-type" ]; ?>" class="row alert alert-<?= $ViewBag[ "@fn" ][ "post-type" ]($ViewBag[ "payload" ][ "post-type" ]); ?> br3">
    <span class="ba br-100" style="overflow: hidden">
        <img src="<?= $ViewBag[ "payload" ][ "picture-uri" ]; ?>" height="98" alt="Pic" />
    </span>
    <span class="col-2 text-center display-3">
        <?= $ViewBag[ "payload" ][ "icon" ]; ?>
    </span>
    <span class="col-8">
        <?= $ViewBag[ "payload" ][ "content" ]; ?>
    </span>
</li>