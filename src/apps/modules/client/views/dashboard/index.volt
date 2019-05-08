<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>


    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
        <div class="container">
            <a class="navbar-brand" href="#">Adis Resto</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
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
                {% for food in viewModel['foods'] %}
                    <div class="col-md-3">
                        <div class="card food mb-3">
                            <div class="card-body food" id='{{ food.getId() }}'>
                                <h5 class="card-title">{{ food.getName() }}</h5>
                                <p class="card-text">{{ food.getDescription() }}</p>
                               <h5>Rp.</h5> <h5 class="price">{{food.getPrice()}}</h5>
                            </div>
                            <div class="card-footer">                                
                                <button btn-food-id='{{ food.getId() }}' class="btn btn-primary purchase">Purchase</button>
                            </div>
                        </div>
                    </div>
                {% endfor %}
            </div>    
        </div>
    </div>

    <div class="container">
        <div class="row">
            <h3>In Cart</h3>
        </div>
        <div class="row">
            <div class="in-cart">
               <div class="card food-cart">
                   
               </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <h3>Order Details</h3>
        </div>

        <div class="row">         
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
                            <textarea class="form-control" name="description" id="" cols="30" rows="10"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary buy-meal">Buy Meal</button>
                    </form>
                </div>
            </div>                   
        </div>
    </div>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
    $(document).ready(function() {

        let foods = [];

        $(".purchase").click(function() {
            let foodId = $(this).attr('btn-food-id');
            console.log(foodId);

            let inCart = foods.find(fd => fd.id == foodId);
            // console.log(inCart);
            if (inCart) {
                inCart.amount = parseInt(inCart.amount) + 1;                
            } else {

                let food = {
                    id: foodId,
                    name: $(".food#" + foodId + " .card-title").text(),
                    price: $(".food#" + foodId + " .price").text(),
                    amount: 1
                };

                foods.push(food);                
            }

            const foodCart = $(".food-cart");
            foodCart.html("");

            foods.map((fd, idx) => {
                foodCart.append(
                    `<div class="card-body customer-food">
                       <h4>${fd.name}</h4>
                       <h5>${fd.amount} x</h5>
                    </div>`
                   );
            });
            
            // foodCart
            console.log(foods);

        });


        $(".buy-meal").click(async function() {
            let customer = {
                name: $("input[name='customer_name']").val(),
                phone: $("input[name='customer_phone']").val(),
                description: $("textarea[name='description']").val(),
            };

            console.log({customer, foods});

            try {
                await $.ajax({
                    url: '/orders',
                    method: 'POST',
                    data: {customer, foods},
                    dataType: 'json'
                });                
            } catch (error) {
                console.log(error);
                return;
            }
        });
    });
    </script>

  </body>
</html>