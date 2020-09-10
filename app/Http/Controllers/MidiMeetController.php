<?php

namespace App\Http\Controllers;

use App\User;
use App\UserRoom;
use Faker\Provider\Miscellaneous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MidiMeetController extends Controller
{
    public function join(Request $request) {
      if(!empty($request->input('room'))) {
        $room = $request->input('room');
      } else {
        $room = Str::random(6);
      }

      if(Auth::guest()) {
        $u = User::create([
            'name' => 'Anonymous'.rand(100, 999).' '.Miscellaneous::emoji()
        ]);

        Auth::loginUsingId($u->id, true);
      } else {
        $u = Auth::user();
      }

      if(!in_array($room, $u->rooms())) {
        UserRoom::create([
            'user_id' => $u->id,
            'room' => $room
        ]);
      }

      return ['user' => $u, 'room' => $room];
    }

    public function init() {
      if(!Auth::guest()) {
        $data['user'] = Auth::user();
        $data['rooms'] = UserRoom::where('user_id', $data['user']->id)->get();
        $data['exist'] = true;

        return $data;
      }
    }

    public function changeNickname(Request $request) {
      Auth::user()->update(['name' => $request->input('name')]);
    }
}
