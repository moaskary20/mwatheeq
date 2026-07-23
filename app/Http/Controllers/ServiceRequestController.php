<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceRequestController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'service_id' => [
                'required',
                'integer',
                Rule::exists('services', 'id')->where(fn ($query) => $query->where('is_published', true)),
            ],
        ], [
            'name.required' => __('site.service_request.errors.name'),
            'phone.required' => __('site.service_request.errors.phone'),
            'email.required' => __('site.service_request.errors.email'),
            'email.email' => __('site.service_request.errors.email_invalid'),
            'service_id.required' => __('site.service_request.errors.service'),
            'service_id.exists' => __('site.service_request.errors.service'),
        ]);

        $service = Service::query()->published()->findOrFail($validated['service_id']);

        ServiceRequest::query()->create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'service_id' => $service->id,
            'service_title' => $service->title,
            'is_read' => false,
        ]);

        return response()->json([
            'message' => __('site.service_request.success'),
        ]);
    }
}
