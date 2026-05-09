<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class LoginPage extends Component
{
    public string $phone = '';

    public string $password = '';

    public bool $remember = false;

    public function login()
    {
        $this->validate([
            'phone' => ['required', 'string', 'regex:/^0[0-9]{9}$/'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt(['phone' => $this->phone, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'phone' => 'Số điện thoại hoặc mật khẩu không đúng.',
            ]);
        }

        session()->regenerate();

        $default = Auth::user()->is_admin ? route('dashboard') : route('home');

        return redirect()->intended($default);
    }

    public function render()
    {
        return view('livewire.login-page');
    }
}
