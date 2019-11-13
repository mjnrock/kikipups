<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_header.php";

    //! GIFSHOT (MIT):  https://github.com/yahoo/gifshot
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
    <div class="row mb4">
        <div class="col">
            <video id="user-video" width="400" height="700" autoplay></video>

            <div class="btn-group col-12">
                <button id="stop-user-video" class="btn btn-outline-danger">
                    <i class="material-icons">stop</i>
                </button>
                <button id="draw-user-video" class="btn btn-outline-success">
                    <i class="material-icons">play_arrow</i>
                </button>
            </div>
        </div>
        <div class="col">
            <canvas
                id="video-canvas"
                class="ba br2"
                width="400"
                height="700"
            ></canvas>
        </div>
    </div>

    <div class="row mb4">
        <div class="col">
            <div class="form-control-group mb4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <i class="input-group-text material-icons">av_timer</i>
                    </div>
                    <input id="gif-interval" type="number" class="form-control" name="gif-interval" min="0.1" max="5" step="0.1" value="1.0" />
                </div>

                <button id="btn-make-gif" class="form-control mt2 btn btn-success">
                    <i class="material-icons">gif</i>
                </button>
            </div>

            <ul class="story-frame-container">
                <!-- <li class="story-frame">
                    <div>
                        <img width="40" height="70"/>
                    </div>

                    <div class="btn-group">
                        <button action="c2i" class="btn btn-primary">
                            <i class="material-icons">publish</i>
                        </button>
                        <button action="i2c" class="btn btn-outline-primary">
                            <i class="material-icons">file_download</i>
                        </button>
                        <button action="delete" class="btn btn-danger">
                            <i class="material-icons">delete</i>
                        </button>
                    </div>
                </li> -->
            </ul>
            
            <button id="btn-add-frame" class="btn btn-success">+</button>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <canvas
                id="story-active-frame"
                class="ba br2"
                width="400"
                height="700"
            ></canvas>
        </div>
        
        <div class="col-6">
            <button
                class="form-control btn btn-outline-secondary mt-2"
                id="btn-background-color"
            >
                <input id="background-color" type="color" hidden />
                <i class="material-icons">color_lens</i>
            </button>
            <button
                class="form-control btn btn-outline-secondary mt-2"
                id="btn-text"
            >
                <i class="material-icons">text_fields</i>
            </button>
            <button
                class="form-control btn btn-outline-secondary mt-2"
                id="btn-emoji"
            >
                😀
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
                <i class="material-icons">brush</i>
            </button>
            <button
                class="form-control btn btn-outline-secondary mt-2"
                id="btn-camera"
            >
                <i class="material-icons">camera_alt</i>
            </button>
            <button
                class="form-control btn btn-primary mt-2"
                id="btn-download"
            >
                <i class="material-icons">file_download</i>
            </button>

            <div class="toolsets">
                <div id="text-tools" style="display: none;">
                    <div class="row mt4">
                        <div class="col">
                            <div class="btn-group">
                                <button
                                    class="text-button btn btn-outline-secondary pa3 pb1"
                                    action="bold"
                                >
                                    <i class="material-icons">format_bold</i>
                                </button>
                                <button
                                    class="text-button btn btn-outline-secondary pa3 pb1"
                                    action="italic"
                                >
                                    <i class="material-icons">format_italic</i>
                                </button>
                                <button
                                    class="text-button btn btn-outline-secondary pa3 pb1"
                                    action="underline"
                                >
                                    <i class="material-icons">format_underlined</i>
                                </button>
                                <button
                                    class="text-button btn btn-outline-secondary pa3 pb1"
                                    action="linethrough"
                                >
                                    <i class="material-icons"><i class="material-icons">strikethrough_s</i></i>
                                </button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="btn-group">
                                <button
                                    class="text-button btn btn-outline-secondary pa3 pb1"
                                    action="align-left"
                                >
                                    <i class="material-icons">format_align_left</i>
                                </button>
                                <button
                                    class="text-button btn btn-outline-secondary pa3 pb1"
                                    action="align-center"
                                >
                                    <i class="material-icons">format_align_center</i>
                                </button>
                                <button
                                    class="text-button btn btn-outline-secondary pa3 pb1"
                                    action="align-right"
                                >
                                    <i class="material-icons">format_align_right</i>
                                </button>
                                <button
                                    class="text-button btn btn-outline-secondary pa3 pb1"
                                    action="align-justify"
                                >
                                    <i class="material-icons">format_align_justify</i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row mt4">
                        <div class="offset-sm-2"></div>
                        <div class="col">
                            <select id="text-font" class="ba br2 pa3">
                                <option> Serif </option>
                                <option> Arial </option>
                                <option> Sans-Serif </option>                                  
                                <option> Tahoma </option>
                                <option> Verdana </option>
                                <option> Lucida Sans Unicode </option>                               
                            </select>
                        </div>
                        <div class="col">
                            <input id="text-color" type="color" class="ba br2 pa3 h3" />
                        </div>
                    </div>

                    <div class="row mt4">
                        <div class="col">
                            <span
                                class="text-color-choice br-100 bg-black"
                                style="display: inline-block; width: 48px; height: 48px;"
                                hex="000000"
                            >&nbsp;</span>
                        </div>
                        <div class="col">
                            <span
                                class="text-color-choice br-100 bg-white ba br1"
                                style="display: inline-block; width: 48px; height: 48px;"
                                hex="FFFFFF"
                            >&nbsp;</span>
                        </div>
                        <div class="col">
                            <span
                                class="text-color-choice br-100 bg-red"
                                style="display: inline-block; width: 48px; height: 48px;"
                                hex="FF4136"
                            >&nbsp;</span>
                        </div>
                        <div class="col">
                            <span
                                class="text-color-choice br-100 bg-green"
                                style="display: inline-block; width: 48px; height: 48px;"
                                hex="19A974"
                            >&nbsp;</span>
                        </div>
                        <div class="col">
                            <span
                                class="text-color-choice br-100 bg-blue"
                                style="display: inline-block; width: 48px; height: 48px;"
                                hex="357EDD"
                            >&nbsp;</span>
                        </div>
                        <div class="col">
                            <span
                                class="text-color-choice br-100 bg-yellow"
                                style="display: inline-block; width: 48px; height: 48px;"
                                hex="FFD700"
                            >&nbsp;</span>
                        </div>
                    </div>
                </div>

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
            </div>

            <hr />
            <button
                class="form-control btn btn-outline-danger"
                id="btn-delete"
            >
                <i class="material-icons">layers_clear</i>
            </button>
            <button
                class="form-control btn btn-danger mt2"
                id="btn-clear-canvas"
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
        
        const video = document.getElementById("user-video"),
            videoCanvas = document.getElementById("video-canvas"),
            videoContext = videoCanvas.getContext("2d");
        
        //? If "backgroundColor" is not present, Canvas will be transparent and will cause issues when converting to GIF (i.e. transparent layers)
        const Canvas = new fabric.Canvas("story-active-frame", {
            backgroundColor: "#FFF"
        });
        let isDrawMode = false;
        let drawColor = "#000";
        let drawSize = 25;

        //? All JS uses this variable, but HTML above has these hardcoded for testing (change when needed)
        const dimensions = {
            width: 400,
            height: 700
        };

        Canvas.on({
            "selection:updated": canvasObjectSelectHandler,
            "selection:created": canvasObjectSelectHandler,
            "selection:cleared": (e) => canvasObjectSelectHandler(e, true)
        });
        
        const emojiPicker = new EmojiButton({
            autoHide: true,

            i18n: {
                search: "Search",
                categories: {
                    recents: "Recently Used",
                    smileys: "Smileys & People",
                    animals: "Animals & Nature",
                    food: "Food & Drink",
                    activities: "Activities",
                    travel: "Travel & Places",
                    objects: "Objects",
                    symbols: "Symbols",
                    flags: "Flags"
                },
                notFound: "No emojis found"
            }
        });
        emojiPicker.on("emoji", emoji => {
            let text = new fabric.Textbox(emoji, {
                fontSize: 80
            });

            Canvas.add(text);
        });
        $(document).on("click", "#btn-emoji", function(e) {
            emojiPicker.pickerVisible ? emojiPicker.hidePicker() : emojiPicker.showPicker($("#btn-emoji"));
        });

        function canvasObjectSelectHandler(e, clear = false) {
            if(e.selected && e.selected.length === 1) {
                if(e.target instanceof fabric.Text) {
                    $("#text-tools").show();
                    $("#draw-tools").hide();
                } else if(e.target instanceof fabric.Path) {
                    $("#draw-tools").show();
                    $("#text-tools").hide();
                }
            }
        }

        //? Add change listener to uploader element
        let imageLoader = document.getElementById("imageLoader");
            imageLoader.addEventListener("change", uploadImage, false);

        function updateTextFont() {
            let selector = document.getElementById( "text-font" ),
                family = selector.options[ selector.selectedIndex ].value,            
                layer = Canvas.getActiveObject();

            if(layer) {
                layer.set({
                    fontFamily: family
                });

                Canvas.renderAll();
            }
        }
        $(document).on("change", "#text-color", updateTextColor);
        $(document).on("change", "#background-color", function(e) {    
            Canvas.set({
                backgroundColor: e.target.value
            });

            Canvas.renderAll();
        });

        function updateTextColor() {
            let color = document.getElementById("text-color").value,
                layer = Canvas.getActiveObject();

            if(layer) {
                layer.set({
                    fill: color
                });

                Canvas.renderAll();
            }
        }
        $(document).on("change", "#text-font", updateTextFont);

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
            
                let layer = Canvas.getActiveObject();

                if(layer) {
                    layer.set({
                        strokeWidth: drawSize
                    });

                    Canvas.renderAll();
                }
                
                updateDrawSizeDemo();
            }
        });

        $(document).on("click", ".draw-color-choice", function(e) {
            drawColor = `#${ $(this).attr("hex") }`;
            
            let layer = Canvas.getActiveObject();

            if(layer) {
                layer.set({
                    stroke: drawColor
                });

                Canvas.renderAll();
            }
            
            updateDrawSizeDemo();
        });
        
        $(document).on("click", ".text-button", function(e) {
            if($(this).attr("action").startsWith("align")) {
                $("[action*=align]").each(function(e, v) {
                    $(v).removeClass("active");
                });
            }
            $(this).toggleClass("active");

            let action = $(this).attr("action"),
                layer = Canvas.getActiveObject(),
                map = {
                    "bold": (test) => [ `fontWeight`, test === true, `bold`, `normal` ],
                    "italic": (test) => [ `fontStyle`, test === true, `italic`, `normal` ],
                    "underline": (test) => [ `underline`, test === true, `true`, null ],
                    "linethrough": (test) => [ `linethrough`, test === true, `true`, null ]
                };

            if(layer) {
                for(let tx in map) {
                    if(action === tx) {
                        let act = map[ tx ](!!$(this).hasClass("active")),
                            obj = {};

                        obj[ act[ 0 ] ] = act[ 1 ] ? act[ 2 ] : act[ 3 ];
                        layer.set(obj);

                        Canvas.renderAll();
                    } else if(action.startsWith("align")) {
                        let [ verb, value ] = action.split("-");

                        layer.set({
                            "textAlign": value
                        });

                        Canvas.renderAll();
                    }
                }
            }
        });
        $(document).on("click", ".text-color-choice", function(e) {
            let color = `#${ $(this).attr("hex") }`,
                layer = Canvas.getActiveObject();

            if(layer) {
                layer.set({
                    fill: color
                });

                Canvas.renderAll();
            }
        });
        
        $(document).on("click", "#btn-download", function(e) {
            window.open(Canvas.toDataURL({
                format: "png",
                quality: 1.0
            }));
        });

        $(document).on("click", "#btn-background-color", function(e) {
            $("#background-color")[0].click();
        });
        $(document).on("click", "#btn-delete", function(e) {
            Canvas.remove(Canvas.getActiveObject());
        });
        $(document).on("click", "#btn-text", function(e) {
            let text = new fabric.Textbox("Text", {
                fill: "#000"
            });
            Canvas.add(text);
        });
        $(document).on("click", "#btn-draw", function(e) {
            isDrawMode = !isDrawMode;
            
            $(this).toggleClass("active");

            Canvas.isDrawingMode = isDrawMode;

            if(isDrawMode) {
                updateDrawSizeDemo();
                $("#draw-tools").show();
            } else {
                $("#draw-tools").hide();
            }
        });
        
        //FIXME This can only be called once, so this is clearly not the proper way to do this--if you Play, Stop, then Play, the camera will not re-activate
        $(document).on("click", "#btn-camera", function(e) {
            if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {                
                if(video.srcObject && video.srcObject.getTracks().length > 0) {
                    var hRatio = dimensions.width / video.videoWidth,
                        vRatio = dimensions.height / video.videoHeight,
                        ratio  = Math.min(hRatio, vRatio);

                    videoContext.drawImage(video, 0, 0, video.videoWidth, video.videoHeight, 0, 0, 400, video.videoHeight * vRatio);
                } else {
                    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
                        //video.src = window.URL.createObjectURL(stream);
                        video.srcObject = stream;
                        video.play();
                    });
                }
            }
        });
        $(document).on("click", "#draw-user-video", function(e) {
            $("#btn-camera")[0].click();
            fabric.Image.fromURL(videoCanvas.toDataURL(), function(oImg) {
                Canvas.add(oImg);
            });
        });

        //FIXME While this stops the track, it cannot be restarted--not sure if from this method or from the invocation method to begin with
        $(document).on("click", "#stop-user-video", function(e) {
            video.srcObject.getTracks().forEach(track => track.stop());
        });

        $(document).on("click", "#btn-clear-canvas", function(e) {
            Canvas.clear();
        });

        $(document).on("click", "#btn-add-frame", function(e) {
            $(".story-frame-container").append(`
                <li class="story-frame">
                    <div>
                        <img width="40" height="70"/>
                    </div>

                    <div class="btn-group">
                        <button action="c2i" class="btn btn-primary">
                            <i class="material-icons">publish</i>
                        </button>
                        <button action="i2c" class="btn btn-outline-primary">
                            <i class="material-icons">file_download</i>
                        </button>
                        <button action="delete" class="btn btn-danger">
                            <i class="material-icons">delete</i>
                        </button>
                    </div>
                </li>
            `);
        });
        
        function UUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        let Canvases = {};
        $(document).on("click", ".story-frame button", function(e) {
            let action = $(this).attr("action"),
                _li = $(this).parent().parent();

            if(action === "i2c") {
                let json = Canvases[ _li.attr("uuid") ];
                Canvas.loadFromJSON(json, function() {
                    Canvas.renderAll(); 
                });
            } else if(action === "c2i") { 
                _li.find("img").attr("src", Canvas.toDataURL({
                    format: "png",
                    quality: 1.0,
                    multiplier: 0.1
                }));

                let uuid = UUID();
                _li.attr("uuid", uuid);
                Canvases[ uuid ] = Canvas.toJSON();
            } else if(action === "delete") {
                delete Canvases[ _li.attr("uuid") ];
                _li.remove();
            }
        });


        //? To save editable GIFs, create a JSON file that takes the Canvases JSON data and saves that, instead/also
        $(document).on("click", "#btn-make-gif", function(e) {
            let images = [],
                _tempCanvas = new fabric.Canvas();

            $(".story-frame-container img").each(function(e, v) {
                let json = Canvases[ $(v).parent().parent().attr("uuid") ];
                _tempCanvas.loadFromJSON(json, function() {
                    _tempCanvas.set({
                        width: dimensions.width,
                        height: dimensions.height
                    });
                    _tempCanvas.renderAll();

                    let data = _tempCanvas.toDataURL({
                        format: "png",
                        quality: 1.0
                    });
                    
                    images.push(data);
                    
                    animatedImage = document.createElement("img");
                    animatedImage.src = data;
                    document.body.appendChild(animatedImage);
                });
            });

            //FIXME There must be an ASYNC call from FabricJS to Images, as synchronous gifshot.createGIF(...) will faill on Object layers that contain images by the JSON rendering method I'm using
            //NOTE Because of this, this is here as a janky fix.  Convert to Promise at some point, but it works--even with a 50ms delay--for now.
            setTimeout(() =>
                gifshot.createGIF({
                    "images": images,
                    gifWidth: dimensions.width,
                    gifHeight: dimensions.height,
                    interval: +$("#gif-interval").val()
                }, function(obj) {
                    if(!obj.error) {
                        //ANCHOR [Debug Only] This section adds the image into an <img /> at the end of the page
                            var image = obj.image,
                            animatedImage = document.createElement("img");
                            animatedImage.src = image;
                            document.body.appendChild(animatedImage);
                        //ENDANCHOR

                        //TODO Have a triggering event to perform the open (e.g. button click)
                        window.open(animatedImage.src);
                    }
                })
            , 50);
        });
    });
</script>

<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/views/_footer.php";
?>