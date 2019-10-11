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

        <title>KiKi Pups</title>
    </head>
    <body>
        <div class="container mt4">
            <div class="row">
                <div class="col-4">
                    <img src="./PusheenSuperFancy.gif" alt="Profile">
                </div>
                <div class="col-8">
                    <div class="row display-3 text-center">
                        Kiszka
                    </div>

                    <dl class="mt4 row">
                        <dt class="col-4">Type</dt>
                        <dd class="col-8">Cat</dd>

                        <dt class="col-4">Breed</dt>
                        <dd class="col-8">DMH</dd>

                        <dt class="col-4">Color</dt>
                        <dd class="col-8">Calico</dd>
                    </dl>
                </div>
            </div>

            <div class="row mt4 text-center">
                <div class="card mb-3" style="max-width: 300px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="./raccoon.png" class="card-img" alt="">
                        </div>
                        <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Buddha</h5>
                            <p class="card-text">He's a cat</p>
                        </div>
                        </div>
                    </div>
                </div>
                
                <div class="ml3 card mb-3" style="max-width: 300px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="./PusheenSuperFancy.gif" class="card-img" alt="">
                        </div>
                        <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">LeKiszka</h5>
                            <p class="card-text">Another Kiszka?!</p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt4">
                <div class="input-group">
                    <div class="input-group-prepend dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            &#x1F4DD
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li class="dropdown-item">&#x1F4DD Post</li>
                            <li class="dropdown-item">&#x2757 Alert</li>
                            <li class="dropdown-item">&#x2754 Question</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item">
                                <input type="text" class="form-control" placeholder="Emoji Search" />

                                <table class="mt1">
                                    <tbody>
                                        <tr>
                                            <td>&#x1F600</td>
                                            <td>&#x1F603</td>
                                            <td>&#x1F604</td>
                                            <td>&#x1F601</td>
                                            <td>&#x1F602</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>&#x1F600</td>
                                            <td>&#x1F603</td>
                                            <td>&#x1F604</td>
                                            <td>&#x1F601</td>
                                            <td>&#x1F602</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>&#x1F600</td>
                                            <td>&#x1F603</td>
                                            <td>&#x1F604</td>
                                            <td>&#x1F601</td>
                                            <td>&#x1F602</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </li>
                        </ul>
                    </div>
                    <textarea
                        class="form-control"
                        rows="3"
                        style="resize: none"
                    >Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis consequatur quae doloribus fugiat voluptatum fugit, ullam minus laudantium et cupiditate sit nemo, labore nam, qui culpa mollitia impedit atque illum!</textarea>
                </div>
            </div>

            <div class="mt1">
                <button class="col btn btn-outline-primary">Post</button>
            </div>

            <ul kp-pfc class="mt4 mb3 nav nav-tabs" style="cursor: pointer">
                <li kp-pft="-1" class="nav-item">
                    <span class="nav-link active text-primary">All</span>
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
    </body>
</html>