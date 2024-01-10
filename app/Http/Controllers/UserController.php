<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{


    public function about()
    {
        return view('front.about');
    }
    public function blog_single()
    {
        return view('front.blog-single');
    }
    public function blog()
    {
        return view('front.blog');
    }
    public function contact()
    {
        return view('front.contact');
    }
    public function faq()
    {
        return view('front.faq');
    }
    public function gallery()
    {
        return view('front.gallery');
    }
    public function index()
    {
        return view('front.index');
    }
    public function job_listings()
    {
        return view('front.job-listings');
    }
    public function job_single()
    {
        return view('front.job-single');
    }
    public function portfolio_single()
    {
        return view('front.portfolio-single');
    }
    public function portfolio()
    {
        return view('front.portfolio');
    }
    public function post_job()
    {
        return view('front.post-job');
    }
    public function service_sinlge()
    {
        return view('front.service-sinlge');
    }
    public function services()
    {
        return view('front.services');
    }
    public function testimonials()
    {
        return view('front.testimonials');
    }
}
