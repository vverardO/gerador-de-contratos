<?php

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Models\Contract;
use App\Services\ContractService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $contractType = '';

    public string $contractStatus = 'on_going';

    public string $search = '';

    public bool $showExtendDaysModal = false;

    public ?int $extendDaysContractId = null;

    public int $extendDaysCount = 1;

    public function updatedContractType(): void
    {
        $this->resetPage();
    }

    public function updatedContractStatus(): void
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

        return $this->redirect(route('login'), navigate: true);
    }

    public function openExtendDaysModal(int $contractId): void
    {
        $this->extendDaysContractId = $contractId;
        $this->extendDaysCount = 1;
        $this->showExtendDaysModal = true;
    }

    public function closeExtendDaysModal(): void
    {
        $this->showExtendDaysModal = false;
        $this->extendDaysContractId = null;
        $this->extendDaysCount = 1;
    }

    public function extendContractDays(): void
    {
        $this->validate([
            'extendDaysCount' => 'required|integer|min:1',
        ], [
            'extendDaysCount.required' => 'A quantidade de dias é obrigatória',
            'extendDaysCount.integer' => 'A quantidade de dias deve ser um número inteiro',
            'extendDaysCount.min' => 'A quantidade de dias deve ser no mínimo 1 dia',
        ]);

        $contract = Contract::findOrFail($this->extendDaysContractId);

        if ($contract->type !== ContractType::OCCASIONAL_RENTAL) {
            $this->dispatch('toast', message: 'Apenas contratos eventuais podem ser estendidos', type: 'error');
            return;
        }

        $currentEndDate = Carbon::parse($contract->end_date);
        $contract->end_date = $currentEndDate->addDays($this->extendDaysCount)->format('Y-m-d H:i:s');
        $contract->quantity_days = ($contract->quantity_days ?? 0) + $this->extendDaysCount;
        $contract->save();

        $this->closeExtendDaysModal();
        $this->dispatch('toast', message: 'Contrato estendido com sucesso', type: 'success');
    }

    public function delete($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->delete();

        $this->dispatch('toast', message: 'Contrato deletado com sucesso', type: 'success');
    }

    public function getContractsProperty()
    {
        $query = Contract::latest();

        if ($this->contractType !== '') {
            $query->where('type', $this->contractType);
        }

        if ($this->contractStatus !== '') {
            $query->where('status', $this->contractStatus);
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

    public function markAsDone($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->status = ContractStatus::DONE;

        if ($contract->type === ContractType::OCCASIONAL_RENTAL) {
            $contract->end_date = now()->format('Y-m-d H:i:s');
        }

        $contract->save();

        $this->dispatch('toast', message: 'Contrato encerrado com sucesso', type: 'success');
    }

    public function markAsCancelled($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->status = ContractStatus::CANCELLED;
        $contract->save();

        $this->dispatch('toast', message: 'Contrato cancelado com sucesso', type: 'success');
    }

    public function markAsOnGoing($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->status = ContractStatus::ON_GOING;
        $contract->save();

        $this->dispatch('toast', message: 'Contrato em andamento', type: 'success');
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
                        <label for="filterContractStatus" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                        <select
                            id="filterContractStatus"
                            wire:model.live="contractStatus"
                            class="w-full sm:w-48 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Todos</option>
                            @foreach(\App\Enums\ContractStatus::cases() as $status)
                                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-auto">
                        <label for="filterSearch" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">motorista ou veículo</label>
                        <input
                            id="filterSearch"
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="nome ou veículo..."
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
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Informações</th>
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
                                        {{ $contract->vehicle }} - {{ $contract->driver_name }}
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
                                                'done' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                                'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                                'on_going' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                            ];
                                            $statusLabels = [
                                                'draft' => 'Rascunho',
                                                'done' => 'Encerrado',
                                                'cancelled' => 'Cancelado',
                                                'on_going' => 'Em andamento',
                                            ];
                                            $status = $contract->status?->value ?? 'draft';
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$status] ?? $statusColors['draft'] }}">
                                            {{ $statusLabels[$status] ?? 'Rascunho' }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $contract->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($contract->is_draft)
                                        <button
                                            wire:click="markAsOnGoing({{ $contract->id }})"
                                            wire:confirm="Tem certeza que deseja marcar como em andamento este contrato?"
                                            class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 mr-4"
                                            title="Marcar como em andamento"
                                        >
                                            <i class="fas fa-play"></i>
                                        </button>
                                        <a
                                            href="{{ route('contracts.edit', $contract->id) }}"
                                            class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-4"
                                            wire:navigate
                                            title="Editar"
                                        >
                                            <i class="fas fa-pencil"></i>
                                        </a>
                                        @elseif($contract->is_on_going)
                                        <button
                                            wire:click="markAsDone({{ $contract->id }})"
                                            wire:confirm="Tem certeza que deseja encerrar este contrato?"
                                            class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 mr-4"
                                            title="Encerrar Contrato"
                                        >
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button
                                            wire:click="markAsCancelled({{ $contract->id }})"
                                            wire:confirm="Tem certeza que deseja cancelar este contrato?"
                                            class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 mr-4"
                                            title="Cancelar Contrato"
                                        >
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        @if($contract->type === \App\Enums\ContractType::OCCASIONAL_RENTAL)
                                        <button
                                            wire:click="openExtendDaysModal({{ $contract->id }})"
                                            class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-4"
                                            title="Estender contrato"
                                        >
                                            <i class="fas fa-calendar-plus"></i>
                                        </button>
                                        @endif
                                        @endif
                                        <a
                                            href="{{ route('contracts.show', $contract->id) }}"
                                            target="_blank"
                                            class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 mr-4"
                                            title="Visualizar"
                                        >
                                            <i class="fas fa-eye"></i>
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
                                        'done' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                        'on_going' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                    ];
                                    $statusLabels = [
                                        'draft' => 'Rascunho',
                                        'done' => 'Encerrado',
                                        'cancelled' => 'Cancelado',
                                        'on_going' => 'Em andamento',
                                    ];
                                    $status = $contract->status?->value ?? 'draft';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$status] ?? $statusColors['draft'] }}">
                                    {{ $statusLabels[$status] ?? 'Rascunho' }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">Criado: {{ $contract->created_at->format('d/m/Y H:i') }}</div>
                            <div class="flex gap-3">
                                @if($contract->is_draft)
                                <button
                                    wire:click="markAsOnGoing({{ $contract->id }})"
                                    wire:confirm="Tem certeza que deseja encerrar este contrato?"
                                    class="flex-1 text-center px-3 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                                    title="Marcar como em andamento"
                                >
                                    <i class="fas fa-play"></i>
                                </button>
                                <a
                                    href="{{ route('contracts.edit', $contract->id) }}"
                                    class="flex-1 text-center px-3 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                                    wire:navigate
                                    title="Editar"
                                >
                                    <i class="fas fa-pencil"></i>
                                </a>
                                @endif
                                @if($contract->is_on_going)
                                <button
                                    wire:click="markAsDone({{ $contract->id }})"
                                    wire:confirm="Tem certeza que deseja encerrar este contrato?"
                                    class="flex-1 text-center px-3 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                                    title="Encerrar Contrato"
                                >
                                    <i class="fas fa-check"></i>
                                </button>
                                <button
                                    wire:click="markAsCancelled({{ $contract->id }})"
                                    wire:confirm="Tem certeza que deseja cancelar este contrato?"
                                    class="flex-1 text-center px-3 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                    title="Cancelar Contrato"
                                >
                                    <i class="fas fa-ban"></i>
                                </button>
                                @if($contract->type === \App\Enums\ContractType::OCCASIONAL_RENTAL)
                                <button
                                    wire:click="openExtendDaysModal({{ $contract->id }})"
                                    class="flex-1 text-center px-3 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                                    title="Estender contrato"
                                >
                                    <i class="fas fa-calendar-plus"></i>
                                </button>
                                @endif
                                @endif
                                <a
                                    href="{{ route('contracts.show', $contract->id) }}"
                                    target="_blank"
                                    class="flex-1 text-center px-3 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                                    title="Visualizar"
                                >
                                    <i class="fas fa-eye"></i>
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

        @if($showExtendDaysModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity" wire:click="closeExtendDaysModal" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
                <div class="relative inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4" id="modal-title">Estender contrato</h3>
                        <div class="mb-4">
                            <label for="extendDaysCount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quantidade de dias</label>
                            <input
                                id="extendDaysCount"
                                type="number"
                                min="1"
                                wire:model="extendDaysCount"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                            @error('extendDaysCount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button
                            type="button"
                            wire:click="extendContractDays"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm"
                        >
                            Estender
                        </button>
                        <button
                            type="button"
                            wire:click="closeExtendDaysModal"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm"
                        >
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </main>
</div>

