<?php

/**

 * Users Model

 */

use \Illuminate\Database\Eloquent\Model as Model;

class UsersModel extends Model
{

    protected $table = 'user';

    //插入数据
    public function insertUsers() {

        $users_id =  UsersModel::firstOrNew(array('id_user' => '8'));
        var_dump( $users_id);
        return false;
    }

}