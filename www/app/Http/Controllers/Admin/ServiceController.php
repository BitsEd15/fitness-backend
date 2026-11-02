<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    public function index(): JsonResponse //тип возворащаемого значения
    {
        $services = Service::with('prices')->orderBy('sort_order')->get();

        return response()->json($services);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'is_active' => ['required', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:15'],
        ]);

        $service = Service::create($data);

        return response()->json($service->load('prices'), 201);
    }

    public function update(Request $request, Service $service): JsonResponse
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],//sometimes значит «проверяй это поле, только если оно пришло в запросе». Вместе с required получается: «поля может не быть вообще, но если оно есть, оно не должно быть пустым».
            'description' => ['sometimes', 'required', 'string'],
            'is_active' => ['sometimes', 'required', 'boolean'],
            'sort_order' => ['sometimes', 'required', 'integer', 'min:0', 'max:255'],
        ]);

        $service->update($data); //присваивает новые значения и сохраняет (UPDATE). В базу уходят только изменённые поля. Если из запроса ничего не изменилось, запрос к базе вообще не отправляется.

        return response()->json($service->load('prices'));
    }

    public function destroy(Service $service): Response
    {
        $service->delete();

        return response()->noContent();
    }
}