<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    // ✅ Company dashboard
 public function dashboard()
{
    $user = Auth::user();

    if ($user->role !== 'company') {
        abort(403, 'Unauthorized.');
    }

    $company = Company::where('shalu_user_id', $user->id)->first();

    if (!$company) {
        return redirect()->route('company.profile.create')
            ->with('warning', 'Silakan lengkapi profil perusahaan Anda terlebih dahulu.');
    }

    $activeJobs = $company->jobs()->where('status', 'active')->count();

    $totalApplicants = Application::whereHas('job', function ($query) use ($company) {
        $query->where('shalu_company_id', $company->id);
    })->count();

    $newApplicants = Application::whereHas('job', function ($query) use ($company) {
        $query->where('shalu_company_id', $company->id);
    })->where('status', 'pending')->count();

    $recentApplicants = Application::with('user', 'job')
        ->whereHas('job', function ($query) use ($company) {
            $query->where('shalu_company_id', $company->id);
        })
        ->latest()
        ->take(5)
        ->get();

    $companyJobs = $company->jobs()->latest()->take(5)->get(); // ✅ tambahkan ini

    return view('company.dashboard', compact(
        'company',
        'activeJobs',
        'totalApplicants',
        'newApplicants',
        'recentApplicants',
        'companyJobs' // ✅ kirim ke view
    ));
}


    // ✅ Company membuat profil perusahaan
    public function create()
    {
        // Hanya company yang boleh akses
        if (auth()->user()->role !== 'company') {
            abort(403);
        }

        // Cek apakah sudah punya data perusahaan
        $existing = Company::where('shalu_user_id', auth()->id())->first();
        if ($existing) {
            return redirect()->route('company.dashboard')
                ->with('info', 'Profil perusahaan sudah ada.');
        }

        return view('company.profile.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'industry' => 'nullable|string|max:255',
        'email' => 'required|email|unique:shalu_companies,email',
        'location' => 'required|string|max:255',
        'description' => 'nullable|string',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $logoPath = null;
    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('logos', 'public');
    }

    Company::create([
        'shalu_user_id' => auth()->id(),
        'name' => $request->name,
        'industry' => $request->industry,
        'email' => $request->email,
        'location' => $request->location,
        'description' => $request->description,
        'logo' => $logoPath,
    ]);

    // ✅ Redirect ke dashboard setelah simpan
    return redirect()->route('company.dashboard')->with('success', 'Profil perusahaan berhasil disimpan!');
}


    // ✅ Edit profil company (optional)
    public function editProfile()
    {
        $company = Company::where('shalu_user_id', auth()->id())->firstOrFail();
        return view('company.edit', compact('company'));
    }

    public function updateProfile(Request $request)
    {
        $company = Company::where('shalu_user_id', auth()->id())->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:shalu_companies,email,' . $company->id,
            'location' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'description' => 'required|min:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->has('remove_logo') && $company->logo) {
            \Storage::disk('public')->delete($company->logo);
            $validated['logo'] = null;
        }

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                \Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        $company->update($validated);

        return redirect()->route('company.dashboard')->with('success', 'Profil perusahaan berhasil diperbarui!');
    }
    // Di CompanyController
public function index()
{
    $companies = Company::withCount('jobs')->paginate(10);
    return view('admin.companies.index', compact('companies'));
}
// app/Http/Controllers/CompanyController.php

public function show($id)
{
    $company = Company::with('jobs')->findOrFail($id);

    return view('admin.companies.show', compact('company'));
}


}
