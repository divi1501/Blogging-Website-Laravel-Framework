<?php

namespace App\Http\Controllers;

use App\Models\Newpost;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function search($term){
        $posts= Newpost::search($term)->get();
        $posts->load('user:id, username, avatar');
        return $posts;
    }

    public function actuallyUpdate(Newpost $post, Request $request){
        $incomingFields=$request->validate([
            'title'=>'required',
            'body'=>'required',
        ]);
        $incomingFields['title']=strip_tags($incomingFields['title']);
        $incomingFields['body']=strip_tags($incomingFields['body']);
        $post->update($incomingFields);

        return back()->with('success', 'Post updated successfully');
    }

    public function showEditForm(Newpost $post){
        return view('edit-post', ['post'=>$post]);
    }


    public function delete(Newpost $post){
        // if(auth()->user()->cannot('delete', $post)){
        //     return 'You cannot delete post';
        // }

        $post->delete();
        return redirect('/profile/'.auth()->user()->username)->with('success', 'Post successfully deleted');
    }


    public function viewSinglePost(Newpost $post){
        
        return view('single-post', ['post'=>$post]);

    }

    public function storeNewPost(Request $request){
        $incomingFields= $request->validate([
            'title'=>'required',
            'body'=>'required'
        ]);

        $incomingFields['title']=strip_tags($incomingFields['title']);
        $incomingFields['body']=strip_tags($incomingFields['body']);
        $incomingFields['user_id']=auth()->id();

        $newPost=Newpost::create($incomingFields);
        return redirect("/post/{$newPost->id}")->with('success', 'Created a post successfully');
    }


    public function showCreateForm(){
        if(!auth()->check()){
            return redirect('/');
        }

        return view('create-post');
    }


}
