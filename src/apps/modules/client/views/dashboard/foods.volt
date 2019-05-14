<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/css/mdb.min.css" rel="stylesheet">

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/bootstrap.min.css"/>
    <title>Resto Adis</title>
</head>

<body>


<nav class="navbar navbar-expand-lg navbar-dark primary-color-dark mb-3">
    <div class="container">
        <a class="navbar-brand" href="#">Adis Resto</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/foods">Foods <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/orders">Orders</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="foods">
        <h3>Foods in the Menu
            <button class="btn btn-primary add" style="float: right">Add Food</button>
        </h3>

        <div class="row foods-inner">
                {% for food in foods.getFoods() %}
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 food mb-3">
                            <div class="card-body food" id='{{ food['food_id'] }}'>
                                <h5 class="card-title">{{ food['name'] }}</h5>
                                <p class="card-text">{{ food['description'] }}</p>
                                <h5>Rp.</h5>
                                <h5 class="price">{{ foods.formatToRupiah(food['price']) }}</h5>
                            </div>
                            <div class="card-footer">
                                <button btn-food-id='{{ food['food_id'] }}' class="btn btn-primary edit">Edit</button>
                            </div>
                        </div>
                    </div>
                {% endfor %}

        </div>
    </div>
</div>

<div class="modal fade food-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="#" class="food-form">
                    <div class="form-group">
                        <label for="name">Food Name</label>
                        <input type="text" name="name" id="" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="description">Food Description</label>
                        <input type="text" name="description" id="" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="name">Food Price</label>
                        <input type="text" name="price" id="" class="form-control">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary save">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<br>


<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/alertify.min.js"></script>

<script>
    $(document).ready(function () {
        let foods = [];
        let action = '';
        let foodId = '';
        const foodModal = $(".food-modal");


        $(".add").click(function() {
            foodModal.modal('show');
            action = 'create';
        });

        $(".edit").click(async function() {
            action = 'update';
            foodId = $(this).attr('btn-food-id');
            let food;
            try {
                food = await $.ajax({
                   url: `/foods/${foodId}`,
                   dataType: 'json'
                });
            } catch (e) {
                console.log(e);
                return false;
            }

            $("input[name='name']").val(food.name);
            $("input[name='description']").val(food.description);
            $("input[name='price']").val(food.price);

            console.log(food);
            foodModal.modal('show');
        });

        $(".save").click(async function() {
            let food;
            let url = '/foods';
            let method = 'POST';

            if(action == 'update') {
                url = `/foods/${foodId}`;
                method = 'PUT';
            }

            try {
                food = await $.ajax({
                    url: url,
                    method: method,
                    data: $('.food-form').serialize(),
                    dataType: 'json'
                });
            } catch(e) {
                console.log(e);
                return false;
            }

            alertify.success("Food saved succesfully!");
            $(".food-modal form")[0].reset();
            foodModal.modal('hide');

            setTimeout(function(){
                window.location = "/foods";
            }, 700);

            console.log(food);

        });


    });
</script>

</body>

</html>