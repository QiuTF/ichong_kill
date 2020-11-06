<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
{
    /**
     * 获取玩家列表
     */
    public function getPlayers(Request $request)
    {
        $page = (int)$request->query('page', 1);
        $limit = (int)$request->query('limit', 1000);

        $query = Player::query();

        $total = $query->count();

        if (is_null($total)) {
            abort(404);
        }

        $maxPage = ceil($total/$limit);

        if ($page > $maxPage) {
            abort(404);
        }

        $players = $query->forPage($page, $limit)->with('reward')->get();

        if (is_null($players)) {
            abort(404);
        }

        return [
            'data'=>$players,
            'pagination' => [
                'page'=>$page,
                'limit'=>$limit,
                'total_page'=>$maxPage,
                'total'=>$total
            ]
        ];
    }

    /**
     * 新增编辑玩家
     */
    public function postPlayers(Request $request)
    {
        $body = $request->post();

        if (!isset($body['id'])) {
            $player = new Player();
        } else {
            $player = Player::query()->find($body['id']);

            if (is_null($player)) {
                abort(404);
            }
        }

        $player->player = $body['player'];
        $player->is_playing = 0;

        $player->save();

        return [
            'data'=>$player
        ];
    }

    /**
     * 删除玩家
     */
    public function deletePlayers(int $id)
    {
        $player = Player::query()->find($id);

        if (is_null($player)) {
            abort(404);
        }

        $player->delete();

        return [
            'data'=>$player
        ];
    }

    /**
     * 修改玩家
     */
    public function putPlayers(int $id, Request $request)
    {
        $player = Player::query()->find($id);

        $isPlaying = $request->query('is_playing');

        if (is_null($player)) {
            abort(404);
        }

        $player->is_playing = $isPlaying == 0 ? 1 : 0;

        $player->save();

        return [
            'data'=>$player
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

        $maxPage = ceil($total/$limit);

        if ($page > $maxPage) {
            abort(404);
        }

        $players = $query->forPage($page, $limit)->with('reward')->where('is_playing', 1)->get();

        if (is_null($players)) {
            abort(404);
        }

        return [
            'data'=>$players,
            'pagination' => [
                'page'=>$page,
                'limit'=>$limit,
                'total_page'=>$maxPage,
                'total'=>$total
            ]
        ];
    }
}
