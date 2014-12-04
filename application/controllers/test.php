<?php
/**
 * Created by N0B0DY.
 * User: me@suvo.me
 * Date: 5/11/14
 * Time: 7:37 PM
 */
class Test extends CI_Controller{
    public  function index(){

        $x = file_get_contents("https://graph.facebook.com/1512194860/picture?width=140&height=140");

        var_dump($x);

        $this->load->view('test');


    }
}