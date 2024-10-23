<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    function contact()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $user = Auth::user();
        $orderCount = $user->bill()->count();
        return view('client.home.contact', compact('orderCount', 'categories'));
    }
}
