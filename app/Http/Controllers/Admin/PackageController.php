<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePackageRequest;
use App\Http\Requests\Admin\UpdatePackageRequest;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        return view('admin.packages.index', [
            'packages' => Package::orderBy('monthly_price')->get(),
        ]);
    }

    public function store(StorePackageRequest $request): RedirectResponse
    {
        Package::create($request->validated());

        return back()->with('status', 'package-created');
    }

    public function update(UpdatePackageRequest $request, Package $package): RedirectResponse
    {
        $data = $request->validated();
        foreach (['has_statistics', 'has_custom_theme', 'remove_branding', 'is_active'] as $flag) {
            $data[$flag] = $request->boolean($flag);
        }

        $package->update($data);

        return back()->with('status', 'package-updated');
    }
}
