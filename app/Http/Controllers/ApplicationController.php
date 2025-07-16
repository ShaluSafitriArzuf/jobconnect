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
        $user = auth()->user();

        // 1. Jika Admin
        if ($user->role === 'admin') {
            $applications = Application::with(['user', 'job.company'])
                ->latest()
                ->paginate(10);

            return view('admin.applications.index', compact('applications'));
        }

        // 2. Jika Perusahaan
        if ($user->role === 'company') {
            $company = $user->company; 
            $applications = Application::whereHas('job', function ($query) use ($company) {
                $query->where('shalu_company_id', $company->id);
            })
                ->with(['user', 'job.company'])
                ->latest()
                ->paginate(10);

            return view('company.applications.index', compact('applications'));
        }

        // 3. Jika User Biasa
        $applications = $user->applications()
            ->with('job')
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }

    public function create($jobId)
    {
        $job = Job::findOrFail($jobId);
        return view('applications.create', compact('job'));
    }

    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cover_letter' => 'required|string|min:100',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'education' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'domicile' => 'required|string|max:255',
            'availability' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'portfolio_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
        ]);

        $cvPath = $request->file('cv')->store('cv', 'public');

        Application::create([
            'shalu_user_id' => auth()->id(),
            'shalu_job_id' => $jobId,
            'cover_letter' => $request->cover_letter,
            'cv_path' => $cvPath,
            'education' => $request->education,
            'experience' => $request->experience,
            'domicile' => $request->domicile,
            'availability' => $request->availability,
            'phone' => $request->phone,
            'portfolio_link' => $request->portfolio_link,
            'linkedin_link' => $request->linkedin_link,
            'status' => 'pending',
        ]);

        return redirect()->route('user.applications.index')->with('success', 'Lamaran berhasil dikirim!');
    }

    // Menampilkan pelamar untuk suatu job (khusus company)
    public function userApplications()
    {
        $applications = auth()->user()->applications()->with('job')->latest()->paginate(10); 
        return view('applications.index', compact('applications'));
    }



    public function updateStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        if (auth()->user()->role !== 'company') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        $application->status = $request->status;
        $application->save();

        return redirect()->back()->with('success', 'Status pelamar berhasil diperbarui.');
    }

    public function applicants($jobId)
    {
        $job = Job::findOrFail($jobId);

        if (auth()->user()->role !== 'company' || auth()->user()->company->id !== $job->shalu_company_id) {
            abort(403);
        }

        $applications = $job->applications()->with('user')->paginate(10);

        return view('applications.applicants', compact('applications', 'job'));
    }

}
