<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPlan;
use Illuminate\Http\Request;

class LandingPlanController extends Controller
{
    public function index()
    {
        $plans = LandingPlan::ordered()->get();
        return view('admin.manage-content.landing-plans.index', compact('plans'));
    }

    public function save(Request $request)
    {
        $input = $request->validate([
            'id' => 'nullable|integer|exists:landing_plans,id',
            'name' => 'required|string|max:120',
            'return_rate' => 'required|string|max:60',
            'return_duration' => 'required|string|max:120',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'badge_text' => 'nullable|string|max:120',
            'features' => 'nullable|string',
            'cta_text' => 'nullable|string|max:80',
            'cta_url' => 'nullable|string|max:190',
            'sort_order' => 'nullable|integer|min:0|max:999999',
        ]);

        $features = preg_split('/\r\n|\r|\n/', (string) data_get($input, 'features', ''));
        $features = array_values(array_filter(array_map('trim', $features), function ($item) {
            return $item !== '';
        }));

        $payload = [
            'name' => data_get($input, 'name'),
            'return_rate' => data_get($input, 'return_rate'),
            'return_duration' => data_get($input, 'return_duration'),
            'min_amount' => (float) data_get($input, 'min_amount'),
            'max_amount' => data_get($input, 'max_amount') === null || data_get($input, 'max_amount') === '' ? null : (float) data_get($input, 'max_amount'),
            'badge_text' => data_get($input, 'badge_text', '24/7 support') ?: '24/7 support',
            'features' => $features,
            'cta_text' => data_get($input, 'cta_text', 'Purchase Plan') ?: 'Purchase Plan',
            'cta_url' => data_get($input, 'cta_url', '/app/register') ?: '/app/register',
            'sort_order' => (int) data_get($input, 'sort_order', 0),
            'is_recommended' => $request->boolean('is_recommended'),
            'is_active' => $request->boolean('is_active', true),
        ];

        if (!empty($input['id'])) {
            $plan = LandingPlan::findOrFail($input['id']);
            $plan->update($payload);
            return back()->withErrors(['success' => __('Landing plan updated successfully.')]);
        }

        LandingPlan::create($payload);
        return back()->withErrors(['success' => __('Landing plan created successfully.')]);
    }

    public function delete($id)
    {
        $plan = LandingPlan::findOrFail((int) $id);
        $plan->delete();

        return back()->withErrors(['success' => __('Landing plan removed successfully.')]);
    }
}

