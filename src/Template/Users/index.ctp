<style type="text/css">
    #payment-form {
        padding: 5%;
    }
</style>
<div class="row" id="payment-form">
    <div class="col-md-4">
        <form id="payment-form" method="post" action="<?php echo BASE_URL; ?>Users/checkout">
            <div class="form-body">
                <h3>Payment with paypal</h3>
                <div class="form-group">
                    <input required placeholder="product" type="text" name="product" class="form-control">
                </div>
                <div class="form-group">
                    <input required placeholder="price" type="text" name="price" class="form-control">
                </div>
                <div class="action">
                    <input type="submit" class="btn btn-success" value="Pay">
                </div>
            </div>
        </form>
    </div>
</div>