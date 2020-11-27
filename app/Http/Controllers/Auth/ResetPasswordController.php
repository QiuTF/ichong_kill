<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Player;

class ResetPasswordController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'player' => ['required', 'string', 'max:255', 'exists:App\Models\Player,player'],
            'password' => ['required', 'string', 'confirmed'],
        ],['player.exists'=>'该用户不存在']);
    }

    public function reset(Request $request)
    {
        $this->validator($request->all())->validate();

        $body = $request->post();

        $player = Player::query()->where('player',$body['player'])->firstOrFail();

        $player->password = Hash::make($body['password']);

        $player->save();

        return redirect()->route('login')->with('success', '重置密码成功！现在你可以登录了');
    }
}
