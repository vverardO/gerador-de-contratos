<?php

use App\Enums\ContractStatus;
use App\Models\Contract;
use App\Services\ContractService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $contractType = '';

    public string $search = '';

    public function updatedContractType(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return $this->redirect(route('welcome'), navigate: true);
    }

    public function delete($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->delete();

        $this->dispatch('toast', message: 'Contrato deletado com sucesso', type: 'success');
    }

    public function generatePdf($id)
    {
        try {
            $contract = Contract::findOrFail($id);
            $contractService = app(ContractService::class);
            $contractService->generatePdf($contract);

            $contract->status = ContractStatus::SENT;
            $contract->save();

            $this->dispatch(
                'toast',
                message: 'PDF gerado e enviado com sucesso!',
                type: 'success'
            );
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }
    }

    public function getContractsProperty()
    {
        $query = Contract::latest();

        if ($this->contractType !== '') {
            $query->where('type', $this->contractType);
        }

        if ($this->search !== '') {
            $term = trim($this->search);
            $query->where(function ($q) use ($term) {
                $q->where('driver_name', 'like', "%{$term}%")
                    ->orWhere('vehicle', 'like', "%{$term}%");
            });
        }

        return $query->paginate(7);
    }

    public function markAsSigned($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->status = ContractStatus::SIGNED;
        $contract->save();

        $this->dispatch(
            'toast', message: 'Contrato assinado com sucesso', type: 'success');
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
                    <span class="text-sm sm:text-base text-gray-700 dark:text-gray-300">Contratos</span>
                </div>
                <a href="{{ route('contracts.create') }}" class="text-center px-4 py-2 text-sm sm:text-base bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition" wire:navigate>
                    Novo Contrato
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
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">Contratos</h1>
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <div class="w-full sm:w-auto">
                        <label for="filterContractType" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                        <select
                            id="filterContractType"
                            wire:model.live="contractType"
                            class="w-full sm:w-48 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Todos</option>
                            @foreach(\App\Enums\ContractType::cases() as $type)
                                <option value="{{ $type->value }}">{{ $type->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-auto">
                        <label for="filterSearch" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Motorista ou veículo</label>
                        <input
                            id="filterSearch"
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Buscar por nome ou veículo..."
                            class="w-full sm:w-56 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                </div>
            </div>

            @if($this->contracts->count() > 0)
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Motorista</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Veículo</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Valor</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Criado</th>
                                <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($this->contracts as $contract)
                                <tr>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $contract->id }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $contract->driver_name }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $contract->vehicle }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        R$ {{ $contract->value_formatted }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $contract->type->label() }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm">
                                        @php
                                            $statusColors = [
                                                'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                                'signed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                                'sent' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                            ];
                                            $statusLabels = [
                                                'draft' => 'Rascunho',
                                                'signed' => 'Assinado',
                                                'sent' => 'Enviado',
                                            ];
                                            $status = $contract->status?->value ?? 'draft';
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$status] ?? $statusColors['draft'] }}">
                                            {{ $statusLabels[$status] ?? 'Rascunho' }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $contract->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a
                                            href="{{ route('contracts.show', $contract->id) }}"
                                            target="_blank"
                                            class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 mr-4"
                                            title="Visualizar"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($contract->status->value == 'draft')
                                        <button
                                            wire:click="generatePdf({{ $contract->id }})"
                                            class="text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300 mr-4"
                                            title="Gerar PDF"
                                        >
                                            <i class="fas fa-file-pdf"></i>
                                        </button>
                                        @endif
                                        @if($contract->status->value == 'sent')
                                        <button
                                            wire:click="markAsSigned({{ $contract->id }})"
                                            wire:confirm="Tem certeza que deseja enviar este contrato?"
                                            class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 mr-4"
                                            title="Assinar Contrato"
                                        >
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                        <a
                                            href="{{ route('contracts.edit', $contract->id) }}"
                                            class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-4"
                                            wire:navigate
                                            title="Editar"
                                        >
                                            <i class="fas fa-pencil"></i>
                                        </a>
                                        <button
                                            wire:click="delete({{ $contract->id }})"
                                            wire:confirm="Tem certeza que deseja excluir este contrato?"
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
                    @foreach($this->contracts as $contract)
                        <div class="p-4">
                            <div class="font-medium text-gray-900 dark:text-gray-100 mb-2">{{ $contract->driver_name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Veículo: {{ $contract->vehicle }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Valor: R$ {{ $contract->value_formatted }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                Status: 
                                @php
                                    $statusColors = [
                                        'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        'sent' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                        'signed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                    ];
                                    $statusLabels = [
                                        'draft' => 'Rascunho',
                                        'signed' => 'Assinado',
                                        'sent' => 'Enviado',
                                    ];
                                    $status = $contract->status?->value ?? 'draft';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$status] ?? $statusColors['draft'] }}">
                                    {{ $statusLabels[$status] ?? 'Rascunho' }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">Criado: {{ $contract->created_at->format('M d, Y') }}</div>
                            <div class="flex gap-3">
                                <a
                                    href="{{ route('contracts.show', $contract->id) }}"
                                    target="_blank"
                                    class="flex-1 text-center px-3 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                                    title="Visualizar"
                                >
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($contract->status->value == 'draft')
                                    <button
                                        wire:click="generatePdf({{ $contract->id }})"
                                        class="text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300 mr-4"
                                        title="Gerar PDF"
                                    >
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                @endif
                                @if($contract->status->value == 'sent')
                                    <button
                                        wire:click="markAsSigned({{ $contract->id }})"
                                        wire:confirm="Tem certeza que deseja marcar como assinado este contrato?"
                                        class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 mr-4"
                                        title="Assinar Contrato"
                                    >
                                        <i class="fas fa-check"></i>
                                    </button>
                                @endif
                                <a
                                    href="{{ route('contracts.edit', $contract->id) }}"
                                    class="flex-1 text-center px-3 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                                    wire:navigate
                                    title="Editar"
                                >
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <button
                                    wire:click="delete({{ $contract->id }})"
                                    wire:confirm="Tem certeza que deseja excluir este contrato?"
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
                    {{ $this->contracts->links() }}
                </div>
            @else
                <div class="px-4 sm:px-6 py-8 sm:py-12 text-center">
                <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mb-4">Nenhum contrato encontrado.</p>
                    <a
                        href="{{ route('contracts.create') }}"
                        class="inline-block px-4 py-2 text-sm sm:text-base bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        wire:navigate
                    >
                        Criar Seu Primeiro Contrato
                    </a>
                </div>
            @endif
        </div>
    </main>
</div>

