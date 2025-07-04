<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::withCount('jobs')
            ->orderBy('name')
            ->paginate(10);

        // Atau jika perlu kondisi khusus:
        $companies = Company::withCount([
            'jobs as jobs_count' => function ($query) {
                $query->where('job_type', 'Full-Time'); // Contoh filter
            }
        ])->paginate(10);

        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create'); // Sesuaikan dengan lokasi view Anda
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies',
            // tambahkan field lainnya
        ]);

        // Simpan data
        Company::create($validated);

        return redirect()->route('admin.companies.index')
            ->with('success', 'Perusahaan berhasil dibuat!');
    }
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:shalu_companies,name,' . $id,
            'location' => 'required',
        ]);

        $company = Company::findOrFail($id);
        $company->update([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('companies.index')->with('success', 'Perusahaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Perusahaan berhasil dihapus');
    }

}
