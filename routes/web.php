<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\FlatController;
use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaint;
use App\Http\Controllers\Resident\ComplaintController as ResidentComplaint;
use App\Http\Controllers\Admin\EmergencyAlertController;
use App\Http\Controllers\Resident\EmergencyController;
use App\Http\Controllers\Admin\SecurityLogController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Manager\ComplaintController as ManagerComplaintController;
use App\Http\Controllers\Manager\EmergencyController as ManagerEmergencyController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\BuildingAdmin\BA_SubscriptionController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Auth\BuildingRegistrationController;
// PDF Reports
use App\Http\Controllers\ComplaintReportController;
use App\Http\Controllers\BillingReportController;
use App\Http\Controllers\PaymentReceiptController;
// Analytics
use App\Http\Controllers\AnalyticsController;
// Forum
use App\Http\Controllers\ForumController;
// Add stubs for missing controllers
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ReplyController;

// ✅ LOGIN ROUTES
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// ✅ 2FA ROUTES
Route::get('/verify-2fa', [AuthController::class, 'show2FAForm'])->name('verify-2fa');
Route::post('/verify-2fa', [AuthController::class, 'verify2FA'])->name('verify-2fa-code');

Route::get('/register-building', [BuildingRegistrationController::class, 'showForm']);
Route::post('/register-building', [BuildingRegistrationController::class, 'register']);

// ✅ PROTECTED DASHBOARDS
Route::middleware(['web','auth','role:Super Admin'])->prefix('admin')->group(function () {
                                                    // Legal & Policy Tab
                                                    Route::get('/legal-policy', [\App\Http\Controllers\Admin\LegalPolicyController::class, 'index'])->name('admin.legal.policy');
                                                    Route::post('/legal-policy/save-policy', [\App\Http\Controllers\Admin\LegalPolicyController::class, 'savePolicy'])->name('admin.legal.policy.save');
                                                    Route::post('/legal-policy/save-compliance', [\App\Http\Controllers\Admin\LegalPolicyController::class, 'saveCompliance'])->name('admin.legal.policy.save-compliance');
                                                    Route::get('/legal-policy/preview', [\App\Http\Controllers\Admin\LegalPolicyController::class, 'preview'])->name('admin.legal.policy.preview');
                                                    // Diagnostics: Clear System Logs
                                                    Route::post('/system-maintenance/clear-logs', function () {
                                                    $logPath = storage_path('logs/laravel.log');
                                                    if (file_exists($logPath)) {
                                                        file_put_contents($logPath, '');
                                                    }
                                                        return redirect()->route('admin.system.maintenance.view-logs')->with('success', 'All logs cleared successfully!');
                                                    })->name('admin.system.maintenance.clear-logs');
                                                    // Diagnostics: View System Logs
                                                    Route::get('/system-maintenance/view-logs', function () {
                                                        $logPath = storage_path('logs/laravel.log');
                                                        $logs = '';
                                                        if (file_exists($logPath)) {
                                                            $logs = file_get_contents($logPath);
                                                        }
                                                            return view('admin.system-logs', compact('logs'));
                                                        })->name('admin.system.maintenance.view-logs');
                                                // Diagnostics: Send Diagnostic Report
                                                Route::post('/system-maintenance/send-diagnostic', function () {
                                                    // Collect logs (last 100 lines from laravel.log)
                                                    $logPath = storage_path('logs/laravel.log');
                                                    $logs = '';
                                                    if (file_exists($logPath)) {
                                                        $lines = array_slice(file($logPath), -100);
                                                        $logs = implode("", $lines);
                                                    }
                                                    // Send email to dev team
                                                    Mail::raw("Diagnostic Report:\n\n" . $logs, function ($message) {
                                                        $message->to('devteam@example.com')
                                                                ->subject('Diagnostic Report from Admin Panel');
                                                    });
                                                    return redirect()->route('admin.system.maintenance')->with('success', 'Diagnostic report sent to dev team!');
                                                })->name('admin.system.maintenance.send-diagnostic');
                        // Performance & Config actions
                        Route::post('/system-maintenance/clear-cache', function () {
                            \Illuminate\Support\Facades\Artisan::call('cache:clear');
                            return redirect()->route('admin.system.maintenance')->with('success', 'Cache cleared successfully!');
                        })->name('admin.system.maintenance.clear-cache');

                        Route::post('/system-maintenance/rebuild-config', function () {
                            \Illuminate\Support\Facades\Artisan::call('config:cache');
                            return redirect()->route('admin.system.maintenance')->with('success', 'Config rebuilt successfully!');
                        })->name('admin.system.maintenance.rebuild-config');
                // Recent Activities View All
                Route::get('/recent-activities', function () {
                    $recentActivities = collect([]);
                    $recentActivities = $recentActivities->merge(
                        \App\Models\Complaint::latest()->take(10)->get()->map(function($c) {
                            return [
                                'type' => 'complaint',
                                'title' => $c->title ?? 'Complaint',
                                'desc' => $c->status,
                                'time' => $c->created_at->diffForHumans(),
                            ];
                        })
                    );
                    $recentActivities = $recentActivities->merge(
                        \App\Models\Building::latest()->take(10)->get()->map(function($b) {
                            return [
                                'type' => 'building',
                                'title' => $b->name,
                                'desc' => 'New property registration',
                                'time' => $b->created_at->diffForHumans(),
                            ];
                        })
                    );
                    $recentActivities = $recentActivities->merge(
                        \App\Models\User::latest()->take(10)->get()->map(function($u) {
                            return [
                                'type' => 'user',
                                'title' => 'New Admin: ' . $u->name,
                                'desc' => 'System access granted',
                                'time' => $u->created_at->diffForHumans(),
                            ];
                        })
                    );
                    $recentActivities = $recentActivities->sortByDesc('time')->take(20);
                    return view('admin.recent-activities', compact('recentActivities'));
                })->name('admin.recent.activities');
        // System Maintenance Tab
        Route::get('/system-maintenance', function () {
            $maintenanceMode = app()->isDownForMaintenance();
            $systemStatus = $maintenanceMode ? 'Maintenance Enabled' : 'System Active';
            $systemStatusColor = $maintenanceMode ? 'text-orange-600' : 'text-green-600';
            $appVersion = '2.4.1';
            $build = '890';
            $server = 'us-east-1';
            return view('admin.system-maintenance', compact('maintenanceMode','systemStatus','systemStatusColor','appVersion','build','server'));
        })->name('admin.system.maintenance');

        // Ensure POST route is defined and active
        Route::post('/system-maintenance/toggle', function (\Illuminate\Http\Request $request) {
            $secret = null;
            if ($request->has('maintenance_mode')) {
                $secret = bin2hex(random_bytes(16));
                \Illuminate\Support\Facades\Artisan::call('down', [
                    '--secret' => $secret
                ]);
            } else {
                \Illuminate\Support\Facades\Artisan::call('up');
            }
            return redirect()->route('admin.system.maintenance')->with('maintenance_secret', $secret);
        })->name('admin.system.maintenance.toggle');
    // Feature Toggles Settings
    Route::get('/feature-toggles', function () {
        $features = [
            [
                'key' => 'FEATURE_MAINTENANCE_REQUESTS',
                'icon' => 'handyman',
                'title' => 'Maintenance Requests',
                'desc' => 'Manage repairs & tickets',
                'enabled' => env('FEATURE_MAINTENANCE_REQUESTS', true),
            ],
            [
                'key' => 'FEATURE_COMPLAINTS_MODULE',
                'icon' => 'report_problem',
                'title' => 'Complaints Module',
                'desc' => 'Incident reporting system',
                'enabled' => env('FEATURE_COMPLAINTS_MODULE', true),
            ],
            [
                'key' => 'FEATURE_EXPENSES_MODULE',
                'icon' => 'receipt_long',
                'title' => 'Expenses Module',
                'desc' => 'Track society spending',
                'enabled' => env('FEATURE_EXPENSES_MODULE', false),
            ],
            [
                'key' => 'FEATURE_VOTING_POLLS',
                'icon' => 'poll',
                'title' => 'Voting / Polls',
                'desc' => 'AGM & Committee elections',
                'enabled' => env('FEATURE_VOTING_POLLS', true),
            ],
            [
                'key' => 'FEATURE_DOCUMENTS_REPOSITORY',
                'icon' => 'folder_open',
                'title' => 'Documents Repository',
                'desc' => 'Shared rules & bylaws',
                'enabled' => env('FEATURE_DOCUMENTS_REPOSITORY', true),
            ],
            [
                'key' => 'FEATURE_COMMUNITY_FORUMS',
                'icon' => 'forum',
                'title' => 'Community Forums',
                'desc' => 'Discussion boards',
                'enabled' => env('FEATURE_COMMUNITY_FORUMS', false),
            ],
        ];
        return view('admin.feature-toggles', compact('features'));
    })->name('admin.feature.toggles');

    Route::post('/feature-toggles', function (\Illuminate\Http\Request $request) {
        $envPath = base_path('.env');
        $env = file_get_contents($envPath);
        $env = preg_replace('/FEATURE_MAINTENANCE_REQUESTS=.*/', 'FEATURE_MAINTENANCE_REQUESTS=' . ($request->has('FEATURE_MAINTENANCE_REQUESTS') ? 'true' : 'false'), $env);
        $env = preg_replace('/FEATURE_COMPLAINTS_MODULE=.*/', 'FEATURE_COMPLAINTS_MODULE=' . ($request->has('FEATURE_COMPLAINTS_MODULE') ? 'true' : 'false'), $env);
        $env = preg_replace('/FEATURE_EXPENSES_MODULE=.*/', 'FEATURE_EXPENSES_MODULE=' . ($request->has('FEATURE_EXPENSES_MODULE') ? 'true' : 'false'), $env);
        $env = preg_replace('/FEATURE_VOTING_POLLS=.*/', 'FEATURE_VOTING_POLLS=' . ($request->has('FEATURE_VOTING_POLLS') ? 'true' : 'false'), $env);
        $env = preg_replace('/FEATURE_DOCUMENTS_REPOSITORY=.*/', 'FEATURE_DOCUMENTS_REPOSITORY=' . ($request->has('FEATURE_DOCUMENTS_REPOSITORY') ? 'true' : 'false'), $env);
        $env = preg_replace('/FEATURE_COMMUNITY_FORUMS=.*/', 'FEATURE_COMMUNITY_FORUMS=' . ($request->has('FEATURE_COMMUNITY_FORUMS') ? 'true' : 'false'), $env);
        file_put_contents($envPath, $env);
        Artisan::call('config:cache');
        return redirect()->route('admin.feature.toggles')->with('success', 'Feature toggles updated!');
    })->name('admin.feature.toggles.save');

    // Roles & Access Settings
    Route::get('/roles-access', function () {
        $enable_manager = env('ROLES_ENABLE_MANAGER', true);
        $resident_self_registration = env('ROLES_RESIDENT_SELF_REGISTRATION', false);
        $max_managers = env('ROLES_MAX_MANAGERS', 5);
        $disable_role_deletion = env('ROLES_DISABLE_ROLE_DELETION', true);
        $roles = [
            ['name' => 'Super Admin', 'desc' => 'Full Access, System Configuration', 'icon' => 'admin_panel_settings', 'color' => 'primary', 'status' => 'locked'],
            ['name' => 'Manager', 'desc' => 'Building Access, User Management', 'icon' => 'manage_accounts', 'color' => 'purple', 'status' => 'active'],
            ['name' => 'Resident', 'desc' => 'Limited Access, Self Service', 'icon' => 'person', 'color' => 'orange', 'status' => 'default'],
        ];
        return view('admin.roles-access', compact('enable_manager','resident_self_registration','max_managers','disable_role_deletion','roles'));
    })->name('admin.roles.access');

    Route::post('/roles-access', function (\Illuminate\Http\Request $request) {
        $envPath = base_path('.env');
        $env = file_get_contents($envPath);
        $env = preg_replace('/ROLES_ENABLE_MANAGER=.*/', 'ROLES_ENABLE_MANAGER=' . ($request->has('enable_manager') ? 'true' : 'false'), $env);
        $env = preg_replace('/ROLES_RESIDENT_SELF_REGISTRATION=.*/', 'ROLES_RESIDENT_SELF_REGISTRATION=' . ($request->has('resident_self_registration') ? 'true' : 'false'), $env);
        $env = preg_replace('/ROLES_MAX_MANAGERS=.*/', 'ROLES_MAX_MANAGERS=' . $request->input('max_managers', 5), $env);
        $env = preg_replace('/ROLES_DISABLE_ROLE_DELETION=.*/', 'ROLES_DISABLE_ROLE_DELETION=' . ($request->has('disable_role_deletion') ? 'true' : 'false'), $env);
        file_put_contents($envPath, $env);
        Artisan::call('config:cache');
        return redirect()->route('admin.roles.access')->with('success', 'Roles & Access settings updated!');
    })->name('admin.roles.access.save');

    // Users & Security Settings
    Route::get('/admin/users-security', function () {
        return view('admin.users-security', [
            'min_length' => env('SECURITY_MIN_LENGTH', 8),
            'force_change_days' => env('SECURITY_FORCE_CHANGE_DAYS', 90),
            'max_login_attempts' => env('SECURITY_MAX_LOGIN_ATTEMPTS', 5),
            'session_timeout' => env('SECURITY_SESSION_TIMEOUT', 30),
            'ip_logging' => env('SECURITY_IP_LOGGING', true),
        ]);
    })->name('admin.users.security');
        Route::post('/admin/users-security', function (\Illuminate\Http\Request $request) {
        $envPath = base_path('.env');
        $env = file_get_contents($envPath);
        $env = preg_replace('/SECURITY_MIN_LENGTH=.*/', 'SECURITY_MIN_LENGTH=' . $request->input('min_length', 8), $env);
        $env = preg_replace('/SECURITY_FORCE_CHANGE_DAYS=.*/', 'SECURITY_FORCE_CHANGE_DAYS=' . $request->input('force_change_days', 90), $env);
        $env = preg_replace('/SECURITY_MAX_LOGIN_ATTEMPTS=.*/', 'SECURITY_MAX_LOGIN_ATTEMPTS=' . $request->input('max_login_attempts', 5), $env);
        $env = preg_replace('/SECURITY_SESSION_TIMEOUT=.*/', 'SECURITY_SESSION_TIMEOUT=' . $request->input('session_timeout', 30), $env);
        $env = preg_replace('/SECURITY_IP_LOGGING=.*/', 'SECURITY_IP_LOGGING=' . ($request->has('ip_logging') ? 'true' : 'false'), $env);
        file_put_contents($envPath, $env);
        Artisan::call('config:cache');
        return redirect()->route('admin.users.security')->with('success', 'Users & Security settings updated!');
    })->name('admin.users-security.save');

    // Email Notification Settings
    Route::get('/email-notification', function () {
        // Load config from .env or config/mail.php
        $emailConfig = [
            'mail_driver' => env('MAIL_MAILER', 'smtp'),
            'from_name' => env('MAIL_FROM_NAME', ''),
            'from_email' => env('MAIL_FROM_ADDRESS', ''),
            'queue_emails' => env('MAIL_QUEUE', false),
            'encrypt_connection' => env('MAIL_ENCRYPT', false),
        ];
        return view('admin.email-notification', compact('emailConfig'));
    })->name('admin.email.notification');
    
    Route::post('/email-notification', function (\Illuminate\Http\Request $request) {
        $envPath = base_path('.env');
        $env = file_get_contents($envPath);
        $env = preg_replace('/MAIL_MAILER=.*/', 'MAIL_MAILER=' . $request->input('mail_driver', 'smtp'), $env);
        $env = preg_replace('/MAIL_FROM_NAME=.*/', 'MAIL_FROM_NAME="' . $request->input('from_name', '') . '"', $env);
        $env = preg_replace('/MAIL_FROM_ADDRESS=.*/', 'MAIL_FROM_ADDRESS=' . $request->input('from_email', ''), $env);
        $env = preg_replace('/MAIL_QUEUE=.*/', 'MAIL_QUEUE=' . ($request->has('queue_emails') ? 'true' : 'false'), $env);
        $env = preg_replace('/MAIL_ENCRYPT=.*/', 'MAIL_ENCRYPT=' . ($request->has('encrypt_connection') ? 'true' : 'false'), $env);
        file_put_contents($envPath, $env);
        Artisan::call('config:cache');
        return redirect()->route('admin.email.notification')->with('success', 'Email/Notification settings updated!');
    })->name('admin.email.notification.save');

        // Payment Gateway Settings
        Route::get('/admin/payment-gateway', function () {
            $razorpay_key_id = env('RAZORPAY_KEY_ID', '');
            $razorpay_key_secret = env('RAZORPAY_KEY_SECRET', '');
            $razorpay_mode = env('RAZORPAY_ENVIRONMENT', 'test');
            $razorpay_status = env('RAZORPAY_STATUS', true);
            return view('admin.payment-gatway', compact('razorpay_key_id', 'razorpay_key_secret', 'razorpay_mode', 'razorpay_status'));
        })->name('admin.payment.gateway');
    
    Route::post('/admin/payment-gateway', function (\Illuminate\Http\Request $request) {
        $envPath = base_path('.env');
        $env = file_get_contents($envPath);
        $env = preg_replace('/RAZORPAY_KEY_ID=.*/', 'RAZORPAY_KEY_ID=' . $request->input('razorpay_key_id'), $env);
        $env = preg_replace('/RAZORPAY_KEY_SECRET=.*/', 'RAZORPAY_KEY_SECRET=' . $request->input('razorpay_key_secret'), $env);
        $env = preg_replace('/RAZORPAY_ENVIRONMENT=.*/', 'RAZORPAY_ENVIRONMENT=' . $request->input('razorpay_mode', 'test'), $env);
        $env = preg_replace('/RAZORPAY_STATUS=.*/', 'RAZORPAY_STATUS=' . ($request->has('razorpay_status') ? 'true' : 'false'), $env);
        file_put_contents($envPath, $env);
        Artisan::call('config:cache');
        return redirect()->route('admin.payment.gateway')->with('success', 'Razorpay settings updated!');
    })->name('admin.payment.gateway.save');
    
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    // Super Admin Analytics & Reports
    Route::get('/analytics-reports', function () {
        return view('admin.analytics-reports');
    })->name('admin.analytics-reports');

    // Super Admin Building Management
    Route::get('/building-management', function () {
        $buildings = \App\Models\Building::with('admin')->latest()->get();
        return view('admin.building-management', compact('buildings'));
    })->name('admin.building-management');

    // Super Admin Payments
    Route::get('/payment', function () {
        return view('admin.payment');
    })->name('admin.payment');

    // Super Admin Security Logs
    Route::get('/security-logs', function () {
        return view('admin.security-logs');
    })->name('admin.security-logs');

    // Super Admin Subscription Plans
    Route::get('/subcription-plan', function () {
        $plans = \App\Models\Plan::all();
        return view('admin.subcription-plan', compact('plans'));
    })->name('admin.subcription-plan');

    Route::get('/system-settings', function () {
        return view('admin.system-settings');
    })->name('admin.system.settings');

    // Super Admin Subscriptions
    Route::get('/subcription', function () {
        $subscriptions = \App\Models\Subscription::with(['building', 'plan'])->latest()->get();
        $plans = \App\Models\Plan::where('is_active', true)->get();
        $emailConfig = [
            'razorpay_key_id' => config('services.razorpay.key_id'),
            'razorpay_key_secret' => config('services.razorpay.key_secret'),
            'mode' => config('services.razorpay.mode', 'test'),
        ];
        return view('admin.subcription', compact('subscriptions', 'plans', 'emailConfig'));
    })->name('admin.subcription');
    Route::get('/subcription/{subscription}/manage', function($subscriptionId) {
    $subscription = \App\Models\Subscription::with(['building', 'plan'])->findOrFail($subscriptionId);
        return view('admin.subcription-manage', compact('subscription'));
    })->name('admin.subcription.manage');
    // Super Admin User Management
    Route::get('/users-management', function () {
        $query = \App\Models\User::query();
        if (request('role')) {
            $role = strtolower(request('role'));
            $query->whereHas('role', function($q) use ($role) {
                $q->whereRaw('LOWER(name) = ?', [$role]);
            });
        }
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhereHas('building', function($b) use ($search) {
                      $b->where('name', 'like', "%$search%") ;
                  });
            });
        }
        $users = $query->latest()->get();
        $totalUsers = \App\Models\User::count();
        $newUsers = \App\Models\User::where('created_at', '>=', now()->subMonth())->count();
        $pendingUsers = \App\Models\User::where('status', 'pending')->count();
        return view('admin.users_management', compact('users', 'totalUsers', 'newUsers', 'pendingUsers'));
    })->name('users.index');
    // Reports index route for dashboard nav
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('reports.index');
    // Settings index route for dashboard nav
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings.index');
    // Super Admin Dashboard (dynamic)
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    // Super Admin Profile (new Blade view)
    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('admin.profile');
    // Profile avatar upload
    Route::post('/profile/avatar', [\App\Http\Controllers\Admin\ProfileController::class, 'updateAvatar'])->name('admin.profile.avatar');

    Route::resource('buildings', BuildingController::class);
    Route::get('/buildings/{building}/flats', [FlatController::class, 'index'])->name('building-admin.flats.index');
    Route::get('/buildings/{building}/flats/create', [FlatController::class, 'create']);
    Route::post('/buildings/{building}/flats', [FlatController::class, 'store']);

    Route::get('/buildings/{building}/flats/{flat}/edit', [FlatController::class, 'edit']);
    Route::put('/buildings/{building}/flats/{flat}', [FlatController::class, 'update']);
    Route::delete('/buildings/{building}/flats/{flat}', [FlatController::class, 'destroy']);

    Route::get('/flats/{flat}/resident/create', [ResidentController::class, 'create']);
    Route::post('/flats/{flat}/resident', [ResidentController::class, 'store']);

    Route::get('/resident/{resident}/edit', [ResidentController::class, 'edit']);
    Route::put('/resident/{resident}', [ResidentController::class, 'update']);
    Route::delete('/resident/{resident}', [ResidentController::class, 'destroy']);

    Route::get('/admin/flats/{flat}/complaints', [AdminComplaint::class, 'index']);
    Route::post('/admin/complaints/{complaint}/status', [AdminComplaint::class, 'updateStatus']);
    Route::delete('/admin/complaints/{complaint}', [AdminComplaint::class, 'destroy']);

    Route::get('/flats/{flat}/complaints', [AdminComplaint::class, 'index']);
    Route::post('/complaints/{complaint}/status', [AdminComplaint::class, 'updateStatus']);
    Route::delete('/complaints/{complaint}', [AdminComplaint::class, 'destroy']);

    Route::get('/security-logs', [SecurityLogController::class, 'index']);

    Route::get('/subscription/setup', [SubscriptionController::class, 'showSetup'])->name('admin.subscription.setup');
    Route::post('/subscription/checkout', [PaymentController::class, 'checkout'])->name('admin.subscription.checkout');
    // PDF Reports
    Route::get('/reports/pdf', [ComplaintReportController::class, 'pdf'])->name('admin.reports.pdf');
    Route::get('/payments/{payment}/receipt', [PaymentReceiptController::class, 'download'])->name('admin.payments.receipt');
    Route::get('/billing/monthly', [BillingReportController::class, 'monthly'])->name('admin.billing.monthly');
    Route::get('/complaints/report', [ComplaintReportController::class, 'building'])->name('admin.complaints.report');

    // Analytics
    Route::get('/analytics/dashboard', [AnalyticsController::class, 'dashboard'])->name('admin.analytics.dashboard');

    // Forum System
    Route::resource('forums', ForumController::class);
    Route::resource('threads', ThreadController::class);
    Route::resource('replies', ReplyController::class);

    // Roles & Permissions (stubs)
    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\Admin\PermissionController::class);
    
    // simulate success (GET) showing a button
    Route::get('/subscription/simulate/{payment}', [PaymentController::class, 'simulateSuccess'])->name('admin.subscription.success.simulate');

    // actual webhook (POST)
    Route::post('/subscription/webhook/success', [PaymentController::class, 'successWebhook'])->name('admin.subscription.webhook.success');

    Route::post('/subcription/{subscription}/activate', function($subscriptionId) {
        $subscription = \App\Models\Subscription::findOrFail($subscriptionId);
        if ($subscription->status === 'active') {
            $subscription->status = 'suspended';
            $msg = 'Subscription suspended successfully.';
        } else {
            $subscription->status = 'active';
            $msg = 'Subscription activated successfully.';
        }
        $subscription->save();
        return redirect()->route('admin.subcription.manage', $subscriptionId)->with('success', $msg);
    })->name('admin.subcription.activate');
    // Extend Expiry Date (GET: show form, POST: update)
    Route::get('/subcription/{subscription}/extend', function($subscriptionId) {
        $subscription = \App\Models\Subscription::with(['building', 'plan'])->findOrFail($subscriptionId);
        return view('admin.subcription-extend', compact('subscription'));
    })->name('admin.subcription.extend.form');
    Route::post('/subcription/{subscription}/extend', function(\Illuminate\Http\Request $request, $subscriptionId) {
        $request->validate(['expiry_date' => 'required|date|after:today']);
        $subscription = \App\Models\Subscription::findOrFail($subscriptionId);
        $subscription->end_date = $request->input('expiry_date');
        $subscription->save();
        return redirect()->route('admin.subcription.manage', $subscriptionId)->with('success', 'Expiry date updated successfully.');
    })->name('admin.subcription.extend');

    // Change Assigned Plan (GET: show form, POST: update)
    Route::get('/subcription/{subscription}/change-plan', function($subscriptionId) {
        $subscription = \App\Models\Subscription::with(['building', 'plan'])->findOrFail($subscriptionId);
        $plans = \App\Models\Plan::where('is_active', true)->get();
        return view('admin.subcription-change-plan', compact('subscription', 'plans'));
    })->name('admin.subcription.change-plan.form');
    Route::post('/subcription/{subscription}/change-plan', function(\Illuminate\Http\Request $request, $subscriptionId) {
        $request->validate(['plan_id' => 'required|exists:plans,id']);
        $subscription = \App\Models\Subscription::findOrFail($subscriptionId);
        $subscription->plan_id = $request->input('plan_id');
        $subscription->save();
        return redirect()->route('admin.subcription.manage', $subscriptionId)->with('success', 'Plan changed successfully.');
    })->name('admin.subcription.change-plan');
    Route::get('/subcription/{subscription}/view-payments', function($subscriptionId) {
        return view('admin.subcription-view-payments', ['subscriptionId' => $subscriptionId]);
    })->name('admin.subcription.view-payments');

    // Subscription Plan Create/Edit
    Route::get('/subcription-plan/create', function() {
        // TODO: Show create plan form
        return view('admin.subcription-plan-create');
    })->name('admin.subcription-plan.create');
    Route::post('/subcription-plan/create', function(\Illuminate\Http\Request $request) {
        $plan = new \App\Models\Plan();
        $plan->name = $request->input('name');
        $plan->price = $request->input('price');
        $plan->billing_cycle = $request->input('billing_cycle');
        $plan->max_flats = $request->input('max_flats');
        $plan->features = array_map('trim', explode(',', $request->input('features', '')));
        $plan->is_active = $request->input('is_active', 0);
        $plan->save();
        return redirect()->route('admin.subcription-plan')->with('success', 'Plan created successfully.');
    })->name('admin.subcription-plan.store');
    Route::get('/subcription-plan/{plan}/edit', function($planId) {
        $plan = \App\Models\Plan::findOrFail($planId);
        // TODO: Show edit plan form
        return view('admin.subcription-plan-edit', compact('plan'));
    })->name('admin.subcription-plan.edit');
    Route::post('/subcription-plan/{plan}/edit', function(\Illuminate\Http\Request $request, $planId) {
        $plan = \App\Models\Plan::findOrFail($planId);
        $plan->name = $request->input('name');
        $plan->price = $request->input('price');
        $plan->billing_cycle = $request->input('billing_cycle');
        $plan->max_flats = $request->input('max_flats');
        $plan->features = array_map('trim', explode(',', $request->input('features', '')));
        $plan->is_active = $request->input('is_active', 0);
        $plan->save();
        return redirect()->route('admin.subcription-plan')->with('success', 'Plan updated successfully.');
    })->name('admin.subcription-plan.update');
    // System Settings Page (env-based)
    Route::get('/system-settings', function () {
        return view('admin.system-settings', [
            'app_name' => env('APP_NAME'),
            'app_url' => env('APP_URL'),
            'support_email' => env('SUPPORT_EMAIL'),
            'timezone' => env('TIMEZONE'),
            'currency' => env('CURRENCY'),
            'date_format' => env('DATE_FORMAT'),
            'billing_cycle' => env('BILLING_CYCLE'),
            'grace_period' => env('GRACE_PERIOD'),
            'tax_percent' => env('TAX_PERCENT'),
            'invoice_prefix' => env('INVOICE_PREFIX'),
            'auto_disable' => env('AUTO_DISABLE'),
        ]);
    })->name('admin.system-settings');

    Route::post('/system-settings', function (\Illuminate\Http\Request $request) {
        $envPath = base_path('.env');
        $env = file_get_contents($envPath);
        $env = preg_replace('/APP_URL=.*/', 'APP_URL=' . $request->input('app_url', ''), $env);
        $env = preg_replace('/SUPPORT_EMAIL=.*/', 'SUPPORT_EMAIL=' . $request->input('support_email', ''), $env);
        $env = preg_replace('/TIMEZONE=.*/', 'TIMEZONE=' . $request->input('timezone', ''), $env);
        $env = preg_replace('/CURRENCY=.*/', 'CURRENCY=' . $request->input('currency', ''), $env);
        $env = preg_replace('/DATE_FORMAT=.*/', 'DATE_FORMAT=' . $request->input('date_format', ''), $env);
        $env = preg_replace('/BILLING_CYCLE=.*/', 'BILLING_CYCLE=' . $request->input('billing_cycle', ''), $env);
        $env = preg_replace('/GRACE_PERIOD=.*/', 'GRACE_PERIOD=' . $request->input('grace_period', ''), $env);
        $env = preg_replace('/TAX_PERCENT=.*/', 'TAX_PERCENT=' . $request->input('tax_percent', ''), $env);
        $env = preg_replace('/INVOICE_PREFIX=.*/', 'INVOICE_PREFIX=' . $request->input('invoice_prefix', ''), $env);
        $env = preg_replace('/AUTO_DISABLE=.*/', 'AUTO_DISABLE=' . ($request->has('auto_disable') ? 'true' : 'false'), $env);
        file_put_contents($envPath, $env);
        Artisan::call('config:cache');
        return redirect()->route('admin.system-settings')->with('success', 'Settings updated successfully!');
    })->name('admin.system-settings.save');
});

Route::middleware(['web','auth','role:Building Admin'])->prefix('building-admin')->group(function () {
                // Document upload/store route
                Route::post('/documents', [\App\Http\Controllers\BuildingAdmin\DocumentController::class, 'store'])->name('building-admin.documents.store');
            // Financial Reports Download Routes
            Route::get('/reports', [\App\Http\Controllers\BuildingAdmin\ReportsController::class, 'index'])->name('building-admin.reports');
            Route::get('/reports/download/monthly-expenses', [\App\Http\Controllers\BuildingAdmin\ReportsController::class, 'downloadMonthlyExpenses'])->name('building-admin.reports.download.monthly-expenses');
            Route::get('/reports/download/maintenance-collections', [\App\Http\Controllers\BuildingAdmin\ReportsController::class, 'downloadMaintenanceCollections'])->name('building-admin.reports.download.maintenance-collections');
            Route::get('/reports/download/category-wise-expenses', [\App\Http\Controllers\BuildingAdmin\ReportsController::class, 'downloadCategoryWiseExpenses'])->name('building-admin.reports.download.category-wise-expenses');
            Route::get('/reports/download/budget-vs-actual', [\App\Http\Controllers\BuildingAdmin\ReportsController::class, 'downloadBudgetVsActual'])->name('building-admin.reports.download.budget-vs-actual');
            Route::get('/reports/download/outstanding-dues', [\App\Http\Controllers\BuildingAdmin\ReportsController::class, 'downloadOutstandingDues'])->name('building-admin.reports.download.outstanding-dues');
            Route::get('/reports/download/vendor-payments', [\App\Http\Controllers\BuildingAdmin\ReportsController::class, 'downloadVendorPayments'])->name('building-admin.reports.download.vendor-payments');
            // Operational Reports Download Routes
            Route::get('/reports/download/complaints-summary', [\App\Http\Controllers\BuildingAdmin\ReportsController::class, 'downloadComplaintsSummary'])->name('building-admin.reports.download.complaints-summary');
            Route::get('/reports/download/amenity-usage', [\App\Http\Controllers\BuildingAdmin\ReportsController::class, 'downloadAmenityUsage'])->name('building-admin.reports.download.amenity-usage');
        Route::put('/expenses/{expense}', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'update'])->name('building-admin.expenses.update');
    Route::get('/expenses/{expense}/edit', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'edit'])->name('building-admin.expenses.edit');

    // Invoice view and PDF download
    Route::get('/invoice/{id}', [\App\Http\Controllers\BuildingAdmin\InvoiceViewController::class, 'show'])->name('building-admin.invoice.view');
    Route::get('/invoice/{id}/download', [\App\Http\Controllers\BuildingAdmin\InvoiceViewController::class, 'downloadPdf'])->name('building-admin.invoice.download');

    // Invoice listing page
    Route::get('/invoices', [\App\Http\Controllers\BuildingAdmin\InvoiceController::class, 'index'])->name('building-admin.invoices');

    // Payment History page
    Route::get('/payment-history', [\App\Http\Controllers\BuildingAdmin\PaymentHistoryController::class, 'index'])->name('building-admin.payment-history');

    // Activate/Upgrade Plan (Upgrade button)
    Route::post('/subscription/activate', [\App\Http\Controllers\BuildingAdmin\SubscriptionSetupController::class, 'activatePlan'])->name('building-admin.subscription.activate');

    // Razorpay checkout GET route for Building Admin
    Route::get('/subscription/checkout', [\App\Http\Controllers\Admin\PaymentController::class, 'showCheckout'])->name('building-admin.subscription.checkout');
    // Razorpay payment success/failure POST routes
    Route::post('/subscription/payment-success', [\App\Http\Controllers\Admin\PaymentController::class, 'handleSuccess'])->name('building-admin.subscription.payment-success');
    Route::post('/subscription/payment-failure', [\App\Http\Controllers\Admin\PaymentController::class, 'handleFailure'])->name('building-admin.subscription.payment-failure');

        // Subscription renewal (dashboard Renew button)
        Route::post('/subscription/renew', [\App\Http\Controllers\BuildingAdmin\SubscriptionController::class, 'renew'])->name('building-admin.subscription.renew');
    
    Route::get('/dashboard', [\App\Http\Controllers\BuildingAdmin\DashboardController::class, 'index'])->name('building-admin.dashboard');
    Route::get('/recent-activities', [\App\Http\Controllers\BuildingAdmin\DashboardController::class, 'recentActivities'])->name('building-admin.recent-activities');

    // Flats CRUD
    Route::get('/flat-management', [\App\Http\Controllers\BuildingAdmin\FlatController::class, 'index'])->name('building-admin.flat-management.index');
    Route::get('/flats/create', [\App\Http\Controllers\BuildingAdmin\FlatController::class, 'create'])->name('building-admin.flats.create');
    Route::post('/flats', [\App\Http\Controllers\BuildingAdmin\FlatController::class, 'store'])->name('building-admin.flats.store');
    Route::get('/flat-management/{flat}', [\App\Http\Controllers\BuildingAdmin\FlatController::class, 'show'])->name('building-admin.flat-management.show');
    Route::get('/flats/{flat}/edit', [\App\Http\Controllers\BuildingAdmin\FlatController::class, 'edit'])->name('building-admin.flats.edit');
    Route::put('/flats/{flat}', [\App\Http\Controllers\BuildingAdmin\FlatController::class, 'update'])->name('building-admin.flats.update');
    Route::delete('/flats/{flat}', [\App\Http\Controllers\BuildingAdmin\FlatController::class, 'destroy'])->name('building-admin.flats.destroy');

    // Residents CRUD
    Route::get('/resident-management', [App\Http\Controllers\BuildingAdmin\ResidentController::class, 'index'])->name('building-admin.resident-management.index');
    Route::get('/residents', [\App\Http\Controllers\BuildingAdmin\ResidentController::class, 'index'])->name('building-admin.residents.index');
    Route::get('/residents/create', [\App\Http\Controllers\BuildingAdmin\ResidentController::class, 'create'])->name('building-admin.residents.create');
    Route::post('/residents', [\App\Http\Controllers\BuildingAdmin\ResidentController::class, 'store']);
    Route::get('/residents/{resident}/edit', [\App\Http\Controllers\BuildingAdmin\ResidentController::class, 'edit'])->name('building-admin.residents.edit');
    Route::put('/residents/{resident}', [\App\Http\Controllers\BuildingAdmin\ResidentController::class, 'update']);
    Route::delete('/residents/{resident}', [\App\Http\Controllers\BuildingAdmin\ResidentController::class, 'destroy']);

    // Emergency Alerts CRUD
    Route::get('/emergency', [\App\Http\Controllers\BuildingAdmin\EmergencyController::class, 'index'])->name('building-admin.emergency');
    Route::get('/emergency/create', [\App\Http\Controllers\BuildingAdmin\EmergencyController::class, 'create'])->name('building-admin.emergency.create');
    Route::post('/emergency', [\App\Http\Controllers\BuildingAdmin\EmergencyController::class, 'store'])->name('building-admin.emergency.store');
    Route::get('/emergency/{emergency}', [\App\Http\Controllers\BuildingAdmin\EmergencyController::class, 'show'])->name('building-admin.emergency.show');
    Route::get('/emergency/{emergency}/edit', [\App\Http\Controllers\BuildingAdmin\EmergencyController::class, 'edit'])->name('building-admin.emergency.edit');
    Route::put('/emergency/{emergency}', [\App\Http\Controllers\BuildingAdmin\EmergencyController::class, 'update'])->name('building-admin.emergency.update');
    Route::delete('/emergency/{emergency}', [\App\Http\Controllers\BuildingAdmin\EmergencyController::class, 'destroy'])->name('building-admin.emergency.destroy');

    // Complaints
    Route::get('/complaints', [\App\Http\Controllers\BuildingAdmin\ComplaintController::class, 'index'])->name('building-admin.complaints.index');
    Route::get('/complaints/create', [\App\Http\Controllers\BuildingAdmin\ComplaintController::class, 'create'])->name('building-admin.complaints.create');
    Route::post('/complaints', [\App\Http\Controllers\BuildingAdmin\ComplaintController::class, 'store'])->name('building-admin.complaints.store');
    Route::post('/complaints/{complaint}/update-status', [\App\Http\Controllers\BuildingAdmin\ComplaintController::class, 'updateStatus'])->name('building-admin.complaints.update-status');
    Route::get('/complaints/all', [\App\Http\Controllers\BuildingAdmin\ComplaintController::class, 'all'])->name('building-admin.complaints.all');
    Route::get('/complaints/{complaint}', [\App\Http\Controllers\BuildingAdmin\ComplaintController::class, 'show'])->name('building-admin.complaints.show');

    // subscription page
    Route::get('/subscription', [BA_SubscriptionController::class, 'index']);

    // Bottom Nav Required Routes

    Route::get('/expenses/create', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'create'])->name('building-admin.expenses.create');
    Route::post('/expenses', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'store'])->name('building-admin.expenses.store');
    Route::get('/expenses', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'index'])->name('building-admin.expenses.index');
    Route::post('/expenses/budget', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'saveBudget'])->name('building-admin.expenses.budget.save');
    Route::post('/expenses/budget/edit', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'editBudget'])->name('building-admin.expenses.budget.edit');

    Route::post('/expenses/{expense}/approve', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'approve'])->name('building-admin.expenses.approve');
    Route::post('/expenses/{expense}/reject', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'reject'])->name('building-admin.expenses.reject');
    Route::get('/expenses/filter/{status}', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'filter'])->name('building-admin.expenses.filter');
    Route::get('/expenses/history', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'history'])->name('building-admin.expenses.history');
    Route::get('/expenses/pending', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'pending'])->name('building-admin.expenses.pending');
    Route::get('/expenses/export-csv', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'exportCsv'])->name('building-admin.expenses.exportCsv');
    Route::get('/expenses/{expense}/pdf', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'pdf'])->name('building-admin.expenses.pdf');
    Route::get('/expenses/{expense}', [\App\Http\Controllers\BuildingAdmin\ExpenseController::class, 'show'])->name('building-admin.expenses.show');

    Route::get('/documents/create', [\App\Http\Controllers\BuildingAdmin\DocumentController::class, 'create'])->name('building-admin.documents.create');
    
    // subscription page (always pass payments)
    Route::get('/subscription', [\App\Http\Controllers\BuildingAdmin\SubscriptionController::class, 'showPlans'])
        ->name('building-admin.subscription');

    // select plan
    Route::post('/subscription/select', [SubscriptionController::class, 'selectPlan'])
        ->name('buildingAdmin.subscription.select');

    Route::get('/subscription/setup', [\App\Http\Controllers\BuildingAdmin\SubscriptionSetupController::class, 'showSetup'])->name('building-admin.subscription.setup');
    Route::post('/subscription/checkout', [PaymentController::class, 'checkout']); // create payment (simulate/pay)
    Route::post('/subscription/webhook/success', [PaymentController::class, 'successWebhook']); // simulate gateway callback

    Route::get('/building-settings', function() {
        $user = \Illuminate\Support\Facades\Auth::user();
        $building = $user->building;
        return view('building-admin.building-settings', compact('building'));
    })->name('building-admin.building-settings');
    Route::post('/building-settings', function (\Illuminate\Http\Request $request) {
        $user = \Illuminate\Support\Facades\Auth::user();
        $building = $user->building;

        $request->validate([
            'building_name' => 'required|string|max:255',
            'building_address' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'zip' => 'nullable|string',
            'emergency_phone' => 'nullable|string',
            'building_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $building->name = $request->input('building_name');
        $building->address = $request->input('building_address');
        $building->country = $request->input('country');
        $building->state = $request->input('state');
        $building->city = $request->input('city');
        $building->zip = $request->input('zip');
        $building->emergency_phone = $request->input('emergency_phone');

        if ($request->hasFile('building_image')) {
            $file = $request->file('building_image');
            $path = $file->store('building-images', 'public');
            $building->image_url = '/storage/' . $path;
        }

        $building->save();
        return redirect()->route('building-admin.profile')->with('success', 'Building settings updated successfully!');
    })->name('building-admin.building-settings.save');
    
    // Building Profile Routes
    Route::get('/profile', [\App\Http\Controllers\BuildingAdmin\ProfileController::class, 'show'])->name('building-admin.profile');
    
    // Admin User Profile Routes
    Route::get('/profile/admin', [\App\Http\Controllers\BuildingAdmin\ProfileController::class, 'adminProfile'])->name('building-admin.admin-profile');
    Route::get('/profile/admin/edit', [\App\Http\Controllers\BuildingAdmin\ProfileController::class, 'edit'])->name('building-admin.admin-profile.edit');
    Route::post('/profile/admin/update', [\App\Http\Controllers\BuildingAdmin\ProfileController::class, 'update'])->name('building-admin.admin-profile.update');
    Route::get('/profile/admin/password', [\App\Http\Controllers\BuildingAdmin\ProfileController::class, 'passwordForm'])->name('building-admin.admin-profile.password');
    Route::post('/profile/admin/password', [\App\Http\Controllers\BuildingAdmin\ProfileController::class, 'updatePassword'])->name('building-admin.admin-profile.password.update');
    Route::post('/profile/admin/avatar', [\App\Http\Controllers\BuildingAdmin\ProfileController::class, 'updateAvatar'])->name('building-admin.admin-profile.avatar');
    
    // 2FA Routes
    Route::get('/profile/admin/two-factor-setup', [\App\Http\Controllers\BuildingAdmin\ProfileController::class, 'twoFactorSetup'])->name('building-admin.admin-profile.two-factor-setup');
    Route::post('/profile/admin/two-factor-verify', [\App\Http\Controllers\BuildingAdmin\ProfileController::class, 'verifyTwoFactor'])->name('building-admin.admin-profile.two-factor-verify');
    Route::post('/profile/admin/two-factor-disable', [\App\Http\Controllers\BuildingAdmin\ProfileController::class, 'disableTwoFactor'])->name('building-admin.admin-profile.two-factor-disable');  
    //Route::get('/payments/{payment}/receipt', [\App\Http\Controllers\BuildingAdmin\PaymentReceiptController::class, 'download'])->name('building-admin.payments.receipt');
    //Route::get('/reports/pdf', [\App\Http\Controllers\BuildingAdmin\ComplaintReportController::class, 'pdf'])->name('building-admin.reports.pdf');  
    
    Route::get('/documents', [\App\Http\Controllers\BuildingAdmin\DocumentController::class, 'index'])->name('building-admin.documents.index');
    Route::post('/documents/upload', [\App\Http\Controllers\BuildingAdmin\DocumentController::class, 'store'])->name('building-admin.documents.upload');
    Route::get('/documents/download/{id}', [\App\Http\Controllers\BuildingAdmin\DocumentController::class, 'download'])->name('building-admin.documents.download');
    Route::delete('/documents/{id}', [\App\Http\Controllers\BuildingAdmin\DocumentController::class, 'destroy'])->name('building-admin.documents.delete');

    // Removed duplicate static /reports route for building-admin (now handled by controller)
    // Removed reports create route as report creation is not used
    
    // Polls Routes
    Route::get('/polls', [\App\Http\Controllers\BuildingAdmin\PollController::class, 'index'])->name('building-admin.polls.index');
    Route::get('/polls/create', [\App\Http\Controllers\BuildingAdmin\PollController::class, 'create'])->name('building-admin.polls.create');
    Route::post('/polls', [\App\Http\Controllers\BuildingAdmin\PollController::class, 'store'])->name('building-admin.polls.store');
    Route::get('/polls/{poll}', [\App\Http\Controllers\BuildingAdmin\PollController::class, 'show'])->name('building-admin.polls.show');
    Route::get('/polls/{poll}/edit', [\App\Http\Controllers\BuildingAdmin\PollController::class, 'edit'])->name('building-admin.polls.edit');
    Route::put('/polls/{poll}', [\App\Http\Controllers\BuildingAdmin\PollController::class, 'update'])->name('building-admin.polls.update');
    Route::delete('/polls/{poll}', [\App\Http\Controllers\BuildingAdmin\PollController::class, 'destroy'])->name('building-admin.polls.destroy');
    
    // Notices Routes
    Route::get('/notices', [\App\Http\Controllers\BuildingAdmin\NoticeController::class, 'index'])->name('building-admin.notices.index');
    Route::get('/notices/create', [\App\Http\Controllers\BuildingAdmin\NoticeController::class, 'create'])->name('building-admin.notices.create');
    Route::post('/notices', [\App\Http\Controllers\BuildingAdmin\NoticeController::class, 'store'])->name('building-admin.notices.store');
    Route::get('/notices/{notice}/edit', [\App\Http\Controllers\BuildingAdmin\NoticeController::class, 'edit'])->name('building-admin.notices.edit');
    Route::put('/notices/{notice}', [\App\Http\Controllers\BuildingAdmin\NoticeController::class, 'update'])->name('building-admin.notices.update');
    Route::delete('/notices/{notice}', [\App\Http\Controllers\BuildingAdmin\NoticeController::class, 'destroy'])->name('building-admin.notices.destroy');
    
    Route::get('/support', function() { return view('building-admin.support'); })->name('building-admin.support');
    Route::get('/logout', function() { return view('building-admin.logout');})->name('building-admin.logout');

});

// Building Admin Financial Reports
Route::middleware(['auth', 'role:Building Admin'])->prefix('building-admin')->name('building-admin.')->group(function () {
    Route::get('/reports/all-financial', [\App\Http\Controllers\BuildingAdmin\ReportsController::class, 'allFinancialReports'])->name('reports.all-financial');
});

Route::middleware(['web','auth','role:Building Admin','ensure.subscription'])->prefix('admin')->group(function () {
    // protected admin routes (buildings, flats, etc)
});

Route::middleware(['web','auth','role:Manager'])->prefix('manager')->group(function () {

    Route::get('/', [ManagerDashboardController::class, 'index']);

    Route::get('/complaints', [ManagerComplaintController::class, 'index']);
    Route::post('/complaints/{complaint}/status', [ManagerComplaintController::class, 'updateStatus']);

    Route::get('/emergency', [ManagerEmergencyController::class, 'index']);
});

Route::middleware(['web', 'auth', 'role:Resident'])->prefix('resident')->group(function () {
    
    Route::get('/flats/{flat}/complaints', [ResidentComplaint::class, 'create']);
    Route::post('/flats/{flat}/complaints', [ResidentComplaint::class, 'store']);
    Route::get('/emergency', [EmergencyController::class, 'index']);

});