<div class="container mt4">
    <input type="text" class="form-control" placeholder="Title" />

    <div class="row mt4 mb4">
        <div class="col-4 text-center">
            <img src="./landscape-2.jpg" alt="Picture">
        </div>
        <div class="col-8">
            <textarea class="form-control" rows="4">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Earum, quo. Minima quibusdam aliquid laborum ipsum aliquam in nulla ab tenetur ducimus nesciunt? Quo, veritatis porro facilis inventore fugiat reiciendis suscipit.
                Assumenda non natus cumque explicabo ab vel eos ea blanditiis velit officia, maxime veritatis perferendis eaque, quod ipsam, laboriosam dignissimos placeat nesciunt repudiandae. Dolorum, aliquam nisi labore vitae officiis accusamus.
                Voluptatibus, cum eaque. Facilis quisquam reprehenderit autem tempora dolorum omnis aspernatur exercitationem quo, blanditiis reiciendis non ut quibusdam deserunt velit molestias iusto explicabo ducimus possimus nisi dolores distinctio libero error.
            </textarea>

            <input type="text" class="alert-info form-control mt2" value="#cats #dogs #sexlovedrugs" />
        </div>
    </div>

    <textarea id="article-content"></textarea>
    
    <input type="button" class="mt4 form-control btn btn-primary" value="Publish" />
</div>

<script>
    $(document).ready(function(event) {
        var simplemde = new SimpleMDE({ element: $("#article-content")[0] });
    });
</script>