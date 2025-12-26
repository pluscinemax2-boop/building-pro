<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LegalPolicy;
use App\Models\LegalCompliance;

class LegalPolicyController extends Controller
{
    public function index()
    {
        $policies = LegalPolicy::all()->keyBy('type');
        $compliance = LegalCompliance::first();
        return view('admin.legal-policy', [
            'policies' => $policies,
            'compliance' => $compliance,
        ]);
    }

    public function savePolicy(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:terms,privacy,refund',
            'title' => 'required|string',
            'content' => 'nullable|string',
        ]);
        $policy = LegalPolicy::updateOrCreate(
            ['type' => $data['type']],
            [
                'title' => $data['title'],
                'content' => $data['content'],
                'status' => $data['content'] ? 'active' : 'draft',
            ]
        );
        return back()->with('success', $policy->title.' updated!');
    }

    public function saveCompliance(Request $request)
    {
        $data = $request->validate([
            'gdpr_enabled' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);
        $compliance = LegalCompliance::first();
        if (!$compliance) {
            $compliance = new LegalCompliance();
        }
        $compliance->gdpr_enabled = $request->has('gdpr_enabled');
        $compliance->notes = $data['notes'] ?? '';
        $compliance->save();
        return back()->with('success', 'Compliance updated!');
    }

    public function preview()
    {
        $policies = LegalPolicy::all()->keyBy('type');
        return view('admin.legal-policy-preview', [
            'terms' => $policies['terms']->content ?? '',
            'privacy' => $policies['privacy']->content ?? '',
            'refund' => $policies['refund']->content ?? '',
        ]);
    }
}
