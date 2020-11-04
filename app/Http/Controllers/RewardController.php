<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\RewardUse;
use App\Models\Player;

class RewardController extends Controller
{
    //
    public function getReward(Request $request)
    {
        $page = (int)$request->query('page', 1);
        $limit = (int)$request->query('limit', 1000);

        $query = Reward::query();

        $total = $query->count();

        if (is_null($total)) {
            abort(404);
        }

        $maxPage = ceil($total/$limit);

        if ($page > $maxPage) {
            abort(404);
        }

        $reward = $query->forPage($page, $limit)->with('player')->get();

        if (is_null($reward)) {
            abort(404);
        }

        return [
            'data'=>$reward,
            'pagination' => [
                'page'=>$page,
                'limit'=>$limit,
                'total_page'=>$maxPage,
                'total'=>$total
            ]
        ];
    }

    /**
     * 新增编辑奖励
     */
    public function postReward(Request $request)
    {
        $body = $request->post();

        if (!isset($body['id'])) {
            $reward = new Reward();
        } else {
            $reward = Reward::query()->find($body['id']);

            if (is_null($reward)) {
                abort(404);
            }
        }

        $reward->player_id = $body['player_id'];
        $reward->type = 1;
        $reward->amount = $body['amount'];

        $reward->save();

        return [
            'data'=>$reward
        ];
    }

    public function getRewardUse(Request $request)
    {
        $page = (int)$request->query('page', 1);
        $limit = (int)$request->query('limit', 1000);

        $query = RewardUse::query();

        $total = $query->count();

        if (is_null($total)) {
            abort(404);
        }

        $maxPage = ceil($total/$limit);

        if ($page > $maxPage) {
            abort(404);
        }

        $rewardUse = $query->forPage($page, $limit)->with(['player','role'])->get();

        if (is_null($rewardUse)) {
            abort(404);
        }

        return [
            'data'=>$rewardUse,
            'pagination' => [
                'page'=>$page,
                'limit'=>$limit,
                'total_page'=>$maxPage,
                'total'=>$total
            ]
        ];
    }

    /**
    * 删除身份使用记录
    */
    public function deleteRewardUse(int $id)
    {
        $rewardUse = RewardUse::query()->find($id);

        if (is_null($rewardUse)) {
            abort(404);
        }

        $rewardUse->delete();

        return [
            'data'=>$rewardUse
        ];
    }

    /**
     * 公共方法  获取玩家列表
     */

    public function getPlayerList()
    {
        $list = Player::query()->get(['id','player']);

        return ['data'=>$list];
    }
}
