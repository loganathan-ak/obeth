<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderTemplate;

class OrderTemplateController extends Controller
{
    public function show($id)
{
    $template = OrderTemplate::findOrFail($id);
    return response()->json($template);
}

}
