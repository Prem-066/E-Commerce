<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
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
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <span class="text-xl md:text-2xl font-extrabold text-white tracking-tight">TrendEra</span>
            </a>
            <div class="hidden md:flex space-x-4">
                <span class="px-3 py-1 bg-white/20 backdrop-blur text-white text-xs font-semibold rounded-full border border-white/30">Free Shipping</span>
            </div>
        </div>

        <div class="relative z-10 p-6 md:p-12 mt-auto">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 backdrop-blur-md mb-3 md:mb-4 border border-emerald-500/30">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[10px] md:text-xs font-bold tracking-wider uppercase">Join the community</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-2 md:mb-4 leading-tight">Start your <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 to-yellow-500">style journey</span> today.</h1>
            <p class="text-gray-300 text-base md:text-lg max-w-md hidden md:block">Create an account to track orders, save your favorites, and get exclusive access to new drops.</p>
        </div>
    </div>

    <div class="w-full md:w-7/12 lg:w-1/2 flex items-start md:items-center justify-center p-4 md:p-12 bg-gray-50/50 relative overflow-y-auto">
        <div class="hidden sm:block absolute top-0 right-0 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-70 animate-blob"></div>
        <div class="hidden sm:block absolute bottom-0 left-0 w-96 h-96 bg-emerald-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-70 animate-blob animation-delay-2000"></div>

        <div class="w-full max-w-md relative z-10 bg-white p-6 md:p-10 rounded-2xl md:rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 my-6 md:my-8">
            
            <div class="text-center md:text-left mb-6 md:mb-8">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Create an account</h2>
                <p class="text-gray-500 mt-2 text-xs md:text-sm">Join TrendEra and unlock a world of fashion possibilities.</p>
            </div>

            <form wire:submit="register" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gray-900 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input wire:model="name" id="name" type="text" name="name"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition duration-200 bg-gray-50 focus:bg-white shadow-sm text-sm"
                            placeholder="John Doe" required autofocus autocomplete="name" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600 font-medium" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gray-900 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <input wire:model="email" id="email" type="email" name="email"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition duration-200 bg-gray-50 focus:bg-white shadow-sm text-sm"
                            placeholder="you@example.com" required autocomplete="username" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 font-medium" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gray-900 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input wire:model="password" id="password" type="password" name="password"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition duration-200 bg-gray-50 focus:bg-white shadow-sm text-sm"
                            placeholder="••••••••" required autocomplete="new-password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 font-medium" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gray-900 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition duration-200 bg-gray-50 focus:bg-white shadow-sm text-sm"
                            placeholder="••••••••" required autocomplete="new-password" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600 font-medium" />
                </div>

                <div class="pt-2 md:pt-4">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-gray-900/20 text-sm font-bold text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="register">Create Account</span>
                        <span wire:loading wire:target="register" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Creating...
                        </span>
                    </button>
                </div>
                
                <div class="relative my-5 md:my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-white text-gray-500 font-medium">Already have an account?</span>
                    </div>
                </div>

                <div>
                    <a href="{{ route('login') }}" wire:navigate
                        class="w-full flex justify-center py-3.5 px-4 border-2 border-gray-200 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 transition duration-200">
                        Sign In
                    </a>
                </div>
            </form>
            
            <p class="mt-6 md:mt-8 text-center text-[11px] md:text-xs text-gray-500">
                By registering, you agree to our <a href="#" class="font-semibold text-gray-900 hover:underline">Terms</a> and <a href="#" class="font-semibold text-gray-900 hover:underline">Privacy Policy</a>.
            </p>
        </div>
    </div>
</div>
