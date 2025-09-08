<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    public function index()
    {
        $pages = LandingPage::latest()->paginate(10);
        return view('admin.landing-pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.landing-pages.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title'              => 'required|string|max:255',
            'member_price'       => 'required|numeric',
            'non_member_price'   => 'required|numeric',
            'extra_member_price' => 'required|numeric|min:0',
            'gst_percent'        => 'required|numeric|min:0',
            'pdf_path'           => 'nullable|file|mimes:pdf|max:20480',
            'workshop_mode'      => 'nullable|boolean',
            'slug'               => 'required|unique:landing_pages,slug',
            'can_have_extra_members' => 'nullable|boolean',
        ]);

        $data                  = $request->all();
        $data['workshop_mode'] = $request->has('workshop_mode'); // ensures true/false
        $data['can_have_extra_members'] = $request->has('can_have_extra_members');

        $data['slug'] = Str::slug($data['slug']);

        if ($request->hasFile('pdf_path')) {
            $data['pdf_path'] = $request->file('pdf_path')->store('pdfs', 'public');
        }

        if ($request->hasFile('banner_path')) {
            $data['banner_path'] = $request->file('banner_path')->store('banners', 'public');
        }

        // After creating/updating landing page
        $landingPage = LandingPage::create($data);

        if ($request->has('discount_rules')) {
            $landingPage->discountRules()->delete(); // remove old rules
            foreach ($request->discount_rules['threshold'] as $i => $threshold) {
                $value = $request->discount_rules['value'][$i];
                $landingPage->discountRules()->create([
                    'type'      => 'extra_members',
                    'threshold' => $threshold,
                    'value'     => $value,
                    'active'    => true,
                ]);
            }
        }

        return redirect()->route('landing-pages.index')->with('success', 'Landing Page created successfully.');
    }

    public function edit(LandingPage $landingPage)
    {
        return view('admin.landing-pages.edit', compact('landingPage'));
    }

    public function update(Request $request, LandingPage $landingPage)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'member_price'       => 'required|numeric',
            'non_member_price'   => 'required|numeric',
            'extra_member_price' => 'required|numeric|min:0',
            'gst_percent'        => 'required|numeric|min:0',
            'pdf_path'           => 'nullable|file|mimes:pdf|max:20480',
            'workshop_mode'      => 'boolean',
            'can_have_extra_members' => 'nullable|boolean',
        ]);

        $data                  = $request->all();
        $data['workshop_mode'] = $request->has('workshop_mode'); // ensures true/false
        $data['can_have_extra_members'] = $request->has('can_have_extra_members');

        if ($request->hasFile('pdf_path')) {
            $data['pdf_path'] = $request->file('pdf_path')->store('pdfs', 'public');
        }

        if ($request->hasFile('banner_path')) {
            $data['banner_path'] = $request->file('banner_path')->store('banners', 'public');
        }

        $landingPage->update($data);

// Save discount rules
        if ($request->has('discount_rules')) {
            $landingPage->discountRules()->delete(); // remove old rules
            foreach ($request->discount_rules['threshold'] as $i => $threshold) {
                $value = $request->discount_rules['value'][$i];
                $landingPage->discountRules()->create([
                    'type'      => 'extra_members',
                    'threshold' => $threshold,
                    'value'     => $value,
                    'active'    => true,
                ]);
            }
        }

        return redirect()->route('landing-pages.index')->with('success', 'Landing Page updated successfully.');
    }

    public function destroy(LandingPage $landingPage)
    {
        $landingPage->delete();
        return redirect()->route('landing-pages.index')->with('success', 'Landing Page deleted successfully.');
    }

    public function registrations($id)
    {
        $page = LandingPage::with('registrations.extraMembers')->findOrFail($id);
        return view('admin.landing-pages.registrations', compact('page'));
    }

    public function export($id)
    {
        // TODO: implement Excel/CSV export with maatwebsite/excel
    }
}
