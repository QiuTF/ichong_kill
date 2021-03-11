<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
{

    /**
     * 获取玩家列表
     */
    public function list(Request $request)
    {
        $page = (int)$request->query('page', 1);
        $limit = (int)$request->query('limit', 1000);

        $query = Player::query();

        $total = $query->count();

        if (is_null($total)) {
            abort(404);
        }

        $maxPage = ceil($total / $limit);

        if ($page > $maxPage) {
            abort(404);
        }

        $players = $query->forPage($page, $limit)
                         ->with('reward')
                         ->get();

        if (is_null($players)) {
            abort(404);
        }

        return [
            'data' => $players,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total_page' => $maxPage,
                'total' => $total,
            ],
        ];
    }

    /**
     * 删除玩家
     */
    public function delete(int $id)
    {
        $player = Player::query()
                        ->find($id);

        if (is_null($player)) {
            abort(404);
        }

        $player->delete();

        return [
            'data' => $player,
        ];
    }

    /**
     * 修改玩家状态
     */
    public function update(int $id, Request $request)
    {
        $player = Player::query()
                        ->find($id);

        $isPlaying = $request->query('is_playing');

        if (is_null($player)) {
            abort(404);
        }

        $player->is_playing = $isPlaying == 0 ? 1 : 0;

        $player->save();

        return [
            'data' => $player,
        ];
    }

    /**
     * 获取游戏中玩家列表
     */
    public function getPlayingPlayers(Request $request)
    {
        $page = (int)$request->query('page', 1);
        $limit = (int)$request->query('limit', 1000);

        $query = Player::query();

        $total = $query->count();

        if (is_null($total)) {
            abort(404);
        }

        $maxPage = ceil($total / $limit);

        if ($page > $maxPage) {
            abort(404);
        }

        $players = $query->forPage($page, $limit)
                         ->with('reward')
                         ->where('is_playing', 1)
                         ->get();

        if (is_null($players)) {
            abort(404);
        }

        return [
            'data' => $players,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total_page' => $maxPage,
                'total' => $total,
            ],
        ];
    }
}
