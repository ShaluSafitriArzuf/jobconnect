<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use Auth;
use Illuminate\Support\Facades\Validator;


class JobController extends Controller
{
    // 👑 Untuk Admin
    public function adminIndex(Request $request)
    {
        $query = Job::with(['company', 'category']);

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('shalu_category_id', $request->category);
        }

        if ($request->job_type) {
            $query->where('job_type', $request->job_type);
        }

        $jobs = $query->latest()->paginate(10);

        $categories = Category::all();

        return view('admin.jobs.index', compact('jobs', 'categories'));
    }


    // 🏢 Untuk Company
    public function companyIndex()
    {
        $categories = Category::all();
        $jobs = Job::where('shalu_company_id', auth()->user()->company->id)
            ->with('category')
            ->latest()->paginate(10);
        return view('company.jobs.index', compact('jobs', 'categories'));
    }

    // 🌐 Untuk Public / Pencari Kerja
    public function publicIndex(Request $request)
    {
        $categories = Category::all();

        $query = Job::with('company', 'category');

        // Jika user mengisi filter, baru kita filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhereHas('company', function ($q2) use ($request) {
                        $q2->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->filled('category')) {
            $query->where('shalu_category_id', $request->category);
        }

        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        // Ambil hasil pencarian atau semua data jika tidak ada filter
        $jobs = $query->latest()->paginate(6)->withQueryString();

        return view('jobs.index', compact('jobs', 'categories'));
    }



    // 🧐 Show detail lowongan
    public function show($id)
    {
        $job = Job::with('company', 'category')->findOrFail($id);

        // Cek jika user login dan role user, apakah sudah pernah melamar
        $hasApplied = false;
        if (auth()->check() && auth()->user()->role === 'user') {
            $hasApplied = auth()->user()
                ->applications()
                ->where('shalu_job_id', $job->id) // pastikan sesuai field di tabel
                ->exists();
        }

        // Untuk company, hanya izinkan melihat job miliknya
        if (auth()->user()?->isCompany()) {
            if ($job->shalu_company_id !== auth()->user()->company->id) {
                abort(403, 'Anda tidak memiliki akses ke lowongan ini.');
            }
            return view('company.jobs.show', compact('job'));
        }

        // Untuk user atau publik
        return view('jobs.show', compact('job', 'hasApplied'));
    }


    // ➕ Buat lowongan (khusus company)
    public function create()
    {
        if (!auth()->check() || auth()->user()->role !== 'company') {
            abort(403);
        }

        $categories = Category::all();
        return view('company.jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'location' => 'required',
            'job_type' => 'required',
            'salary' => 'nullable',
            'shalu_category_id' => 'required|exists:shalu_categories,id',
            'deadline' => 'required|date',
            'description' => 'required',
            'requirements' => 'nullable|string', // <-- jangan lupa ini
        ]);

        Job::create([
            'shalu_company_id' => auth()->user()->company->id,
            'title' => $request->title,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'salary' => $request->salary,
            'shalu_category_id' => $request->shalu_category_id,
            'deadline' => $request->deadline,
            'description' => $request->description,
            'requirements' => $request->requirements, // <-- pastikan ini masuk
            'status' => 'active',
        ]);

        return redirect()->route('company.jobs.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $job = Job::findOrFail($id);

        if (auth()->user()->role === 'company') {
            if ($job->shalu_company_id !== auth()->user()->company->id) {
                abort(403);
            }
        }

        $categories = Category::all();
        return view('company.jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        if (auth()->user()->role === 'company') {
            if ($job->shalu_company_id !== auth()->user()->company->id) {
                abort(403);
            }
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'shalu_category_id' => 'required|exists:shalu_categories,id',
            'deadline' => 'required|date',
            'salary' => 'nullable|string',
            'requirements' => 'required|string'
        ]);

        $job->update($validated);

        return redirect()->route('company.jobs.index')->with('success', 'Lowongan berhasil diperbarui');
    }

   public function destroy($id)
{
    $job = Job::findOrFail($id);

    if (auth()->user()->role === 'company') {
        if ($job->shalu_company_id !== auth()->user()->company->id) {
            abort(403);
        }
    }

    $job->delete();

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil dihapus');
    } else {
        return redirect()->route('company.jobs.index')->with('success', 'Lowongan berhasil dihapus');
    }
}

    // Di app/Models/User.php


}
