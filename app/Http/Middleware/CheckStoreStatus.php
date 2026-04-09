<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use App\Models\Manager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use Illuminate\Support\Facades\Session;

class CheckStoreStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            // 1. Jo user ADMIN hoy to ena Store nu status check karo
            if ($user->hasRole('Admin')) {
                $activeStore = Store::where('admin_id', $user->id)
                    ->where('status', 1)
                    ->exists();

                if (!$activeStore) {
                    return $this->logoutAndRedirect('Your store is currently inactive. Please contact the Main Admin.');
                }
            }

            // 2. Jo user STORE MANAGER hoy to:
            // - Potanu status check karo (Manager table mathi)
            // - Potana Admin na Store nu status check karo
            if ($user->hasRole('Store Manager')) {

                if (!$user->can('view stores')) {
                    return $this->logoutAndRedirect('Access Denied: You do not have permission to access the Store dashboard.');
                }
                $managerData = Manager::where('user_id', $user->id)->first();

                if ($managerData) {
                    // Manager nu potanu status check (Trim vapryu che to handle spaces)
                    $isManagerActive = (trim($managerData->status) == '1');

                    if (!$isManagerActive) {
                        return $this->logoutAndRedirect('Your manager account is inactive. Please contact your Admin.');
                    }

                    // Manager na Admin na Store nu status check
                    $isStoreActive = Store::where('admin_id', $managerData->admin_id)
                        ->where('status', 1)
                        ->exists();

                    if (!$isStoreActive) {
                        return $this->logoutAndRedirect('The store you are assigned to is currently inactive.');
                    }
                } else {
                    // Jo Manager table ma record j na male
                    return $this->logoutAndRedirect('Manager record not found.');
                }
            }

            if ($user->hasRole('Employee POS')) {
                $employeeData = Employee::where('user_id', $user->id)->first();
                
                
                if ($employeeData) {
                    // - Potanu status check (Employee table)
                    if ($employeeData->status != 1) {
                        return $this->logoutAndRedirect('Your employee account is inactive.');
                    }

                    // - Store status check
                    $isStoreActive = Store::where('id', $employeeData->store_id)
                        ->where('status', 1)
                        ->exists();

                    if (!$isStoreActive) {
                        return $this->logoutAndRedirect('The store you are working in is currently inactive.');
                    }

                    // - Store Manager status check (Optional but recommended)
                    $managerActive = Manager::where('store_id', $employeeData->store_id)
                        ->where('status', 1)
                        ->exists();

                    if (!$managerActive) {
                        return $this->logoutAndRedirect('Store operations are suspended by Manager.');
                    }
                } else {
                    return $this->logoutAndRedirect('Employee record not found.');
                }
            }
        }

        return $next($request);
    }

    /**
     * Logout and Redirect with Error Message
     */
    private function logoutAndRedirect($message)
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login')->withErrors([
            'email' => $message
        ]);
    }
}
