<?php

use App\Models\VehicleBrand;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public VehicleBrand $vehicleBrand;

    public string $title = '';

    public function mount($id)
    {
        $this->vehicleBrand = VehicleBrand::findOrFail($id);
        $this->title = $this->vehicleBrand->title;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return $this->redirect(route('login'), navigate: true);
    }

    public function update()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
        ], [
            'title.required' => 'O nome é obrigatório.',
        ]);

        $this->vehicleBrand->update([
            'title' => $this->title,
        ]);

        session()->flash('toast', [
            'message' => 'Marca editada com sucesso',
            'type' => 'success'
        ]);

        return $this->redirect(route('vehicleBrands.index'), navigate: true);
    }
}
?>

<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <nav class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center h-auto sm:h-16 py-3 sm:py-0 gap-3 sm:gap-0">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                    <a href="{{ route('dashboard') }}" class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 hover:text-gray-700 dark:hover:text-gray-300" wire:navigate>
                        {{ config('app.name') }}
                    </a>
                    <span class="hidden sm:inline text-gray-400 dark:text-gray-600">|</span>
                    <a href="{{ route('vehicleBrands.index') }}" class="text-sm sm:text-base text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100" wire:navigate>Marcas</a>
                    <span class="hidden sm:inline text-gray-400 dark:text-gray-600">|</span>
                    <span class="text-sm sm:text-base text-gray-700 dark:text-gray-300">Editar</span>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4 w-full sm:w-auto">
                    <span class="hidden sm:inline text-sm sm:text-base text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                    @include('components.theme-switcher')
                    <button
                        wire:click="logout"
                        class="w-full sm:w-auto px-4 py-2 text-sm sm:text-base bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                    >
                        Sair
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4 sm:mb-6">Editar Marca</h1>

            <form wire:submit="update">
                <div class="border border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 sm:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informações Gerais</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome</label>
                            <input
                                type="text"
                                id="title"
                                wire:model="title"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Nome da marca"
                            >
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                    <button
                        type="submit"
                        class="w-full sm:w-auto px-6 py-2 text-sm sm:text-base bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                    >
                        Atualizar
                    </button>
                    <a
                        href="{{ route('vehicleBrands.index') }}"
                        class="w-full sm:w-auto text-center px-6 py-2 text-sm sm:text-base bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                        wire:navigate
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>
