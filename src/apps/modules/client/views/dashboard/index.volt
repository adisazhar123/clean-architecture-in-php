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
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/foods">Foods </a>
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
            <div class="row">
                <h3>Menu</h3>
            </div>
            <div class="row">
                {% for food in foods.getFoods() %}
                <div class="col-md-3 mb-3">
                    <div class="card h-100 food mb-3">
                        <div class="card-body food" id='{{ food['food_id'] }}'>
                            <h5 class="card-title">{{ food['name'] }}</h5>
                            <p class="card-text">{{ food['description'] }}</p>
                            <h5>Rp.</h5>
                            <h5 class="price">{{ foods.formatToRupiah(food['price']) }}</h5>
                            <input type="hidden" class="count_price" value="{{ food['price'] }}"  >
                            <input type="hidden" name="hidden_price" value="{{ food['price'] }}" class="hidden_price" >
                        </div>
                        <div class="card-footer">
                            <button btn-food-id='{{ food['food_id'] }}' class="btn btn-primary purchase">Purchase</button>
                        </div>
                    </div>
                </div>
                {% endfor %}
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                    data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    In Cart
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row in-cart">
                                    <p>Empty</p>
                                </div>
                                <div class="total">
                                    <h5 id="total">Total: Rp 0</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Order Details
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="col-md-6">
                                    <div class="form">
                                        <form action="#">
                                            <div class="form-group">
                                                <label for="">Customer Name</label>
                                                <input type="text" class="form-control" name="customer_name">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Phone Number</label>
                                                <input type="text" class="form-control" name="customer_phone">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Order Description</label>
                                                <textarea class="form-control" name="description" id="" cols="30"
                                                    rows="10"></textarea>
                                            </div>
                                            <button type="button" class="btn btn-primary buy-meal">Buy Meal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        function convertToRupiah(angka) {
            var rupiah = '';
            var angkarev = angka.toString().split('').reverse().join('');
            for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
            return rupiah.split('',rupiah.length-1).reverse().join('') + ',00';
        }

        $(document).ready(function () {
            let foods = [];
            let total = 0;

            $(".purchase").click(function () {
                let foodId = $(this).attr('btn-food-id');
                let inCart = foods.find(fd => fd.id == foodId);
                const price = $(".food#" + foodId + " .hidden_price").val();
                console.log(price);
                total += parseFloat(price);

                if (inCart) {
                    inCart.amount = inCart.amount + 1;
                } else {

                    let food = {
                        id: foodId,
                        name: $(".food#" + foodId + " .card-title").text(),
                        price: $(".food#" + foodId + " .count_price").val(),
                        amount: 1
                    };

                    foods.push(food);
                }

                const foodCart = $(".in-cart");
                foodCart.html("");

                foods.map((fd, idx) => {
                    foodCart.append(
                        `<div class="col-md-3 mb-3">
                        <div class="card h-100 food-cart">
                        <div class="card-body customer-food">
                        <h4>${fd.name}</h4>
                        <h5>${fd.amount} x</h5>
                        </div>
                    </div>
                    </div>`
                    );
                });

                $("#total").text("Rp " + convertToRupiah(total));

            });

            function resetMealOrder() {
                foods = [];
                total = 0;
                const foodCart = $(".in-cart");
                foodCart.html("Empty");
                $("input[name='customer_name']").val("");
                $("input[name='customer_phone']").val("");
                $("textarea[name='description']").val("");
            }


            $(".buy-meal").click(async function () {
                let customer = {
                    name: $("input[name='customer_name']").val(),
                    phone: $("input[name='customer_phone']").val(),
                    description: $("textarea[name='description']").val(),
                };

                try {
                    await $.ajax({
                        url: '/orders',
                        method: 'POST',
                        data: {
                            customer,
                            foods
                        },
                        dataType: 'json'
                    });
                } catch (error) {
                    console.log(error);
                    console.log("ERROR")
                    return;
                }

                resetMealOrder();
                alertify.success('Success ordering customer a meal!');

            });
        });
    </script>

</body>

</html>