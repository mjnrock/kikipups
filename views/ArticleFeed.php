<div class="container mt4">
    <ul kp-pfc class="mt4 mb3 nav nav-tabs" style="cursor: pointer">
        <li kp-pft="-1" class="nav-item">
            <span class="nav-link active text-primary">All</span>
        </li>
        
        <li kp-pft="health" class="nav-item">
            <span class="nav-link">Health</span>
        </li>
        <li kp-pft="education" class="nav-item">
            <span class="nav-link">Education</span>
        </li>
        <li kp-pft="grief" class="nav-item">
            <span class="nav-link">Grief</span>
        </li>
    </ul>

    <ul kp-pc>
        <li kp-pt="health" class="row alert alert-secondary br3">
            <div class="row">
                <span class="col-2 text-center display-3">
                    <img src="./landscape-1.jpg" height="98" alt="Pic" />
                </span>
                <span class="col-8">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, nisi obcaecati eius maiores autem voluptas. Cumque, quo, temporibus deserunt molestias, assumenda nostrum voluptas nulla ex enim animi quaerat vitae explicabo.
                </span>
                <span class="col-2 text-center display-3">
                    <?= Emoji::hospital(); ?>
                </span>
            </div>

            <div class="col row mt3">
                <button class="col btn btn-outline-secondary">View</button>
            </div>
        </li>
        
        <li kp-pt="education" class="row alert alert-secondary br3">
            <div class="row">
                <span class="col-2 text-center display-3">
                    <img src="./landscape-2.jpg" height="98" alt="Pic" />
                </span>
                <span class="col-8">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, nisi obcaecati eius maiores autem voluptas. Cumque, quo, temporibus deserunt molestias, assumenda nostrum voluptas nulla ex enim animi quaerat vitae explicabo.
                </span>
                <span class="col-2 text-center display-3">
                    <?= Emoji::orange_book(); ?>
                </span>
            </div>

            <div class="col row mt3">
                <button class="col btn btn-outline-secondary">View</button>
            </div>
        </li>
        
        <li kp-pt="grief" class="row alert alert-secondary br3">
            <div class="row">
                <span class="col-2 text-center display-3">
                    <img src="./landscape-3.jpg" height="98" alt="Pic" />
                </span>
                <span class="col-8">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, nisi obcaecati eius maiores autem voluptas. Cumque, quo, temporibus deserunt molestias, assumenda nostrum voluptas nulla ex enim animi quaerat vitae explicabo.
                </span>
                <span class="col-2 text-center display-3">
                    <?= Emoji::skull(); ?>
                </span>
            </div>

            <div class="col row mt3">
                <button class="col btn btn-outline-secondary">View</button>
            </div>
        </li>
    </ul>
</div>

<script>
    $(document).ready(function(event) {
        $(document).on("click", "ul[kp-pfc] > li[kp-pft]", function(e) {
            let pft = $(this).attr("kp-pft");

            $("ul[kp-pfc] > li[kp-pft]").each(function(ev) {
                $(this).find("span").removeClass("active text-primary");
            });

            if(pft === "-1") {
                $("ul[kp-pc] > li[kp-pt]").each(function(ev) {
                    $(e.target).eq(0).addClass("active text-primary");
                    $(this).show();
                });
            } else {
                $("ul[kp-pc] > li[kp-pt]").each(function(ev) {
                    let pt =  $(this).attr("kp-pt");

                    if(pft === pt) {
                        $(e.target).eq(0).addClass("active text-primary");
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
    });
</script>