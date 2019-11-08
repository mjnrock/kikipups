<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_header.php";
?>

<input type="file" id="imageLoader" name="imageLoader" />

<canvas
    id="story-frame"
    width="400"
    height="700"
    class="ba br2 ml-4 mt-4"
></canvas>

<script>
    $(document).ready(function() {
        //! Don"t delete these comments/examples like you usually do, the FabricJS documentation is shit
        //! If truly tempted to delete, send these to a separate "notes" file, instead--coming back to this after days/weeks is a bitch and you"ll need it

        //? Initializing the FabricJS canvas @(elementId)
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

        //? Selection methods for event handling or at a given moment
        //* Canvas.on("object:selected"...) appears to fire once if consecutive objects are selected--must click raw canvas to force event to fire
        // console.log(Canvas.getActiveObject());
        // function onObjectSelected(e) {
        //     console.log(e);
        // }
        // Canvas.on("object:selected", onObjectSelected);

        //? Layer manipulation
        // Canvas.bringToFront(object);
        // Canvas.bringForward(object);
        // Canvas.sendToBack(object);
        // Canvas.sendBackwards(object);
        //* Secondary methods
        // Canvas.moveTo(object, index);
        // object.moveTo(index);
        
        //? Create a FabricJS object
        let rect = new fabric.Rect({
            left: 100,
            top: 100,
            fill: "red",
            width: 100,
            height: 100,
            angle: 45
        });

        //? Add a FabricJS object to FabricJS canvas
        Canvas.add(rect);

        //?  Calling event on specific object
        //* e.transform will capture the scaling and rotation with a lot of detail
        // rect.on("mousedown", function(e) {});

        //?  Calling event at Canvas layer
        //  The events apparently need the colon at this level
        //* e.target will be the FabricJS object
        //* e.e is the original event
        //* e.pointer are the Mouse coords
        // Canvas.on("mouse:down", function(e) {});

        //? Grab a canvas object @(index)
        // Canvas.item(0);
        
        //? Grab aall canvas objects into array
        // Canvas.getObjects();

        //? Quick example to send event to console if object is dragged
        // let mousemask = 0;
        // rect.on("mousedown", function(e) {
        //     mousemask = 1;
        // });
        // rect.on("mouseup", function(e) {
        //     mousemask = 0;
        // });
        // rect.on("mousemove", function(e) {
        //     if(mousemask) {
        //         console.log(e);
        //     }
        // });

        //? Add image to Canvas
        //*  .fromURL(otherCanvas.toDataURL(), ...)
        // fabric.Image.fromURL("./assets/images/raccoon.png", function(oImg) {
        //     // Scale image and rotate -45 degrees
        //     oImg.scale(0.5).set("angle", -45);
        //     Canvas.add(oImg);
        // });

        //? Text examles
        // let text = new fabric.Text("Lorem ipsum dolor", {
        //     overline: true,
        //     underline: true,
        //     linethrough: true,
        //     shadow: "rgba(0,0,0,0.3) 5px 5px 5px",
        //     fontSize: 40,
        //     fontWeight: "bold",
        //     fontStyle: "italic",
        //     fontFamily: "Hoefler Text",
        //     textAlign: "right",
        //     fill: "#33c",   //* This is the "text color" (as well as over/under/strike lines)
        //     angle: 33,
        //     left: 100,
        //     top: 50
        // });
        // Canvas.add(text);

        //? Free-drawing examples
        //* Each continuous stroke from "mousedown" to "mouseup" becomes the FabriJSc object (i.e. for dragging, scaling, etc.)
        // Canvas.isDrawingMode = true;    //* |false| to disable
        // Canvas.freeDrawingBrush.color = "#3c3";
        // Canvas.freeDrawingBrush.width = 10;
        // //  Draw for 5 seconds, then disable for testing
        // setTimeout(() => {
        //     Canvas.isDrawingMode = false;
        // }, 5000);
    });
</script>

<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_footer.php";
?>