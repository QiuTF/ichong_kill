<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * 获取角色列表
     */
    public function getRoles(Request $request)
    {
        $page = (int)$request->query('page', 1);
        $limit = (int)$request->query('limit', 1000);

        $query = Role::query();

        $total = $query->count();

        if (is_null($total)) {
            abort(404);
        }

        $maxPage = ceil($total/$limit);

        if ($page > $maxPage) {
            abort(404);
        }

        $roles = $query->forPage($page, $limit)->get();

        if (is_null($roles)) {
            abort(404);
        }

        foreach($roles as $role){
            switch($role->role_type){
                case 1:
                    $role->role_type = '坏人';
                break;
                case 2:
                    $role->role_type = '好人';
                break;
                default:0;
            }
        }

        return [
            'data'=>$roles,
            'pagination' => [
                'page'=>$page,
                'limit'=>$limit,
                'total_page'=>$maxPage,
                'total'=>$total
            ]
        ];
    }

    /**
     * 新增编辑角色
     */
    public function postRoles(Request $request)
    {
        $body = $request->post();

        if (!isset($body['id'])) {
            $role = new Role();
        } else {
            $role = Role::query()->find($body['id']);

            if (is_null($role)) {
                abort(404);
            }
        }

        $role->name = $body['role'];
        $role->role_type = $body['role_type'];

        $role->save();

        return [
            'data'=>$role
        ];
    }

    /**
     * 删除角色
     */
    public function deleteRoles(int $id)
    {
        $role = Role::query()->find($id);

        if (is_null($role)) {
            abort(404);
        }

        $role->delete();

        return [
            'data'=>$role
        ];
    }

}
