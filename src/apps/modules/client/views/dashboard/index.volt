{% extends 'layouts/layout.volt' %}
{% block content %}
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
                                            <div class="form-group">
                                                <label for="">Coupon</label>
                                                <input placeholder="optional" type="text" name="coupon" id="" class="form-control">
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
{% endblock %}

 {% block script %}
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
                        <div class="card h-100 food-cart">ki
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

                let coupon = $("input[name='coupon']").val();

                try {
                    await $.ajax({
                        url: '/orders',
                        method: 'POST',
                        data: {
                            customer,
                            foods,
                            coupon
                        },
                        dataType: 'json'
                    });
                } catch (error) {
                    console.log(error);
                    console.log("ERROR");
                    let err = error.responseJSON;
                    let message = '';
                    err.message.map((el, idx) => {
                        message += `<p>${el}</p>`
                    });
                    return alertify.error(message);
                }

                resetMealOrder();
                alertify.success('Success ordering customer a meal!');

            });
        });
    </script>
{% endblock %}