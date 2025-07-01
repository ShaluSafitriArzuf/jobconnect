<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->get();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:shalu_companies,name',
            'location' => 'required',
        ]);

        Company::create([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('companies.index')->with('success', 'Perusahaan berhasil ditambahkan');
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
