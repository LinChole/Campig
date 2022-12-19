<?php
setcookie("userName","會員",time() - 60 * 60 *24);
header("location: index.php");

?>