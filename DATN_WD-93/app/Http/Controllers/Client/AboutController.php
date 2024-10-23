<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    function about()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $user = Auth::user();
        $orderCount = $user->bill()->count();
        return view('client.home.about', compact('orderCount', 'categories'));
    }
}
