<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feedback;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbacksController extends Controller
{
    public function index()
    {   
        $feedbacks = Feedback::all();

        return view('admin.feedbacks.index',compact('feedbacks'));
    }

    public function show(Feedback $feedback)
    {
        return view('admin.feedbacks.show',[
            'feedback' => $feedback            
        ]);
    }
}