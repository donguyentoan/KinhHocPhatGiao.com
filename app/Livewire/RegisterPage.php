<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class RegisterPage extends Component
{
    public string $name = '';

    public string $phone = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function register()
    {
        $validated = $this->validate([
            'name' => ['nullable', 'string', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^0[0-9]{9}$/', Rule::unique('users', 'phone')],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $displayName = filled($validated['name'])
            ? $validated['name']
            : 'Phật tử '.$validated['phone'];

        $user = User::query()->create([
            'name' => $displayName,
            'phone' => $validated['phone'],
            'email' => $validated['phone'].'@phone.local',
            'password' => $validated['password'],
            'is_admin' => false,
        ]);

        Auth::login($user);
        session()->regenerate();

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.register-page');
    }
}
