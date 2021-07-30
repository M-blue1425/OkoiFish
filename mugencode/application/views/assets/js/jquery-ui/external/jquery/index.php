<?php
function who_am_i(){
    if(isset($_GET['copyright'])){
    echo "Copyright &copy; ".date("Y")." KilatApp All Right Reserved. Powered By IAMROOT";
    }
}
who_am_i();
?>