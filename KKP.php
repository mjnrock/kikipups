<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_header.php";
?>
    
<input type="file" id="imageLoader" name="imageLoader" />

<canvas
    id="story-frame"
    width="250"
    height="250"
    class="ba br2 ml-4 mt-4"
></canvas>

<div id="story-frame-layers" class="btn-group">
    <button i="0" class="btn btn-outline-secondary active">0</button>
    <button i="1" class="btn btn-outline-secondary">1</button>
    <button i="2" class="btn btn-outline-secondary">2</button>
    <button i="3" class="btn btn-outline-secondary">3</button>
</div>

<div id="story-frame-layers-delete" class="btn-group">
    <button i="0" class="btn btn-danger active">0</button>
    <button i="1" class="btn btn-danger">1</button>
    <button i="2" class="btn btn-danger">2</button>
    <button i="3" class="btn btn-danger">3</button>
</div>

<script>
    //TODO: Allow for Canvas clicks (when no layers are hit), to set the active layer to null, but still let layer clicks to make active
    $(document).ready(function() {
        let imageLoader = document.getElementById("imageLoader");
            imageLoader.addEventListener("change", handleImage, false);

        let mousemask = 0;
        let mouse = [ 0, 0 ];
        let keymask = 0;
        let layer = 0;

        function handleImage(e){
            let reader = new FileReader();

            reader.onload = function(event){
                let img = new Image();

                img.onload = function(){
                    $("#story-frame").drawImage({
                        layer: true,
                        draggable: true,
                        source: img,
                        width: 150,
                        height: 150,
                        mousedown: function(e) {
                            UpdateLayer(e.index, e);
                        }
                    });

                    LayerButtons();

                    img.width = 150;
                    img.height = 150;
                }
                img.src = event.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);     
        }

        function LayerButtons() {
            $("#story-frame-layers").empty();
            $("#story-frame-layers-delete").empty();

            for(let i = 0; i < $("#story-frame").getLayers().length; i++) {
                $("#story-frame-layers").append(`<button i="${ i }" class="btn btn-outline-secondary ${ layer === i ? "active" : "" }">${ i }</button>`);
                $("#story-frame-layers-delete").append(`<button i="${ i }" class="btn btn-danger ${ layer === i ? "active" : "" }">${ i }</button>`);
            }
        }

        function UpdateLayer(jObj, event) {
            if(typeof jObj === "number") {
                layer = jObj;
            } else {
                layer = +jObj.attr("i");
            }

            $("#story-frame-layers > button").each(function(i, v) {
                $(v).removeClass("active");
            });
            $(`#story-frame-layers > button[i=${ layer }]`).addClass("active");

            for(let i = 0; i < $("#story-frame").getLayers().length; i++) {
                if(layer === i) {
                    $("#story-frame").setLayer(i, {
                        // intangible: false,
                        // draggable: true
                    }).drawLayers();
                    $("#story-frame").setLayer(i, {
                        handlePlacement: "both",
                        resizeFromCenter: false,
                        handle: {
                            type: "arc",
                            fillStyle: "#fff",
                            strokeStyle: "#337",
                            strokeWidth: 1,
                            radius: 10
                        },
                        cursors: {
                            mouseover: "pointer",
                            mousedown: "move",
                            mouseup: "pointer"
                        }
                    }).drawLayers();
                } else {
                    $("#story-frame").setLayer(i, {
                        // intangible: true,
                        // draggable: false,
                        handlePlacement: "none",
                        handle: {}
                    }).drawLayers();
                }
            }
            $("#story-frame").drawLayers();
        }

        $(document).on("click", "#story-frame-layers-delete > button", function(e) {
            $("#story-frame").removeLayer(+$(this).attr("i")).drawLayers();
        });

        $(document).on("click", "#story-frame-layers > button", function(e) {
            UpdateLayer($(this), e);

            if(keymask) {
                $("#story-frame").moveLayer(+$(this).attr("i"), $("#story-frame").getLayers().length);
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
            text: "Hello",
            mousedown: function(e) {
                UpdateLayer(e.index, e);
            }
        });
        $("#story-frame").drawImage({
            layer: true,
            draggable: true,
            source: "./assets/images/raccoon.png",
            x: 150,
            y: 150,
            rotate: 45,
            mousedown: function(e) {
                UpdateLayer(e.index, e);
            }
        });
        $("#story-frame").drawImage({
            layer: true,
            draggable: true,
            source: "./assets/images/pusheen.png",
            x: 150,
            y: 150,
            rotate: 45,
            mousedown: function(e) {
                UpdateLayer(e.index, e);
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
            mousedown: function(e) {
                UpdateLayer(e.index, e);
            }
        });

        $(document).on("keydown", "html", function(e) {
            if(e.originalEvent.shiftKey) {
                keymask = 1;
            }
        });
        $(document).on("keyup", "html", function(e) {
            keymask = 0;
        });

        $(document).on("mousedown", "#story-frame", function(e) {
            mousemask = 1;
        });
        $(document).on("mouseup", "#story-frame", function(e) {
            mousemask = 0;
        });
        $(document).on("mousemove", "#story-frame", function(e) {
            // console.log(e.originalEvent.clientY - e.target.offsetTop);
            let md = [ e.originalEvent.clientX - e.target.offsetLeft - mouse[0], e.originalEvent.clientY - e.target.offsetTop - mouse[1] ];
            let dir = md[1] < 0 ? -1 : 1;

            if(mousemask && keymask) {
                $("#story-frame").setLayer(layer, {
                    rotate: `+=${ dir * (Math.sqrt(Math.pow(md[0], 2) + Math.pow(md[1], 2))) }`
                }).drawLayers();
            }

            mouse = [ e.originalEvent.clientX - e.target.offsetLeft, e.originalEvent.clientY - e.target.offsetTop ];
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