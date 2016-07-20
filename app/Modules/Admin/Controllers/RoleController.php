<?php
namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Modules\Admin\Controllers\Controller as BaseController;

/**
 * 角色 管理
 * Class RoleController
 * @package App\Modules\Admin\Controllers
 *
 * @author davin.bao
 * @since 2016/7/20 9:34
 */
class RoleController extends BaseController {
    /**
     * 定义 permission list
     * @return array
     */
    public static function actionName()
    {
        return [
            'getIndex'=> json_encode(['parent'=>0, 'icon'=>'home', 'display_name'=>'角色管理', 'is_menu'=>1, 'sort'=>0, 'allow'=>1, 'description'=>'']),
            'getList'=> json_encode(['parent'=>'RoleController@getIndex', 'icon'=>'', 'display_name'=>'角色列表', 'is_menu'=>0, 'sort'=>0, 'allow'=>1, 'description'=>'']),
            'postAdd'=> json_encode(['parent'=>'RoleController@getIndex', 'icon'=>'', 'display_name'=>'添加角色', 'is_menu'=>0, 'sort'=>0, 'allow'=>1, 'description'=>'']),
            'postEdit'=> json_encode(['parent'=>'RoleController@getIndex', 'icon'=>'', 'display_name'=>'修改角色', 'is_menu'=>0, 'sort'=>0, 'allow'=>1, 'description'=>'']),
            'postDelete'=> json_encode(['parent'=>'RoleController@getIndex', 'icon'=>'', 'display_name'=>'删除角色', 'is_menu'=>0, 'sort'=>0, 'allow'=>1, 'description'=>'']),
        ];
    }

    public function getIndex(){
        return $this->render('role.index');
    }

    public function getList(Request $request){
        $matchCon = $request->input('matchCon', null);

        $query = $this->getService()->roleList($matchCon);
        $queryData = $this->queryData($request, $query);

        return $this->response($request, $queryData, 'admin/role/index');
    }

    public function getAdd(){
        return $this->render('role.add');
    }

    public function getEdit($id){}

    public function postAdd(Request $request){

        $this->validateRequest([
            'name' => 'required|alpha_num|min:6|max:30|unique:roles',
            'display_name' => 'required|min:6',
        ], $request);

        $this->getService()->createRole($request);

        return $this->response($request, [], 'admin/role/index');
    }

    public function postEdit(Request $request){

        $this->validateRequest([
            'name' => 'required|alpha_num|min:6|max:30|unique:roles,name,' . $request->input('id', 0),
            'display_name' => 'required|min:6',
        ], $request);

        $this->getService()->saveRole($request->all());

        return $this->response($request, [], 'admin/role/index');
    }

    public function postDelete(Request $request){
        $this->validateRequest([
            'id' => 'required|min:0',
        ], $request);

        $id = $request->input('id', 0);

        $this->getService()->deleteRole($id);

        return $this->response($request, [], 'admin/role/index');
    }
}