<?php
namespace libs;
    //session_start();
class CheckLogin
{
    public function show(){
        if (!isset($_SESSION['username'])) {
        //header('Location:?a=login');
        echo "您还没有登录，<a href='?a=login'>请先登录!</a>";
        return false;
          }
    }
    
}
     
?>