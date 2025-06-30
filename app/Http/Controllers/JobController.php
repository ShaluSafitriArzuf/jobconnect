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
        $jobs = Job::with('company', 'category')->latest()->get();
        return view('jobs.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = Job::with('company', 'category')->findOrFail($id);
        return view('jobs.show', compact('job'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'job_type' => 'required|in:Full-Time,Part-Time,Internship',
            'deadline' => 'required|date',
            'category_id' => 'required|exists:shalu_categories,id',
        ]);

        Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'deadline' => $request->deadline,
            'company_id' => auth()->user()->id,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('jobs.index')->with('success', 'Job berhasil ditambahkan');
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
