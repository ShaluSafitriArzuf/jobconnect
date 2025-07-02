<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Job;

class ApplicationController extends Controller
{
    // Tampilkan semua lamaran user yang sedang login
    public function index()
    {
        $applications = Application::with('job')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('applications.index', compact('applications'));
    }

    // Form untuk melamar kerja
    public function create($jobId)
    {
        $job = Job::findOrFail($jobId);
        return view('applications.create', compact('job'));
    }

    // Simpan data lamaran
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cover_letter' => 'required|string',
        ]);

        Application::create([
            'user_id' => auth()->id(),
            'job_id' => $jobId,
            'cover_letter' => $request->cover_letter,
            'status' => 'pending',
        ]);

        return redirect()->route('applications.index')->with('success', 'Lamaran berhasil dikirim!');
    }
    // Menampilkan pelamar untuk suatu job (khusus company)
    public function applicants($jobId)
    {
        $job = Job::with('applications.user')->findOrFail($jobId);

        // Cek apakah yang login adalah pemilik job ini
        if ($job->company->user_id !== auth()->id()) {
            abort(403);
        }

        return view('applications.applicants', compact('job'));
    }

    public function updateStatus(Request $request, $applicationId)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $application = Application::findOrFail($applicationId);

        // Cek apakah yang login adalah pemilik job-nya
        if ($application->job->company->user_id !== auth()->id()) {
            abort(403);
        }

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }
}
