<?php
function myHand($error){ return "- Это фатальная ошибка, пожалуйста обратитесь к админу сайта";}
ob_start('myHand');

notfoundFunction();

?>