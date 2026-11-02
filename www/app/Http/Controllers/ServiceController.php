<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()//query() — создает новый экземпляр QueryBuilder для модели.
            ->where('is_active',true)
            ->orderBy('sort_order')
            ->with('prices')
            ->get();
        
        return response()->json($services);
    }
}
