<?php

namespace App\Http\Controllers;
use App\Models\Plans;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plans::where('is_active', true)->orderBy('price')->get();
        return view('plans', compact('plans'));
    }
}
