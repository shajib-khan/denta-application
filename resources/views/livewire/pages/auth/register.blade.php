<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $phone = '';
    public string $gender = '';
    public string $days_select = '';
    public string $time_select = '';
    public string $medical_history = '';
    public string $notes = '';
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
            'phone' => ['required'],
            'gender' => ['required'],
            'days_select' => ['required'],
            'time_select' => ['required'],
            'medical_history' => ['required'],
            'notes' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

         <!-- Phone -->
         <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input wire:model="phone" id="phone" class="block mt-1 w-full" type="number" required autofocus autocomplete="number" />
            <x-input-error :messages="$errors->get('number')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

           <!-- gender Male -->
           <div class="mt-4">
            <x-input-label  for="bio" :value="__('Gender')" />
            <input type="radio" id="male" wire:model="gender" value="1" checked />
            <label for="male">Male</label>
          </div>

          <!-- gender Female -->
          <div>
            <input type="radio" id="female" wire:model="gender" value="0" />
            <label for="female">female</label>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
          </div>

           <!-- Doctor Select -->
         {{-- <div class="mt-4">
            <select wire:model="doctor_id">
                <option value="Select Doctor"</option>
                    @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $docotor->name }}</option>
                @endforeach
            </select>
        </div> --}}

        <!-- Days select -->
        <div class="mt-4">
            <x-input-label for="days_select" :value="__('Day Select')" />
            <x-text-input wire:model="days_select" id="days_select" class="block mt-1 w-full" type="date"/>
            <x-input-error :messages="$errors->get('days_select')" class="mt-2" />
        </div>

          <!-- Time select -->
          <div class="mt-4">
            <x-input-label for="time_select" :value="__('Time Select')" />
            <x-text-input wire:model="time_select" id="time_select" class="block mt-1 w-full" type="time"/>
            <x-input-error :messages="$errors->get('time_select')" class="mt-2" />
        </div>

         <!-- Medical History -->
         <div class="mt-4">
            <x-input-label for="Medical History" :value="__('Medical History')" />
            <x-text-input wire:model="medical_history" id="medical_history" class="block mt-1 w-full" type="text"/>
            <x-input-error :messages="$errors->get('medical_history')" class="mt-2" />
        </div>

         <!-- Notes -->
         <div class="mt-4">
            <x-input-label for="Notes" :value="__('Notes')" />
            <x-text-input wire:model="Notes" id="Notes" class="block mt-1 w-full" type="text"/>
            <x-input-error :messages="$errors->get('Notes')" class="mt-2" />
        </div>



        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
