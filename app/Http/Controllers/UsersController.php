<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;
use App\Models\PlayerRecord;
use Auth;

class UsersController extends Controller
{

    //
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show(Player $user)
    {
        $rank = PlayerRecord::query()
                            ->with('player')
                            ->where('player_id', $user->id)
                            ->where('season', env('KILL_SEASON'))
                            ->orderBy('record_id', 'desc');

        return view('users.show', compact('user', 'rank'));
    }

    public function edit(Player $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, Player $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);

        return redirect()
            ->route('users.show', $user->id)
            ->with('success', '个人资料更新成功！');
    }
}
