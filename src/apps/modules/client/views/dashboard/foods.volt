{% extends 'layouts/layout.volt' %}
{% block content %}
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
{% endblock %}