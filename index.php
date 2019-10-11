<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tachyons/4.11.1/tachyons.min.css" integrity="sha256-XiJ+PedljEmPP2VaQzSzekfCZdPr0fpqmh9dY6kpsuQ=" crossorigin="anonymous" />

        <title>Document</title>
    </head>
    <body>
        <div class="container">
            <ul kp-pfc class="nav nav-tabs" style="cursor: pointer">
                <li kp-pft="-1" class="nav-item">
                    <span class="nav-link active">All</span>
                </li>
                
                <li kp-pft="post" class="nav-item">
                    <span class="nav-link">Post</span>
                </li>
                <li kp-pft="mood" class="nav-item">
                    <span class="nav-link">Mood</span>
                </li>
                <li kp-pft="alert" class="nav-item">
                    <span class="nav-link">Alert</span>
                </li>
                <li kp-pft="question" class="nav-item">
                    <span class="nav-link">Question</span>
                </li>
                <li kp-pft="quote" class="nav-item">
                    <span class="nav-link">Quote</span>
                </li>
            </ul>

            <ul kp-pc>
                <li kp-pt="mood" class="row alert alert-light br3">
                    <span class="ba br-100" style="overflow: hidden">
                        <img src="./PusheenSuperFancy.gif" height="98" alt="Pic" />
                    </span>
                    <span class="col-2 text-center display-3">
                        &#x1F600
                    </span>
                    <span class="col-8">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, nisi obcaecati eius maiores autem voluptas. Cumque, quo, temporibus deserunt molestias, assumenda nostrum voluptas nulla ex enim animi quaerat vitae explicabo.
                    </span>
                </li>
                
                <li kp-pt="alert" class="row alert alert-danger br3">
                    <span class="ba br-100" style="overflow: hidden">
                        <img src="./PusheenSuperFancy.gif" height="98" alt="Pic" />
                    </span>
                    <span class="col-2 text-center display-3">
                        &#x2757
                    </span>
                    <span class="col-8">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, nisi obcaecati eius maiores autem voluptas. Cumque, quo, temporibus deserunt molestias, assumenda nostrum voluptas nulla ex enim animi quaerat vitae explicabo.
                    </span>
                </li>
                
                <li kp-pt="question" class="row alert alert-info br3">
                    <span class="ba br-100" style="overflow: hidden">
                        <img src="./PusheenSuperFancy.gif" height="98" alt="Pic" />
                    </span>
                    <span class="col-2 text-center display-3">
                        &#x2754
                    </span>
                    <span class="col-8">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, nisi obcaecati eius maiores autem voluptas. Cumque, quo, temporibus deserunt molestias, assumenda nostrum voluptas nulla ex enim animi quaerat vitae explicabo.
                    </span>
                </li>

                <li kp-pt="mood" class="row alert alert-light br3">
                    <span class="ba br-100" style="overflow: hidden">
                        <img src="./raccoon.png" height="98" alt="Pic" />
                    </span>
                    <span class="col-2 text-center display-3">
                        &#x1F625
                    </span>
                    <span class="col-8">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, nisi obcaecati eius maiores autem voluptas. Cumque, quo, temporibus deserunt molestias, assumenda nostrum voluptas nulla ex enim animi quaerat vitae explicabo.
                    </span>
                </li>

                <li kp-pt="post" class="row alert alert-light br3">
                    <span class="ba br-100" style="overflow: hidden">
                        <img src="./PusheenSuperFancy.gif" height="98" alt="Pic" />
                    </span>
                    <span class="col">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, nisi obcaecati eius maiores autem voluptas. Cumque, quo, temporibus deserunt molestias, assumenda nostrum voluptas nulla ex enim animi quaerat vitae explicabo.
                    </span>
                </li>

                <li kp-pt="quote" class="row alert alert-secondary br3">
                    <span class="ba br-100" style="overflow: hidden">
                        <img src="./raccoon.png" height="98" alt="Pic" />
                    </span>
                    <span class="col font-italic">
                        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, nisi obcaecati eius maiores autem voluptas. Cumque, quo, temporibus deserunt molestias, assumenda nostrum voluptas nulla ex enim animi quaerat vitae explicabo."
                    </span>
                </li>
            </ul>
        </div>

        <script>
            $(document).ready(function(event) {
                $(document).on("click", "ul[kp-pfc] > li[kp-pft]", function(e) {
                    let pft = $(this).attr("kp-pft");

                    if(pft === "-1") {
                        $("ul[kp-pc] > li[kp-pt]").each(function(e) {
                            $(this).show();
                        });
                    } else {
                        $("ul[kp-pc] > li[kp-pt]").each(function(e) {
                            let pt =  $(this).attr("kp-pt");

                            if(pft === pt) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>