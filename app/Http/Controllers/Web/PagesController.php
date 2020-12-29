<?php

namespace App\Http\Controllers\Web;

use App\Models\Feedback;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function aboutUs()
    {
        return view('web/about-us');
    }

    public function faqs()
    {
        return view('web/faqs');
    }

    public function sendFeedback()
    {
        $validatedData = request()->validate([
            'name' => ['required'],
            'email' => ['required','email'],
            'message' => ['required'],
        ]);
        
        Feedback::create($validatedData);
        
        return redirect()->back()->with('success','Your message has been sent successfully.');
    }

}