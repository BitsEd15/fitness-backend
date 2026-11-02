<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Service;
use App\Models\ServicePrice;

class ServicePriceController extends Controller
{
    public function store(Request $request, Service $service): JsonResponse
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'sessions_count' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'integer', 'min:0'],
        ]);
        $price = $service->prices()->create($data);
        return response()->json($price, 201);
    }

    public function update(Request $request, ServicePrice $price): JsonResponse
    {
        $data = $request->validate([
            'label' => ['sometimes', 'required', 'string', 'max:255'],
            'sessions_count' => ['sometimes', 'required', 'integer', 'min:1'],
            'price' => ['sometimes', 'required', 'integer', 'min:0'],
        ]);
        $price->update($data);
        return response()->json($price); 
    }

    public function destroy(ServicePrice $price)    
    {
        $price->delete();
        return response()->noContent();
    }
}
