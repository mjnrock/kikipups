<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_header.php";
?>

<style>
    .fileUpload {
        position: relative;
        overflow: hidden;
        margin: 0;
        cursor: pointer;
    }
    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }
</style>

<div class="container ba br2 pa3">
    <div class="row">
        <div class="col-6">
            <canvas
                id="story-frame"
                class="ba br2"
                width="400"
                height="700"
            ></canvas>
        </div>
        
        <div class="col-6">
            <button
                class="form-control btn btn-outline-secondary mt-2"
                id="btn-text"
            >
                <i class="material-icons">text_fields</i>
            </button>
            <div
                class="fileUpload form-control btn btn-outline-secondary mt-2"
                id="btn-image"
            >
                <span>
                    <i class="material-icons">image</i>
                </span>
                <input
                    type="file"
                    id="imageLoader"
                    class="upload"
                />
            </div>
            <button
                class="form-control btn btn-outline-secondary mt-2"
                id="btn-draw"
            >
                <i class="material-icons">create</i>
            </button>

            <div id="draw-tools" class="container" style="display: none;">
                <div class="row mt4">
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-black"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="000000"
                        >&nbsp;</span>
                    </div>
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-red"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="FF4136"
                        >&nbsp;</span>
                    </div>
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-green"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="19A974"
                        >&nbsp;</span>
                    </div>
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-blue"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="357EDD"
                        >&nbsp;</span>
                    </div>
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-yellow"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="FFD700"
                        >&nbsp;</span>
                    </div>
                </div>


                <div class="row mt4">
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-white ba br-1"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="FFFFFF"
                        >&nbsp;</span>
                    </div>
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-light-red"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="FF725C"
                        >&nbsp;</span>
                    </div>
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-light-green"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="9EEBCF"
                        >&nbsp;</span>
                    </div>
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-light-blue"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="96CCFF"
                        >&nbsp;</span>
                    </div>
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-light-yellow"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="FBF1A9"
                        >&nbsp;</span>
                    </div>
                </div>


                <div class="row mt4">
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-moon-gray ba br1"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="CCCCCC"
                        >&nbsp;</span>
                    </div>
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-washed-red ba br1"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="FFDFDF"
                        >&nbsp;</span>
                    </div>
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-washed-green ba br1"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="E8FDF5"
                        >&nbsp;</span>
                    </div>
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-washed-blue ba br1"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="F6FFFE"
                        >&nbsp;</span>
                    </div>
                    <div class="col">
                        <span
                            class="draw-color-choice br-100 bg-washed-yellow ba br1"
                            style="display: inline-block; width: 48px; height: 48px;"
                            hex="FFFCEB"
                        >&nbsp;</span>
                    </div>
                </div>


                <div class="row mt4">
                    <div class="col-9">
                        <div id="draw-size"></div>
                    </div>
                    <div class="col-3">
                        <span
                            id="draw-size-demo"
                            class="br-100"
                            style="display: inline-block"
                            hex="357EDD"
                        >&nbsp;</span>
                    </div>
                </div>
            </div>

            <hr />
            <button
                class="form-control btn btn-danger"
                id="btn-delete"
            >
                <i class="material-icons">delete_forever</i>
            </button>
        </div>
    </div>
</div>

<!-- <div id="modal-text" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <textarea
                    id="emoji-input"
                    class="form-control"
                ></textarea>
                
                <button type="button" class="mt-3 form-control btn btn-outline-primary" data-dismiss="modal">
                    <span aria-hidden="true">Done</span>
                </button>
            </div>
        </div>
    </div>
</div> -->


<script>
    $(document).ready(function() {
        // $("#modal-text").modal({
        //     show: false
        // });
        
        let Canvas = new fabric.Canvas("story-frame");
        let isDrawMode = false;
        let drawColor = "#000";
        let drawSize = 25;

        //? Add change listener to uploader element
        let imageLoader = document.getElementById("imageLoader");
            imageLoader.addEventListener("change", uploadImage, false);

        //? Handle the actual image upload from client and put it into Fabric object on the Canvas
        function uploadImage(e){
            let reader = new FileReader();

            reader.onload = function(event){
                let img = new Image();                

                img.onload = function() {
                    let canvas = document.createElement("canvas");
                    canvas.width = img.width;
                    canvas.height = img.height;
                    let ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0);
                    let dataURL = canvas.toDataURL("image/png");

                    fabric.Image.fromURL(dataURL, function(oImg) {
                        //? Flip image on X or Y axis--these are true flips, not rotations
                        // oImg.set("flipX", true);
                        // oImg.set("flipY", true);
                        Canvas.add(oImg);

                        delete canvas;
                    });
                }
                img.src = event.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);     
        }

        function updateDrawSizeDemo() {
            // let width = +$("#draw-size-demo").css("width"),
            //     height = +$("#draw-size-demo").css("height");

            $("#draw-size-demo").css("background-color", drawColor);
            $("#draw-size-demo").css("width", drawSize);
            $("#draw-size-demo").css("height", drawSize);
            
            Canvas.freeDrawingBrush.color = drawColor;
            Canvas.freeDrawingBrush.width = drawSize;
        }
        $("#draw-size").slider({
            value: drawSize,
            min: 1,
            max: 100,
            slide: function(event, ui) {
                drawSize = +ui.value;

                $("#draw-size").val(drawSize);
                
                updateDrawSizeDemo();
            }
        });

        $(document).on("click", ".draw-color-choice", function(e) {
            drawColor = `#${ $(this).attr("hex") }`;

            updateDrawSizeDemo();
        });
        
        $(document).on("click", "#btn-delete", function(e) {
            Canvas.remove(Canvas.getActiveObject());
        });
        $(document).on("click", "#btn-text", function(e) {
            let text = new fabric.Textbox("Lorem ipsum dolor", {
                textAlign: "center",
                fill: "#000"   //* This is the "text color" (as well as over/under/strike lines)
            });
            Canvas.add(text);
        });
        $(document).on("click", "#btn-draw", function(e) {
            isDrawMode = !isDrawMode;
            
            $(this).toggleClass("active");

            Canvas.isDrawingMode = isDrawMode;

            if(isDrawMode) {
                $("#draw-tools").show();
            } else {
                $("#draw-tools").hide();
            }
        });

        // $(document).on("click", "#btn-image", function(e) {
        //     $("#imageLoader").trigger("change");
        // });        
    });
</script>

<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_footer.php";
?>