<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';
    public string $password = '';

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'password.required' => 'A senha é obrigatória.',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return $this->redirect(route('dashboard'), navigate: true);
        }

        $this->addError('email', 'As credenciais fornecidas não correspondem aos nossos registros.');
    }

    public function loginAsRandomUser()
    {
        $randomUser = \App\Models\User::inRandomOrder()->first();

        if ($randomUser) {
            Auth::login($randomUser);
            session()->regenerate();
            return $this->redirect(route('dashboard'), navigate: true);
        }

        $this->addError('email', 'Nenhum usuário encontrado no banco de dados.');
    }
}
?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 px-4 py-8">
    <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-900 dark:text-gray-100 mb-4 sm:mb-6">Entrar</h2>

        <form wire:submit="login">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-mail</label>
                <input
                    type="email"
                    id="email"
                    wire:model="email"
                    class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                    placeholder="seu@email.com"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Senha</label>
                <input
                    type="password"
                    id="password"
                    wire:model="password"
                    class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                    placeholder="Sua senha"
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition"
            >
                Entrar
            </button>
        </form>

        @env('local')
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button
                    type="button"
                    wire:click="loginAsRandomUser"
                    class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition"
                >
                    Entrar como Usuário Aleatório
                </button>
            </div>
        @endenv

        <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
            Não tem uma conta?
            <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:underline" wire:navigate>Registrar</a>
        </p>
    </div>
</div>
