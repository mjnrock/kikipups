<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_header.php";
?>

<style>
    .fileUpload {
        position: relative;
        overflow: hidden;
        margin: 0;
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

<div class="container">
    <div class="row ba br2">
        <div class="col-6">
            <canvas
                id="story-frame"
                class="ba br2 ml-4 mt-4"
                width="400"
                height="700"
            ></canvas>
        </div>
        <div class="col-6">
            <button
                class="form-control btn btn-outline-secondary mt-2"
                id="btn-text"
            >Text</button>
            <div
                class="fileUpload form-control btn btn-outline-secondary mt-2"
                id="btn-image"
            >
                <span>File</span>
                <input
                    type="file"
                    id="imageLoader"
                    class="upload"
                />
            </div>
            <button
                class="form-control btn btn-outline-secondary mt-2"
                id="btn-draw"
            >Draw</button>
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
        
        $(document).on("click", "#btn-text", function(e) {
            let text = new fabric.Textbox("Lorem ipsum dolor", {
                textAlign: "center",
                fill: "#000"   //* This is the "text color" (as well as over/under/strike lines)
            });
            Canvas.add(text);
        });

        // $(document).on("click", "#btn-image", function(e) {
        //     $("#imageLoader").trigger("change");
        // });        
    });
</script>

<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_footer.php";
?>