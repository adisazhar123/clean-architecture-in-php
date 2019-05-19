{% extends 'layouts/layout.volt' %}
{% block content %}
    <div class="container">
        <p><?php $this->flashSession->output() ?></p>
        <div class="foods">
            <h3>Coupons
                <button class="btn btn-primary add" style="float: right">Add Coupon</button>
            </h3>

            <div class="row foods-inner">
                {% for coupon in coupons.getCoupons() %}
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 coupon mb-3">
                            <div class="card-body coupon">
                                <h5 class="card-title">{{ coupon['name'] }}</h5>
                                <p class="card-text">{{ coupon['description'] }}</p>
                                <h5 class="price">Discount {{ coupon['discount_amount'] }} %</h5>
                                <p>Date condition: {{ coupon['min_date'] }} -- {{ coupon['max_date'] }}</p>
                                <p>Minimum spending Rp {{ coupon['min_spending'] }}</p>
                            </div>
                            <div class="card-footer">
                                {% if coupon['active'] == 1 %}
                                    <button class="btn btn-primary edit">{{ coupon['code'] }}</button>
                                {% else %}
                                    <button class="btn btn-danger edit">{{ coupon['code'] }}</button>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                {% endfor %}
            </div>
        </div>
    </div>

    <div class="modal fade coupon-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="/coupons" method="POST" class="coupon-form">
                        <div class="form-group">
                            <label for="name">Coupon Name</label>
                            <input type="text" name="name" id="" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">Coupon Description</label>
                            <textarea class="form-control" name="description" id="" cols="30" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="min_date">Min Date</label>
                            <input class="form-control" type="date" id="min_date"
                                   name="min_date">
                        </div>

                        <div class="form-group">
                            <label for="max_date">Max Date</label>
                            <input class="form-control" type="date" id="max_date"
                                   name="max_date">
                        </div>

                        <div class="form-group">
                            <label for="">Discount Amount</label>
                            <small> (in percentage)</small>
                            <input name="discount_amount" type="number" max="100" min="0" step="0.01" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Minimum Spending</label>
                            <input type="text" name="min_spending" id="" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="">Coupon Code</label>
                            <input type="text" name="code" id="" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary save">Save changes</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

{% endblock %}

{% block script %}

<script>
$(document).ready(function() {
    $(".add").click(function() {
        $(".coupon-modal").modal('show');
    });
});
</script>
{% endblock %}