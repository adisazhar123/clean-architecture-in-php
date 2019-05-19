{% extends 'layouts/layout.volt' %}
{% block content %}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="orders">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Order Description</th>
                                <th scope="col">Total Spent</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for order in orders.getOrders() %}
                            <tr>
                                <th scope="row">{{ orders.formatOrderId(order['order_id']) }}</th>
                                <td>{{ order['customer'] }}</td>
                                <td>{{ order['description'] }}</td>
                                <td>Rp {{ orders.formatToRupiah(order['price']) }}</td>
                                <td>
                                    <a href="/orders/{{ order['order_id'] }}/receipts" target="_blank" class="btn btn-info">
                                        Generate Receipt
                                    </a>

                                    <button order-id='{{ order['order_id'] }}' class="btn btn-warning details">
                                        More Details
                                    </button>

                                </td>
                            </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade order" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <table class="table table-striped table-hover">
                    <tbody class="order-table">

                    </tbody>
                </table>
                <div class="coupon">

                </div>
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>

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

    <script>
        $(document).ready(function () {
            $(".details").click(async function () {
                let foods;
                const orderId = $(this).attr('order-id');

                try {
                    foods = await $.ajax({
                       url: `/orders/${orderId}`,
                       dataType: 'json'
                    });
                } catch (error) {
                    console.log(error);
                    return;
                }

                $(".order-table").html("");
                $(".coupon").html("");

                foods.foods.map((fd, idx) => {
                    $(".order-table").append(
                        `<tr>
                            <th scope="row">${ idx+1 }</th>
                            <td>${fd.name}</td>
                            <td>${fd.description}</td>
                            <td>${fd.price}</td>
                        </tr>`     
                    );                    
                });

                foods.coupon.map((cp, idx) => {
                    $(".coupon").html(
                      `<p>Coupon Name: ${cp.name}</p><p>Code: ${cp.code}</p>`
                    );
                });

                $(".modal.order").modal('show');

            });
        });
    </script>
{% endblock %}