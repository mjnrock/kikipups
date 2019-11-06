<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_header.php";
?>
    
<canvas
    id="story-frame"
    width="500"
    height="500"
    class="ba br2 ml-4 mt-4"
></canvas>

<div id="story-frame-layers" class="btn-group">
    <button i="0" class="btn btn-outline-secondary active">0</button>
    <button i="1" class="btn btn-outline-secondary">1</button>
    <button i="2" class="btn btn-outline-secondary">2</button>
</div>

<div id="story-frame-layers-delete" class="btn-group">
    <button i="0" class="btn btn-danger active">0</button>
    <button i="1" class="btn btn-danger">1</button>
    <button i="2" class="btn btn-danger">2</button>
</div>

<script>
    $(document).ready(function() {
        let mousemask = 0;
        let keymask = 0;
        let layer = 0;

        $(document).on("click", "#story-frame-layers-delete > button", function(e) {
            $("#story-frame").removeLayer(+$(this).attr("i")).drawLayers();
        });

        $(document).on("click", "#story-frame-layers > button", function(e) {
            layer = +$(this).attr("i");

            $("#story-frame-layers > button").each(function(i, v) {
                $(v).removeClass("active");
            });
            $(this).addClass("active");
            
            for(let i = 0; i < $("#story-frame").getLayers().length; i++) {
                if(layer === i) {
                    $("#story-frame").setLayer(layer, {
                        intangible: false
                    });
                } else {
                    $("#story-frame").setLayer(i, {
                        intangible: true
                    });
                }
            }
            $("#story-frame").drawLayers();
        });

        $("#story-frame").drawText({
            layer: true,
            draggable: true,
            fillStyle: "#9cf",
            strokeStyle: "#25a",
            strokeWidth: 2,
            x: 150, y: 100,
            fontSize: 48,
            fontFamily: "Verdana, sans-serif",
            text: "Hello",
            scale: 1.0,
            cursors: {
                mouseover: 'pointer',
                mousedown: 'move',
                mouseup: 'pointer'
            }
        });
        $("#story-frame").drawImage({
            layer: true,
            draggable: true,
            source: "./assets/images/raccoon.png",
            x: 150,
            y: 150,
            cursors: {
                mouseover: 'pointer',
                mousedown: 'move',
                mouseup: 'pointer'
            }
        });
        $("#story-frame").drawText({
            layer: true,
            draggable: true,
            fillStyle: "#9cf",
            strokeStyle: "#25a",
            strokeWidth: 2,
            x: 150, y: 100,
            fontSize: 48,
            fontFamily: "Verdana, sans-serif",
            text: "Test",
            scale: 1.0,
            cursors: {
                mouseover: 'pointer',
                mousedown: 'move',
                mouseup: 'pointer'
            }
        });

        $(document).on("mousedown", "#story-frame", function(e) {
            mousemask = 1;
        });
        $(document).on("mouseup", "#story-frame", function(e) {
            mousemask = 0;
        });
        $(document).on("mousemove", "#story-frame", function(e) {
            
        });

        // let scale = [
        //     1.0,
        //     1.0
        // ];
        // $(document).on("keydown", "html", function(e) {
        //     if(e.originalEvent.altKey) {
        //         keymask = 1;
        //     }

        //     if(keymask === 1 && e.originalEvent.keyCode === 38) {
        //         $("#story-frame").setLayer(layer, {
        //             scaleX: scale[ layer ] + 0.1
        //         }).drawLayers();
        //     }
        //     if(keymask === 1 && e.originalEvent.keyCode === 40) {
        //         $("#story-frame").setLayer(layer, {
        //             scaleX: scale[ layer ] - 0.1
        //         }).drawLayers();
        //     }
        // });
        // $(document).on("keyup", "html", function(e) {
        //     keymask = 0;
        // });
    });
</script>

<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_footer.php";
?>