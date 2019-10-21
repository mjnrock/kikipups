<div class="container mt4">
    <div class="row mt4"> 
        <input type="text" class="form-control" placeholder="Title" />
    </div>

    <div class="row mt4"> 
        <input type="text" class="col form-control" id="datepicker" placeholder="Date" />
        <input type="text" class="col form-control" id="timepicker-start" placeholder="Start" />
        <input type="text" class="col form-control" id="timepicker-end" placeholder="End" />
    </div>

    <div class="row mt4">
        <div class="col-4 text-center">
            <img src="./assets/images/map-1.png" alt="Map">

            <div>
                <span>123 Dog Park, Rd.</span>
                <br />
                <span>Dog, MI 48362</span>
            </div>
        </div>
        <div class="col-8">
            <textarea id="event-content"></textarea>
        </div>
    </div>

    <div class="row mt4 text-center">
        <div class="card alert-primary mb-3" style="max-width: 300px;min-width: 300px;">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="./assets/images/raccoon.png" class="card-img" alt="">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Buddha</h5>
                    <p class="card-text">He's a cat</p>
                </div>
                </div>
            </div>
        </div>
        
        <div class="ml2 card alert-primary mb-3" style="max-width: 300px;min-width: 300px;">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="./assets/images/PusheenSuperFancy.gif" class="card-img" alt="">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">LeKiszka</h5>
                    <p class="card-text">Another Kiszka?!</p>
                </div>
                </div>
            </div>
        </div>
        
        <div class="ml2 card mb-3" style="max-width: 300px;min-width: 300px;">
            <div class="row alert-dark no-gutters">
                <div class="col-md-4">
                    <img src="./assets/images/pusheen.png" class="card-img" alt="">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Butters</h5>
                    <p class="card-text">He's a cat, too</p>
                </div>
                </div>
            </div>
        </div>
    </div>
    
    <input type="button" class="mt4 form-control btn btn-success" value="Create" />
</div>

<script>
    $(document).ready(function(event) {
        $("#datepicker").datepicker();
        $("#timepicker-start").timepicker();
        $("#timepicker-end").timepicker();

        var simplemde = new SimpleMDE({ element: $("#event-content")[0] });
    });
</script>