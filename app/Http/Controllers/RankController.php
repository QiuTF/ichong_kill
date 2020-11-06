<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayerRecord;

class RankController extends Controller
{
    //获取玩家得分排行
    public function getRank()
    {
        $field = 'player_id,pk_player.player,sum(score) as score,';
        $field .= 'count(case when score <> 0 then 0 end) wins,'; // 胜场
        $field .= 'count(case when score = 0 then 0 end) fail,'; //负场
        $field .= 'count(case when score = 2 then 0 end) mvp,'; //mvp次数
        $field .= 'round(count(case when score <> 0 then 0 end) * 100/count(*),2) as rate'; // 胜率

        $order = 'sum(score) desc,'; // 得分
        $order .= 'round(count(case when score <> 0 then 0 end)/count(*),2) desc,'; // 胜率
        $order .= 'count(case when score = 2 then 0 end) desc'; // mvp次数

        $rank = PlayerRecord::query()
                            ->leftJoin('player', 'record_player.player_id', '=', 'player.id')
                            ->selectRaw($field)
                            ->where('season',env('KILL_SEASON'))
                            ->groupBy('player_id')
                            ->orderByRaw($order)
                            ->get();

        return [
            'data' => $rank
        ];
    }

    /**
     * 玩家游戏记录
     */
    public function getRankDetail(int $id)
    {
        $detail = PlayerRecord::query()
                              ->with('player')
                              ->where('player_id', $id)
                              ->where('season',env('KILL_SEASON'))
                              ->orderBy('record_id', 'desc')
                              ->get();

        return [
            'data' => $detail
        ];
    }
}
