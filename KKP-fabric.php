<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_header.php";
?>

<canvas
    id="story-frame"
    width="350"
    height="350"
    class="ba br2 ml-4 mt-4"
></canvas>

<script>
    $(document).ready(function() {
        //! Don't delete these comments/examples like you usually do, the FabricJS documentation is shit
        //! If truly tempted to delete, send these to a separate "notes" file, instead--coming back to this after days/weeks is a bitch and you'll need it

        //? Initializing the FabricJS canvas @(elementId)
        let Canvas = new fabric.Canvas("story-frame");
        
        //? Create a FabricJS object
        let rect = new fabric.Rect({
            left: 100,
            top: 100,
            fill: 'red',
            width: 20,
            height: 20,
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
    });
</script>

<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_footer.php";
?>