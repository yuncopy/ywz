<?php

/**

* Article Model

*/
use \Illuminate\Database\Capsule\Manager as Capsule; // 原始定义
use \Illuminate\Database\Capsule\Manager as BD;  //Laravel   Builder 方式
//https://laravel.com/api/5.1/Illuminate/Database/Eloquent/Builder.html
use \Illuminate\Database\Eloquent\Model as Model;

class ArticleModel extends Model
{

  public $timestamps = false;

  //查询数据
  public  function  selectArticle(){
    $users = Capsule::table('user')->where('id_user', '>', 1)->get();
    var_dump($users);
    echo '<hr/>';
    $sql = Capsule::table('user')->where('id_user', '>', 1)->toSql();

    var_dump($sql);
  }

  //插入数据
  public function insertArticle() {

    $users_id = BD::table('user')->insert(['email' => 'Flight10@qq.com']);
    var_dump($users_id);
    return true;
  }

  //更改数据
  public function updateArticle() {

    $users_id = BD::table('user')->where('id_user', 1)->update(['passwd' => 1242142141241241]);
   var_dump($users_id);
    return true;
  }

  //更改数据
  public function deleteArticle() {

    $users_id = BD::table('user')->where('id_user', '=', 7)->delete();
    var_dump($users_id);
    return true;
  }



}