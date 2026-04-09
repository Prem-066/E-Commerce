<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Validation\ValidationException;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $user = auth()->user();

        if ($user->hasRole('Super Admin')) {
            $this->redirect(route('superadmin.dashboard'), navigate: false);
            return;
        }



        if ($user->hasRole('Admin')) {
            $activeStore = \App\Models\Store::where('admin_id', $user->id)
                ->where('status', 1)
                ->first();

            if (!$activeStore) {
                Auth::logout();
                \Illuminate\Support\Facades\Session::invalidate();
                \Illuminate\Support\Facades\Session::regenerateToken();
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'form.email' => ['Your store is currently inactive. Please contact the main admin.'],
                ]);
            }

            if ($user->hasRole('Admin')) {
                $this->redirect(route('admin.dashboard'), navigate: false);
                return;
            }
        }

        if ($user->hasRole('Store Manager')) {
            $managerData = \App\Models\Manager::where('user_id', $user->id)->first();

            if ($managerData) {
                if ($managerData->status != 1) {
                    Auth::logout();
                    \Illuminate\Support\Facades\Session::invalidate();
                    \Illuminate\Support\Facades\Session::regenerateToken();
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'form.email' => ['Your manager account is inactive. Please contact your Admin.'],
                    ]);
                }

                $isStoreActive = \App\Models\Store::where('admin_id', $managerData->admin_id)
                    ->where('status', 1)
                    ->exists();

                if (!$isStoreActive) {
                    Auth::logout();
                    \Illuminate\Support\Facades\Session::invalidate();
                    \Illuminate\Support\Facades\Session::regenerateToken();
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'form.email' => ['The store you are assigned to is currently inactive.'],
                    ]);
                }

                if (!$user->can('view stores')) {
                    Auth::logout();
                    \Illuminate\Support\Facades\Session::invalidate();
                    \Illuminate\Support\Facades\Session::regenerateToken();
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'form.email' => ['Access Denied: You do not have permission to access the Store Manager dashboard.'],
                    ]);
                }

                $this->redirect(route('store.dashboard'), navigate: false);
            } else {
                Auth::logout();
                throw \Illuminate\Support\Facades\Session::invalidate(); 
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'form.email' => ['Manager record not found.'],
                ]);
            }
        }

        if ($user->hasRole('Admin')) {
            $this->redirect(route('admin.dashboard'), navigate: false);
            return;
        }
        if ($user->hasRole('Store Manager')) {
            $this->redirect(route('store.dashboard'), navigate: false);
            return;
        }
        
        if ($user->hasRole('Employee POS')) {
            $employeeData = \App\Models\Employee::where('user_id', $user->id)->first();

            if ($employeeData) {
                $store = \App\Models\Store::find($employeeData->store_id);

                if (!$store || $store->status != 1) {
                    Auth::logout();
                    \Illuminate\Support\Facades\Session::invalidate();
                    \Illuminate\Support\Facades\Session::regenerateToken();
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'form.email' => ['The store you are assigned to is currently inactive.'],
                    ]);
                }

                $manager = \App\Models\Manager::where('store_id', $employeeData->store_id)->first();

                if (!$manager || $manager->status != 1) {
                    Auth::logout();
                    \Illuminate\Support\Facades\Session::invalidate();
                    \Illuminate\Support\Facades\Session::regenerateToken();
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'form.email' => ['Access denied: The Store Manager for your branch is currently inactive.'],
                    ]);
                }

                if ($employeeData->status != 1) {
                    Auth::logout();
                    \Illuminate\Support\Facades\Session::invalidate();
                    \Illuminate\Support\Facades\Session::regenerateToken();
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'form.email' => ['Your employee account is inactive. Please contact your Manager.'],
                    ]);
                }
                $this->redirect(route('employee.dashboard'), navigate: false);
            } else {
                Auth::logout();
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'form.email' => ['Employee record not found.'],
                ]);
            }
        }

        if ($user->hasRole('Employee POS')) {
            $this->redirect(route('employee.dashboard'), navigate: false);
            return;
        }

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="fixed inset-0 z-50 flex flex-col md:flex-row bg-white overflow-y-auto md:overflow-hidden font-sans">
    <div class="relative w-full md:w-5/12 lg:w-1/2 min-h-[35vh] md:min-h-screen flex flex-col justify-between overflow-hidden bg-gray-700 shrink-0">
        <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=2070&auto=format&fit=crop"
            alt="E-commerce Fashion Shopping"
            class="absolute inset-0 w-full h-full object-cover opacity-70 mix-blend-overlay hover:scale-105 transition-transform duration-[20s] ease-out">

        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-black/20"></div>

        <div class="relative z-10 p-6 md:p-12 flex justify-between items-center">
            <a href="/" wire:navigate class="flex items-center gap-2 group">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-white text-gray-900 rounded-full flex items-center justify-center font-bold text-lg md:text-xl shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <span class="text-xl md:text-2xl font-extrabold text-white tracking-tight">TrendEra</span>
            </a>
            <div class="hidden md:flex space-x-4">
                <span class="px-3 py-1 bg-white/20 backdrop-blur text-white text-xs font-semibold rounded-full border border-white/30">New Arrivals</span>
                <span class="px-3 py-1 bg-white/20 backdrop-blur text-white text-xs font-semibold rounded-full border border-white/30">Sale 50%</span>
            </div>
        </div>

        <div class="relative z-10 p-6 md:p-12 mt-auto">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 backdrop-blur-md mb-3 md:mb-4 border border-emerald-500/30">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[10px] md:text-xs font-bold tracking-wider uppercase">Over 5M+ Customers</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-2 md:mb-4 leading-tight">Elevate your <br /><span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 to-yellow-500">wardrobe</span> today.</h1>
            <p class="text-gray-300 text-base md:text-lg max-w-md hidden md:block">Join TrendEra to discover the latest fashion trends, exclusive offers, and a seamless shopping experience.</p>

            <div class="hidden md:flex items-center gap-4 mt-8 pt-6 border-t border-white/10">
                <div class="flex -space-x-3">
                    <img class="w-10 h-10 rounded-full border-2 border-gray-900" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" alt="User">
                    <img class="w-10 h-10 rounded-full border-2 border-gray-900" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=100&q=80" alt="User">
                    <img class="w-10 h-10 rounded-full border-2 border-gray-900" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" alt="User">
                    <div class="w-10 h-10 rounded-full border-2 border-gray-900 bg-gray-800 text-white flex items-center justify-center text-xs font-bold">+1k</div>
                </div>
                <div class="text-sm text-gray-400">
                    <div class="flex text-yellow-400">★★★★★</div>
                    <span class="font-medium text-white">4.9/5</span> from reviews
                </div>
            </div>
        </div>
    </div>

    <div class="w-full md:w-7/12 lg:w-1/2 flex items-start md:items-center justify-center p-4 md:p-12 lg:p-24 bg-gray-50/50 relative overflow-y-auto">
        <div class="hidden sm:block absolute top-0 right-0 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-70 animate-blob"></div>
        <div class="hidden sm:block absolute bottom-0 left-0 w-96 h-96 bg-amber-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-70 animate-blob animation-delay-2000"></div>

        <div class="w-full max-w-md relative z-10 bg-white p-6 md:p-10 rounded-2xl md:rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 my-4 md:my-0">

            <div class="text-center md:text-left mb-6 md:mb-8">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Welcome back</h2>
                <p class="text-gray-500 mt-2 text-xs md:text-sm">Please log in to your TrendEra account to continue shopping.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="login" class="space-y-4 md:space-y-5">
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gray-900 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input wire:model="form.email" id="email" type="email" name="email"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition duration-200 bg-gray-50 focus:bg-white shadow-sm text-sm"
                            placeholder="you@example.com" required autofocus autocomplete="username" />
                    </div>
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-sm text-red-600 font-medium" />
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" wire:navigate class="text-xs md:text-sm font-bold text-gray-900 hover:text-gray-600 transition-colors">
                            Forgot?
                        </a>
                        @endif
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gray-900 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input wire:model="form.password" id="password" type="password" name="password"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition duration-200 bg-gray-50 focus:bg-white shadow-sm text-sm"
                            placeholder="••••••••" required autocomplete="current-password" />
                    </div>
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-sm text-red-600 font-medium" />
                </div>

                <div class="flex items-center">
                    <label for="remember" class="flex items-center cursor-pointer group">
                        <input wire:model="form.remember" id="remember" type="checkbox" name="remember"
                            class="w-5 h-5 border-2 border-gray-300 rounded text-gray-900 focus:ring-gray-900 transition duration-200 cursor-pointer">
                        <span class="ml-2.5 text-xs md:text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">Keep me signed in</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-gray-900/20 text-sm font-bold text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all active:scale-[0.98] disabled:opacity-70">
                        <span wire:loading.remove wire:target="login">Sign In & Shop</span>
                        <span wire:loading wire:target="login" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Verifying...
                        </span>
                    </button>
                </div>

                <div class="relative my-5 md:my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-white text-gray-500 font-medium uppercase tracking-wider">New to TrendEra?</span>
                    </div>
                </div>

                <div>
                    <a href="{{ route('register') }}" wire:navigate
                        class="w-full flex justify-center py-3.5 px-4 border-2 border-gray-200 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 transition duration-200">
                        Create an account
                    </a>
                </div>
            </form>

            <p class="mt-6 md:mt-8 text-center text-[10px] md:text-xs text-gray-500">
                By signing in, you agree to our <a href="#" class="font-semibold text-gray-900 hover:underline">Terms</a> and <a href="#" class="font-semibold text-gray-900 hover:underline">Privacy Policy</a>.
            </p>
        </div>
    </div>
</div>