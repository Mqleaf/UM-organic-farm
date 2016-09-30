<?php
//显示产品列表名
function do_html_heading($heading) {
    ?>
    <h2 style="margin-top: 8rem;margin-bottom: 4rem;text-align: center;">
        <?php echo $heading; ?><span class="glyphicon glyphicon-leaf"></span>
    </h2>
    <?php
}
//显示标题
function do_html_header($heading) {
    ?>
    <h3 style="margin-top: 8rem;margin-bottom: 4rem;text-align: center;">
        <?php echo $heading; ?><span class="glyphicon glyphicon-leaf"></span>
    </h3>
    <?php
}
//显示链接
function do_html_URL($url, $name) {
    ?>
    <a href="<?php echo $url; ?>"><?php echo $name; ?></a><br />
    <?php
}
//显示产品列表
function display_products($product_array) {
    if(!is_array($product_array)){
        echo '<p>No products currently available in this category</p>';
    }else{
        echo "<div class='container'><div class='row'>";
        foreach ($product_array as $row) {
            $url = "show_product.php?productid=".$row['productid'];
            echo "<div class=\"col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4\">
                <div class=\"thumbnail\">";
            if (@file_exists("public/img/".$row['productid'].".jpg")) {
                $title = "<img src=\"public/img/".$row['productid'].".jpg\" class=\"img-circle\">";
                do_html_url($url, $title);
            } else {
                echo "&nbsp;";
            }
            echo "<div class=\"caption\"> ";
            $title = $row['title'];
            $price = number_format($row['price'],2);
            echo "<h4>".$title."</h4>
                <p class=\"price\">￥".$price."</p>
                <p><a href=\"".$url."\" class=\"btn btn-success\" role=\"button\">Detail</a></p>";
            echo "</div></div></div>";
        }
        echo "</div></div>";
    }
    echo "<hr />";
}
//产品详情
function display_product_detail($product){
    ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
                <div class="thumbnail">
                    <img class="img-rounded" src="public/img/<?php echo $product['productid'];?>.jpg">
                </div>
            </div>
            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Product</h3>
                    </div>
                    <form action="cart.php" method="get">
                        <div class="panel-body">
                            <br/>
                            <p><?php echo $product['description'];?></p><br/>
                            <p>Price: ￥ <?php echo number_format($product['price'],2);?></p><br/>
                            <p>Quantity:
                                <input id="quantity" name="quantity" type="number" value="1" min="1" required/>
                                <input class="hidden" id="new" name="new" type="text" value="<?php echo $product['productid']?>"/>
                            </p>
                            <h6></h6>
                            <hr>
                            <p>
                                <button id="add_to_cart" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart</button>
                                <a href="show_category.php?catid=<?php echo $product['catid'];?>" class="btn btn-default" role="button">Go Back</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
//显示购物车
function display_cart($cart,$change=true,$images=1){
    echo "<table id=\"cartTable\" class=\"table table-condensed\">
            <thead>
            <tr class=\"success\">
                <th></th>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th></th>
            </tr>
            </thead>
            <tbody>";
    foreach($cart as $id=>$qty){
        $product = get_product_detail($id);
        echo "<tr class='item'>";
        //显示图片
        echo "<td>";
        if($images==true){
            if(file_exists("public/img/".$id.".jpg")){
                echo "<img src=\"public/img/".$id.".jpg\" width=\"40\" height=\"40\" alt=\"\"/>";
            }else{
                echo "&nbsp";
            }
        }
        echo "</td>";
        //显示产品名，单价
        echo "<td class=\"goods\">".$product['title']."</td>
        <td class=\"price\">".number_format($product['price'],2)."</td>
        <td class=\"count\">";
        //显示数量，如果可改变则放在input中，否则直接输出
        if ($change == true) {
            echo "<input class=\"qty\" type=\"number\" name=\"".$id."\" value=\"".$qty."\" min=\"0\">";
        } else {
            echo $qty;
        }
        //显示单项小计
        echo "</td>
        <td class=\"subtotal\">".number_format($product['price']*$qty,2)."</td>";
        //显示删除图标
        if($images==true){
            echo "<td class=\"remove\"><span class=\"glyphicon glyphicon-remove\"></span></td></tr>";
        }else{
            echo "<td></td></tr>";
        }

    }
    //总计
    echo "<tr class=\"success\">
                <td></td>
                <td></td>
                <td></td>
                <td class=\"count\"><span>".$_SESSION['items']."</span></td>
                <td class=\"total\">".number_format($_SESSION['total_price'],2)."</td>
                <td></td>
            </tr>";
    echo "</tbody></table>";

}
//显示购物车的两个按钮
function display_cart_btns($new){
    $target = (isset($_SESSION['user']))?"index.php#second":"welcome.php#second";
    if($new){
        $details = get_product_detail($new);
        if($details['catid']){
            $target = "show_category.php?catid=".$details['catid'];
        }
    }
    if(isset($_SESSION['user'])){
        $check = "<a href=\"checkout.php\" id=\"checkout\" class=\"btn btn-danger\" role=\"button\">Check Out</a>";
    }else{
        $check = "<a href=\"#Register\" data-toggle=\"modal\" data-target=\"#login\" id=\"checkout\" class=\"btn btn-danger\" role=\"button\">Check Out</a>";
    }
    echo "<p style=\"text-align: center\">".
        $check.
        "&nbsp <a href=\"$target\" class=\"btn btn-default\" role=\"button\">Continue Shopping</a>
          </p>";
}
//显示购物车警告框
function display_cart_warning(){
    if(isset($_SESSION['user'])){
        $target = "index.php#second";
    }else{
        $target = "welcome.php#second";
    }
    echo "<div class=\"container\">
            <div class=\"alert alert-warning\" role=\"alert\">There are no items in your cart</div>
            <a href=\"$target\" class=\"btn btn-default\" role=\"button\">Go to Home</a>
         </div>";
}

//显示Checkout
function display_checkout_form() {
    ?>
    <div class="panel panel-default">
        <div class="panel-heading"><h4>Shipping Info</h4></div>
        <div class="panel-body">
            <form action="purchase.php" method="post" class="form-horizontal" role="form">
                <!--名-->
                <div class="form-group">
                    <label for="name" class="control-label sr-only">Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="ship_name" id="ship_name" placeholder="Name" minlength="2" maxlength="20" required>
                    </div>
                    <!-- 错误提示信息 -->
                    <h6 style="margin-left:1.5rem;color: #a63807;" id="nok_name"></h6>
                </div>
                <!--地址-->
                <div class="form-group">
                    <label for="address" class="control-label sr-only">Address</label>
                    <div class="col-sm-4">
                        <textarea class="form-control" name="ship_address" id="ship_address" placeholder="Address" required></textarea>
                    </div>
                    <h6 style="margin-left:1.5rem;color: #a63807;" id="nok_address"></h6>
                </div>
                <!--电话-->
                <div class="form-group">
                    <label for="tel" class="control-label sr-only">Telephone</label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" name="ship_tel" id="ship_tel" placeholder="Telephone" minlength="11" required>
                    </div>
                    <h6 style="margin-left:1.5rem;color: #a63807;" id="nok_tel"></h6>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button id="purchase" type="submit" class="btn btn-danger">Purchase</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
}

//显示Purchase警告框或process警告框
function display_purchase_warning($msg,$target="checkout.php"){
    echo "<div class=\"container\">
            <div class=\"alert alert-warning\" role=\"alert\">".$msg."</div>
            <a href=\"".$target."\" class=\"btn btn-default\" role=\"button\">Go Back</a>
         </div>";
}
//显示运费和总价
function display_shipping($shipping) {
    ?>
    <table class="table table-condensed">
        <tr>
            <td></td>
            <td align="left">Shipping</td>
            <td></td><td></td>
            <td style="text-align: center;text-indent: 1em;"><?php echo number_format($shipping, 2); ?></td>
            <td></td>
        </tr>
        <tr class="bg-success">
            <th></th>
            <th align="left">TOTAL INCLUDING SHIPPING</th>
            <th></th><th></th>
            <th style="text-align: center">￥<?php echo number_format($shipping+$_SESSION['total_price'], 2); ?></th>
            <th></th>
        </tr>
    </table><br />
    <?php
}
//显示付款表单
function display_card_form($name){
    ?>
    <div class="panel panel-default">
        <div class="panel-heading"><h4>Credit Card Details</h4></div>
        <div class="panel-body">
            <form action="process.php" method="post" class="form-horizontal" role="form">
                <!--卡的类型-->
                <div class="form-group">
                    <label for="card_type" class="control-label col-sm-1">Type</label>
                    <div class="col-sm-4">
                        <select name="card_type" id="card_type" class="form-control">
                            <option value="Debit Card">Debit Card</option>
                            <option value="Credit Card">Credit Card</option>
                        </select>
                    </div>
                </div>
                <!--卡号-->
                <div class="form-group">
                    <label for="card_number" class="control-label col-sm-1">Card NO.</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="card_number" id="card_number" maxlength="16" required>
                    </div>
                    <h6 style="margin-left:1.5rem;color: #a63807;" id="nok_card_number"></h6>
                </div>
                <!--密码-->
                <div class="form-group">
                    <label for="card_password" class="control-label col-sm-1">Password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" name="card_password" id="card_password" required>
                    </div>
                    <h6 style="margin-left:1.5rem;color: #a63807;" id="nok_card_password"></h6>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-1">
                        <button id="pay" type="submit" class="btn btn-danger">Pay for it</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
}


?>

