<?php

use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return $this->redirect(route('login'), navigate: true);
    }

    public function delete($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();

        $this->dispatch('toast', message: 'Motorista deletado com sucesso', type: 'success');
    }

    public function getDriversProperty()
    {
        $query = Driver::latest();

        if ($this->search !== '') {
            $term = trim($this->search);
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('document', 'like', "%{$term}%");
            });
        }

        return $query->paginate(7);
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
                    <span class="text-sm sm:text-base text-gray-700 dark:text-gray-300">Motoristas</span>
                </div>
                <a href="{{ route('drivers.create') }}" class="text-center px-4 py-2 text-sm sm:text-base bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition" wire:navigate>
                    Novo Motorista
                </a>
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
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">Motoristas</h1>
                <div class="w-full sm:w-auto">
                    <label for="filterSearch" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">nome ou documento</label>
                    <input
                        id="filterSearch"
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="nome ou documento..."
                        class="w-full sm:w-56 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>
            </div>

            @if($this->drivers->count() > 0)
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nome</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Documento</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Criado</th>
                                <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($this->drivers as $driver)
                                <tr>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $driver->id }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $driver->name }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $driver->document_formatted }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $driver->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a
                                            href="{{ route('drivers.edit', $driver->id) }}"
                                            class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-4"
                                            wire:navigate
                                            title="Editar"
                                        >
                                            <i class="fas fa-pencil"></i>
                                        </a>
                                        <button
                                            wire:click="delete({{ $driver->id }})"
                                            wire:confirm="Tem certeza que deseja excluir este motorista?"
                                            class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                            title="Excluir"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="sm:hidden divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($this->drivers as $driver)
                        <div class="p-4">
                            <div class="font-medium text-gray-900 dark:text-gray-100 mb-2">{{ $driver->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Documento: {{ $driver->document }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">Criado: {{ $driver->created_at->format('d/m/Y H:i') }}</div>
                            <div class="flex gap-3">
                                <a
                                    href="{{ route('drivers.edit', $driver->id) }}"
                                    class="flex-1 text-center px-3 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                                    wire:navigate
                                    title="Editar"
                                >
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <button
                                    wire:click="delete({{ $driver->id }})"
                                    wire:confirm="Tem certeza que deseja excluir este cliente?"
                                    class="flex-1 px-3 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                    title="Excluir"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $this->drivers->links() }}
                </div>
            @else
                <div class="px-4 sm:px-6 py-8 sm:py-12 text-center">
                <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mb-4">Nenhum motorista encontrado.</p>
                    <a
                        href="{{ route('drivers.create') }}"
                        class="inline-block px-4 py-2 text-sm sm:text-base bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        wire:navigate
                    >
                        Criar Seu Primeiro Motorista
                    </a>
                </div>
            @endif
        </div>
    </main>
</div>

