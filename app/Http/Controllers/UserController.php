<?php

namespace App\Http\Controllers;

use App\Models\{User, Company, Job, Application};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    // Dashboard Admin
    public function adminDashboard()
    {
        return view('dashboard.admin', [
            'totalUsers' => User::count(), // ✔️ Otomatis pakai shalu_users
            'totalCompanies' => Company::count(),
            'totalJobs' => Job::count(),
            'totalApplications' => Application::count()
        ]);
    }
 public function userDashboard()
{
    $user = auth()->user();

    return view('dashboard.user', [
        // Hitung semua lamaran user yang status-nya pending atau diterima
        'activeApplications' => $user->applications()
            ->whereIn('status', ['pending', 'accepted'])
            ->count(),

        // Total lowongan kerja yang masih tersedia (bisa disesuaikan dengan logic deadline/aktif)
        'availableJobs' => Job::where('deadline', '>=', now())->count(), // Pastikan ada field 'deadline' ya

        // Ambil lamaran user untuk ditampilkan (opsional, bisa dipakai nanti di blade)
        'userApplications' => $user->applications()
            ->with('job')
            ->latest()
            ->get(),

        // Rekomendasi lowongan kerja terbaru
        'recommendedJobs' => Job::with(['company', 'category'])
            ->latest()
            ->take(5)
            ->get()
    ]);
}

    public function index()
    {
        $users = User::paginate(10); // Ganti get() dengan paginate()
        return view('admin.users.index', compact('users'));
    }

    // Delete User
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
    public function create()
    {
        return view('admin.users.create'); // Sesuaikan dengan lokasi view Anda
    }

    public function store(Request $request)
    {
        // Validasi dan logika penyimpanan
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,company,user'
        ]);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat');
    }
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required'
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui');
    }
    public function dashboard()
    {
        if (auth()->user()->role === 'admin') {
            return $this->adminDashboard();
        } else {
            return $this->userDashboard();
        }
    }
    public function applicationsIndex()
{
    $user = auth()->user();

    $applications = $user->applications()
        ->with('job.company') // biar bisa akses $application->job->company->name
        ->latest()
        ->paginate(10);

    return view('applications.index', compact('applications'));
}


}