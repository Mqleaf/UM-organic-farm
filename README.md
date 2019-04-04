# UM-organic-farm



【项目介绍】

基于BootStrap/ jQuery/PHP/MySQL搭建的Web全站，实现注册、登录、商品列表、购物车和订单多种功能。

链接：http://1.muliping.applinzi.com/farm/ 

效果图：
<img src="https://github.com/Mqleaf/UM-organic-farm/blob/master/farm_display/farm.png">


【文件结构】

Farm

	|__welcome.php(未登录主页)

	|__ index.php（已登录主页）

	|__ show_category.php(商品列表页面)

	|__ show_product.php(商品详情页面)

	|__ cart.php（购物车页面）
	
	|__checkout.php(总计页面，含送货表单)

	|__purchase.php(付款页面，含付款表单)

	|__process.php(付款后处理结果页面)


	|__ Admin(功能管理)

		|__ Register.php（注册类,处理注册表单）
	
		|__ Login.php（登录类，处理登录表单）
	
		|__ Logout.php（退出，返回welcome.php）
	
		|__ Captcha.php（验证码类，生成验证码）
	
		|__config.php（数据库配置:主机，数据库名，用户名，密码）
	
		|__font
	
			|__consola.ttf（验证码使用的字体）
		
		|__cart（购物车、商品、订单）
	
			|__product_sc_fns.php(导入所有函数文件)
		
			|__db_fns.php(连接数据库的函数)
	
			|__output_fns.php(输出HTML的函数)
	
			|__product_fns.php(保存和获取商品数据的函数)
	
			|__order_fns.php(保存和获取订单数据的函数)
	
			|__validate_fns.php(验证送货表单和付款表单的函数)
	
			|__web.sql（数据库文件）

	|__ Public

		|__css
	
		|__ fonts
	
		|__ img
	
		|__js
	
		|__layout（页面基本布局）
	
		|__form（注册登录表单）
	
		|__header（各页面header）
	
		|__header（主页内容）
	
		|__nav（各页面导航栏）
	
	
【功能模块】
<img src="https://github.com/Mqleaf/UM-organic-farm/blob/master/farm_display/farm_3.png">

1.数据库

--user表格：id（主键）,username,email,password,用于存储用户信息。

--categories表格：catid(主键)，catname，用于存储商品类型。

--product表格：productid（主键）,title,catid,price,description,用于存储商品信息。

--ordrs表格：orderid（主键）,id(与user联系的外键)，amount，date, ship_name, ship_address, ship_tel, order_status, 用于存储订单总计和送货信息。

--order_items表格: orderid（主键，外键）, productid（主键，外键），item_price, quantity, 用于存储订单中的每一项。

2.导航栏

--所有页面共用的模块，PHP根据SESSION中有无用户信息生成不同的导航，实现未登录和已登录页面（welcome.php/index.php）。

--BootStrap（$(this).tab('show');）只能控制同一个页面下几个导航的激活样式，点击进入购物车页面时，发现仍然是home默认激活状态。所以，用PHP超全局变量<code>$_SERVER['PHP_SELF']==' /farm/welcome.php'?'active':'' </code>判断当前所在页面，给对应导航项增加默认激活样式。

3.验证码类

	验证码（颜色均随机生成）

	|__图像（宽、高、背景颜色）

	|__字符（字符集string、字符数codeNum、字符code、字体文件路径font、字体大小fontSize、角度、位置、颜色），code需要保存到$_SESSION[‘code’]中。

	|__干扰线（数量、起点位置、终点位置、颜色）

	|__干扰点（数量、位置、颜色）

--显示验证码函数：图->字->线->点，首部字段定义类型为png,输出图片png格式，删除图片。

--开始会话->创建验证码实例->输出验证码

--图像函数参考php文档(http://php.net/manual/zh/function.imagecreate.php)

4.注册表单

--HTML5进行初步验证，jQuery验证信息不为空、长度在范围内、格式正确，提交表单后PHP对所有数据再验证一次。

--注册类：构造函数（建立数据库连接），公用方法（uniqueName，uniqueEmail，checkCode，checkEmailFormat，checkNameFormat，checkPwd，doRegister）。

uniqueName，uniqueEmail，checkCode分ajax和非ajax两种情况，利用‘xmlhttprequest'==strtolower($_SERVER['HTTP_X_REQUESTED_WITH']进行判断。

--创建注册对象，根据$_POST[‘type’]执行对应验证。

--填写表单时，使用Ajax检查用户名、邮箱、验证码：jQuery将注册表单中的用户名、邮箱通过Ajax提交给PHP，PHP从数据库查询数据，判断用户名和邮箱是否已经注册，再返回结果（0：未注册，1：已注册）给jQuery,如果已注册jQuery显示错误信息。检查验证码是查询SESSION中的code，判断是否一致（0：不一致，1：一致）。

--提交表单时，调用doRegister()方法验证所有信息，再将用户信息插入数据库的user中。

5.登录表单

--与注册表单类似，使用Ajax检查邮箱和密码是否对应。

--登录类：构造函数（建立数据库连接），公用方法（checkCode，checkEmailFormat，checkMail，checkPwd，checkUser, doLogin）。

6.退出登录

删除SESSION中的用户名，返回welcome.php

7.商品列表

点击首页中的商品链接，PHP获取链接中的catid。调用get_categoryname($catid) 从数据库的categories中查询商品类型名，调用do_html_heading($heading)打印出来；调用get_products($catid)从数据库的products中查询对应类型的所有商品，将查询结果转为数组，调用display_products($product_array)打印数组的每一项(一项就是一个商品)，生成商品列表。

8.商品详情

点击商品的详情按键，PHP获取链接中的productid。调用get_product_detail ($productid)，从数据库的products中查询具体某个商品，调用display_product_detail($productid)显示该商品详情。

9.购物车

--第一次将商品加入购物车时，PHP会创建购物车，并保存在SESSION中。$_SESSION['cart']是一个关联数组，键是productid，值是quantity。$_SESSION['item'] 用于记录商品总数。$_SESSION[‘total_price’] 用于记录商品总价格。

--在show_product.php页面，每次用户将商品加入购物车，cart.php都会累计数据，再将购物车清单打印出来。

--在cart.php页面，当用户改变商品数量或删除商品时，使用jQuery更新商品总数和价格，并将新的商品数量通过Ajax实时发送给PHP，由PHP更新SESSION中的数据。

10.总计

jQuery验证送货表单，点击purchase按键，PHP再次验证送货信息，验证成功则将送货信息插入数据库的orders表格（注意:需先根据用户名获取用户id），将订单项目插入数据库的order_items表格(注意:需要先根据id从orders表格中得到orderid)。

11.付款

jQuery验证付款表单，点击pay按键，PHP再次验证付款表单，验证成功则将数据库的orders表格中的order_status更新为paid。
