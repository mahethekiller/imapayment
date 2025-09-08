<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountRule;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = DiscountRule::latest()->paginate(20);
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
    'landing_page_id' => 'required|exists:landing_pages,id',
    'type' => 'required|in:flat,extra_members',
    'value' => 'required|numeric',
    'min_members' => 'nullable|integer',
]);

        DiscountRule::create($request->all());
        return redirect()->route('discounts.index')->with('success','Discount created');
    }

    public function edit(DiscountRule $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(Request $request, DiscountRule $discount)
    {
        $request->validate([
    'landing_page_id' => 'required|exists:landing_pages,id',
    'type' => 'required|in:flat,extra_members',
    'value' => 'required|numeric',
    'min_members' => 'nullable|integer',
]);

        $discount->update($request->all());
        return redirect()->route('discounts.index')->with('success','Discount updated');
    }

    public function destroy(DiscountRule $discount)
    {
        $discount->delete();
        return redirect()->route('discounts.index')->with('success','Discount deleted');
    }
}
