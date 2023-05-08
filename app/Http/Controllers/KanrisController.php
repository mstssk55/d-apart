<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class KanrisController extends Controller
{
    //

    public function kanri()
    {
        $users = User::where('is_delete',0)->get();

        return view('user.list')->with([
                'users'=>$users
        ]);
        //
    }

    public function userDelete(User $id)
    {

        $user = User::find($id->id);
        $user->is_delete = 1;
        $user->save();

        $users = User::where('is_delete',0)->get();
        return redirect()->route('kanri')->with([
                'users'=>$users
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'newname' => 'required',
            'newemail' => 'required',
            'newpassword' => 'required|min:8|alpha_dash',
        ]);
        if ($validator->fails()) {
            // バリデーションに失敗した場合の処理
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = new User;
        $user->name = $request->newname;
        $user->email = $request->newemail;
        $user->password = bcrypt($request->newpassword);
        $user->save();

        $users = User::where('is_delete',0)->get();
        return redirect()->route('kanri')->with([
                'users'=>$users
        ]);
    }


}
