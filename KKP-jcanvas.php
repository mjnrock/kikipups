<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_header.php";
?>
    
<input type="file" id="imageLoader" name="imageLoader" />

<canvas
    id="story-frame"
    width="350"
    height="350"
    class="ba br2 ml-4 mt-4"
></canvas>

<a class="btn btn-outline-primary" href="" id="download-image" download="filename">Download</a>

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

        $("#story-frame")

        //? It appears that the extra layers are being caused by the Handler plugin.  Use LayerGroup if need to circumvent .length issues
        function handleImage(e){
            let reader = new FileReader();

            reader.onload = function(event){
                let img = new Image();

                img.onload = function() {
                    $("#story-frame").addLayer({
                        type: "image",
                        draggable: true,
                        source: img,
                        width: 150,
                        height: 150,
                        mousedown: function(e) {
                            UpdateLayer(e.index, e);
                        }
                    });

                    LayerButtons();
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
            if(typeof jObj === "number" || jObj === null) {
                layer = jObj;
            } else {
                layer = +jObj.attr("i");
            }

            $("#story-frame").setLayers({
                draggable: false,
                handlePlacement: "none",
                resizeFromCenter: false,
                handle: {}
            });
            $("#story-frame").setLayers({
                draggable: true,
                handlePlacement: "both",
                resizeFromCenter: false,
                handle: {
                    type: "rectangle",
                    fillStyle: "#fff",
                    strokeStyle: "#337",
                    strokeWidth: 1,
                    width: 10,
                    height: 10
                },
                cursors: {
                    mouseover: "pointer",
                    mousedown: "move",
                    mouseup: "pointer"
                }
            }, function(l) {
                return l.index === layer;
            });

            $("#story-frame").drawLayers();
        }

        $(document).on("click", "#download-image", function(e) {
            UpdateLayer(null);

            $("#download-image").attr("href", $("#story-frame").getCanvasImage("png"));
        });

        $(document).on("click", "#story-frame-layers-delete > button", function(e) {
            $("#story-frame").removeLayer(+$(this).attr("i")).drawLayers();
        });

        $(document).on("click", "#story-frame-layers > button", function(e) {
            UpdateLayer($(this), e);

            if(keymask) {
                $("#story-frame").moveLayer(+$(this).attr("i"), $("#story-frame").getLayers().length);
            }
        });

        $("#story-frame").addLayer({
            name: "painter",
            type: "line",
            strokeWidth: 5,
            strokeStyle: "#33c",
            strokeCap: "round",
            strokeJoin: "round",
            x1: 50,
            y1: 50,
            x2: 250,
            y2: 250,
            mousedown: function(lyr) {
                console.log(lyr);
                $(this).setLayer("painter", {                    
                    strokeWidth: 5,
                    strokeStyle: "#33c",
                    strokeCap: "round",
                    strokeJoin: "round",
                    x1: mouse[ 0 ],
                    y1: mouse[ 1 ],
                    x2: lyr.event.originalEvent.clientX - lyr.event.target.offsetLeft,
                    y2: lyr.event.originalEvent.clientY - lyr.event.target.offsetTop
                });
            }
        });
        $("#story-frame").addLayer({
            type: "text",
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
        $("#story-frame").addLayer({
            type: "image",
            draggable: true,
            source: "./assets/images/raccoon.png",
            x: 150,
            y: 150,
            rotate: 45,
            mousedown: function(e) {
                UpdateLayer(e.index, e);
            }
        });
        // $("#story-frame").drawImage({
        //     groups: [ "canvas" ],
        //     index: 3,
        //     layer: true,
        //     draggable: true,
        //     source: "./assets/images/pusheen.png",
        //     x: 150,
        //     y: 150,
        //     rotate: 45,
        //     click: function(e) {
        //         UpdateLayer(e.index, e);
        //     }
        // });
        // $("#story-frame").drawText({
        //     groups: [ "canvas" ],
        //     index: 1,
        //     layer: true,
        //     draggable: true,
        //     fillStyle: "#9cf",
        //     strokeStyle: "#25a",
        //     strokeWidth: 2,
        //     x: 150, y: 100,
        //     fontSize: 48,
        //     fontFamily: "Verdana, sans-serif",
        //     text: "Test",
        //     click: function(e) {
        //         UpdateLayer(e.index, e);
        //     }
        // });

        $(document).on("keydown", "html", function(e) {
            if(e.originalEvent.shiftKey) {
                keymask = 1;
            } else if(e.originalEvent.code === "Escape") {
                UpdateLayer(null);
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
                //* Rotate layer
                // $("#story-frame").setLayer(layer, {
                //     rotate: `+=${ dir * (Math.sqrt(Math.pow(md[0], 2) + Math.pow(md[1], 2))) }`
                // }).drawLayers();

                // $("#story-frame").drawArc({
                //     fillStyle: "#33c",
                //     x: e.originalEvent.clientX - e.target.offsetLeft,
                //     y: e.originalEvent.clientY - e.target.offsetTop,
                //     radius: 5,
                //     start: 0,
                //     end: 360
                // });

                // let painter = $("#story-frame").getLayer("painter");
                // .drawLine({
                //     strokeWidth: 5,
                //     strokeStyle: "#33c",
                //     strokeCap: "round",
                //     strokeJoin: "round",
                //     x1: mouse[ 0 ],
                //     y1: mouse[ 1 ],
                //     x2: e.originalEvent.clientX - e.target.offsetLeft,
                //     y2: e.originalEvent.clientY - e.target.offsetTop
                // }).drawLayers();
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