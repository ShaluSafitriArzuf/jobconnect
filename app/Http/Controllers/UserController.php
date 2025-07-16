<?php

namespace App\Http\Controllers;

use App\Models\{User, Company, Job, Application, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function adminDashboard()
    {
        return view('dashboard.admin', [
            'totalUsers' => User::count(), 
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
            'activeApplications' => $user->applications()
                ->whereIn('status', ['pending', 'accepted'])
                ->count(),

            'availableJobs' => Job::where('deadline', '>=', now())->count(), 
            'userApplications' => $user->applications()
                ->whereHas('job') 
                ->with('job')
                ->latest()
                ->get(),

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
            ->with('job.company') 
            ->latest()
            ->paginate(10);

        return view('user.applications.index', compact('applications'));
    }


}