<?php

namespace App\Http\Controllers;

use App\Models\{User, Company, Job, Application, Category};
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
            'totalApplications' => Application::count(),
            'totalCategories' => Category::count()
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
                ->whereHas('job') // 🟢 Tambah whereHas biar aman dari null
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

    public function index(Request $request)
    {
        $query = User::with([
            'company' => function ($q) {
                $q->withCount('jobs');
            }
        ]);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // Delete User
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
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

        return view('user.applications.index', compact('applications'));
    }


}