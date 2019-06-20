<?php
/**
 * Created by PhpStorm.
 * User: Jincool
 * Date: 2019/3/12
 * Time: 9:37
 */

class IndexController extends BaseController
{

    public function indexAction(){
       echo IndexModel::welcome();
    }

}