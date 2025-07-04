<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use App\Models\Company;


class JobController extends Controller
{
  public function index()
{
    $categories = Category::all(); // Ambil semua kategori
    $jobs = Job::with('company', 'category')->latest()->paginate(10);
    
    return view('jobs.index', compact('jobs', 'categories'));
}

    public function show($id)
    {
        $job = Job::with('company', 'category')->findOrFail($id);
        return view('jobs.show', compact('job'));
    }

    public function create()
{
    $categories = Category::all(); // Jika butuh data kategori
    return view('jobs.create', compact('categories'));
}

public function store(Request $request)
{
    // Validasi dan simpan data
    $validated = $request->validate([
        'title' => 'required',
        'description' => 'required',
        // tambahkan validasi lainnya
    ]);
    
    Job::create($validated);
    
    return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil dibuat');
}

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $categories = Category::all();

        return view('jobs.edit', compact('job', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $job->update($request->only(['title', 'description', 'location', 'job_type', 'deadline', 'category_id']));

        return redirect()->route('jobs.index')->with('success', 'Job berhasil diperbarui');
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Job berhasil dihapus');
    }

}
