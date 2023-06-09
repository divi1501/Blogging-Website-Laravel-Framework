<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function createFollow(User $user){
        //you cannot follow yourself
        if($user->id==auth()->user()->id){
            return back()->with('failure', 'you cannot follow yourself');
        }

        $existCheck=Follow::where([['user_id','=',auth()->user()->id],['followeduser', '=', $user->id]])->count();
         //you cannot follow someone you are already following
        if($existCheck){
            return back()->with('failure', 'you are already following that user');
        }


        $newFollow=new Follow;
        $newFollow->user_id=auth()->user()->id;
        $newFollow->followeduser=$user->id;
        $newFollow->save();

        return back()->with('success', 'User successfully followed');

         
    }

    public function removeFollow(User $user){
        Follow::where([['user_id','=', auth()->user()->id],['followeduser','=', $user->id]])->delete();

        return back()->with('success', 'Unfollowed user successfully');

    }
}
