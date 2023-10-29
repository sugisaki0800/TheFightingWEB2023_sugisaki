<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;

class CommentsController extends Controller
{
    //
    public function index()
    {
        $commentAll = Comments::all();
        return view('comments')->with('comments', $commentAll);
    }
}
