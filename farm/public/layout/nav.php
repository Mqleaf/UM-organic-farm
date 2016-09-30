<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">UM<span class="glyphicon glyphicon-grain"></span></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul id="mytab" class="nav navbar-nav navbar-right">
                <?php
                if (!isset($_SESSION['user'])) {
                    ?>
                    <li class="<?php echo $_SERVER['PHP_SELF']=='/farm/welcome.php'?'active':'';?>"><a href="welcome.php<?php echo $_SERVER['PHP_SELF']=='/farm/welcome.php'?'':'#second';?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                    <li><a href="#Register" data-toggle="modal" data-target="#register">Register</a></li>
                    <li><a href="#Register" data-toggle="modal" data-target="#login">Login</a></li>
                    <li class="<?php echo $_SERVER['PHP_SELF']=='/farm/cart.php'?'active':'';?>"><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
                    <?php
                }else{
                    ?>
                    <li class="<?php echo $_SERVER['PHP_SELF']=='/farm/index.php'?'active':'';?>"><a href="index.php<?php echo $_SERVER['PHP_SELF']=='/farm/index.php'?'':'#second';?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenu1">
                            <span class="glyphicon glyphicon-user"></span>
                            <?php echo $_SESSION['user']; ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="admin/Logout.php" >Logout</a></li>
                        </ul>
                    </li>
                    <li class="<?php echo $_SERVER['PHP_SELF']=='/farm/cart.php'?'active':'';?>"><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
                    <?php
                }
                ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>