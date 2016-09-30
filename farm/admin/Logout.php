<?php
session_start();
//删除session中的user，返回welcome页面
unset($_SESSION['user']);
echo "<script>alert('Logout!');location.href = '../welcome.php'</script>";