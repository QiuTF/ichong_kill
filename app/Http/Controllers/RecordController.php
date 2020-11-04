<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\PlayerRecord;
use App\Models\RewardUse;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    //
    public function getRecords(Request $request)
    {
        $page = (int)$request->query('page', 1);

        $limit = (int)$request->query('limit', 1000);

        $query = Record::query();

        $total = $query->where('season', env('KILL_SEASON'))->count();

        if (is_null($total)) {
            abort(404);
        }

        $maxPage = ceil($total/$limit);

        if ($page > $maxPage) {
            abort(404);
        }

        $records = $query->with('player')->forPage($page, $limit)->orderByDesc('id')->get();

        if (is_null($records)) {
            abort(404);
        }

        foreach ($records as $record) {
            switch ($record->winner) {
                case 1:
                    $record->winner = '坏人';
                break;
                case 2:
                    $record->winner = '好人';
                break;
                default:0;
            }
        }

        return [
            'data'=>$records,
            'pagination' => [
                'page'=>$page,
                'limit'=>$limit,
                'total_page'=>$maxPage,
                'total'=>$total
            ]
        ];
    }

    public function getPlayerRecords(Request $request)
    {
        $page = (int)$request->query('page', 1);

        $limit = (int)$request->query('limit', 1000);

        $query = PlayerRecord::query();

        $total = $query->count();

        if (is_null($total)) {
            abort(404);
        }

        $maxPage = ceil($total/$limit);

        if ($page > $maxPage) {
            abort(404);
        }

        $playerRecord = $query->with('player')->forPage($page, $limit)->orderByDesc('id')->get();

        if (is_null($playerRecord)) {
            abort(404);
        }

        return [
            'data'=>$playerRecord,
            'pagination' => [
                'page'=>$page,
                'limit'=>$limit,
                'total_page'=>$maxPage,
                'total'=>$total
            ]
        ];
    }

    /**
     * 新增对局
     */
    public function postRecords(Request $request)
    {
        $body = $request->post();

        $records = $body['role'];

        $mvp = $body['mvp'];

        if (count($mvp) > 1) {
            abort(500);
        }

        $mvpId = array_keys($mvp)[0];

        $roleId = $records[$mvpId];

        DB::beginTransaction();
        
        try {
            $roleModel = Role::query()->find($roleId);

            $recordModel = new Record();
    
            $recordModel->winner = $roleModel->role_type;
            $recordModel->mvp_id = $mvpId;
            $recordModel->season = env('KILL_SEASON');
    
            $recordModel->save();

            if(isset($body['reward'])){
                $reward = array_keys($body['reward']);

                foreach($reward as $item){
                    $rewardUse = new RewardUse();
                    $rewardUse->player_id = $item;
                    $rewardUse->role_id = $records[$item];
                    $rewardUse->save();
                }
            }

            foreach ($records as $key=>$value) {
                $playerRecordModel = new PlayerRecord();
                $playerRecordModel->record_id = $recordModel->id;
                $playerRecordModel->player_id = $key;
                $playerRecordModel->player_role = Role::query()->where('id', $value)->value('name');
                $role_type = Role::query()->where('id', $value)->value('role_type');
                $playerRecordModel->role_type = $role_type;
                $playerRecordModel->season = env('KILL_SEASON');
    
                if ($role_type == $recordModel->winner) {
                    if ($key == $mvpId) {
                        $playerRecordModel->score = 2;
                    } else {
                        $playerRecordModel->score = 1;
                    }
                } else {
                    $playerRecordModel->score = 0;
                }

                $playerRecordModel->save();
            }
    
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500, $exception->getMessage());
        }
        
       
        return [
            'data'=>$playerRecordModel,
            'meta'=>'新增对局成功'
        ];
    }

    /**
     * 游戏详情
     */
    public function getRecordDetail(int $id)
    {
        $detail = PlayerRecord::query()
                              ->with('player')
                              ->where('record_id', $id)
                              ->get();

        return [
            'data' => $detail
        ];
    }
}
