<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// 用户登录
Route::post('/users', 'UserController@login');

// 登录后可以访问的接口
Route::middleware('auth:api')->group(function () {
    // 玩家
    Route::get('/players', 'PlayerController@getPlayers');
    Route::post('/players', 'PlayerController@postPlayers');
    Route::delete('/players/{id}', 'PlayerController@deletePlayers')->where('id', '\d+');
    Route::put('/players/{id}', 'PlayerController@putPlayers')->where('id', '\d+');
    Route::get('/playing/players', 'PlayerController@getPlayingPlayers');

    // 角色
    Route::get('/roles', 'RoleController@getRoles');
    Route::post('/roles', 'RoleController@postRoles');
    Route::delete('/roles/{id}', 'RoleController@deleteRoles')->where('id', '\d+');

    // 游戏记录
    Route::get('/records', 'RecordController@getRecords');
    Route::post('/records', 'RecordController@postRecords');
    Route::get('/player/records', 'RecordController@getPlayerRecords');
    Route::get('/records/detail/{id}', 'RecordController@getRecordDetail')->where('id', '\d+');

    // 玩家积分
    Route::get('/rank', 'RankController@getRank');
    Route::get('/rank/detail/{id}', 'RankController@getRankDetail')->where('id', '\d+');

    // 赛季奖励
    Route::get('/reward', 'RewardController@getReward');
    Route::post('/reward', 'RewardController@postReward');
    Route::get('/reward/use', 'RewardController@getRewardUse');
    Route::delete('/reward/use/{id}', 'RewardController@deleteRewardUse')->where('id', '\d+');
    Route::get('/player/select', 'RewardController@getPlayerList');
});
