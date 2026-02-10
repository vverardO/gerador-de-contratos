<?php

use App\Models\Vehicle;
use App\Models\VehicleModel;
use App\Models\VehicleOwner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public string $vehicleModelId = '';

    public string $vehicleOwnerSearch = '';

    public ?int $selectedVehicleOwnerId = null;

    public bool $creatingNewOwner = false;

    public string $newOwnerName = '';

    public string $newOwnerDocument = '';

    public string $manufacturingModel = '';

    public string $licensePlate = '';

    public string $chassis = '';

    public string $renavam = '';

    public function selectVehicleOwner($vehicleOwnerId)
    {
        $vehicleOwner = VehicleOwner::findOrFail($vehicleOwnerId);
        $this->selectedVehicleOwnerId = (int) $vehicleOwnerId;
        $this->vehicleOwnerSearch = $vehicleOwner->name;
    }

    public function clearVehicleOwner()
    {
        $this->selectedVehicleOwnerId = null;
        $this->vehicleOwnerSearch = '';
    }

    public function showNewOwnerForm()
    {
        $this->creatingNewOwner = true;
        $this->selectedVehicleOwnerId = null;
        $this->vehicleOwnerSearch = '';
        $this->newOwnerName = '';
        $this->newOwnerDocument = '';
    }

    public function showSearchOwner()
    {
        $this->creatingNewOwner = false;
        $this->newOwnerName = '';
        $this->newOwnerDocument = '';
    }

    public function getVehicleOwnersProperty()
    {
        if (strlen($this->vehicleOwnerSearch) < 2) {
            return collect();
        }

        return VehicleOwner::where('name', 'like', '%' . $this->vehicleOwnerSearch . '%')
            ->orWhere('document', 'like', '%' . $this->vehicleOwnerSearch . '%')
            ->limit(10)
            ->get();
    }

    public function getVehicleModelsProperty()
    {
        return VehicleModel::with('vehicleBrand')
            ->orderBy('vehicle_brand_id')
            ->orderBy('title')
            ->get();
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return $this->redirect(route('login'), navigate: true);
    }

    public function save()
    {
        $rules = [
            'vehicleModelId' => ['required', 'exists:vehicle_models,id'],
            'manufacturingModel' => ['required', 'string', 'max:255'],
            'licensePlate' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (Vehicle::where('license_plate', strtoupper($value))->exists()) {
                        $fail('Esta placa já está cadastrada.');
                    }
                },
            ],
            'chassis' => ['required', 'string', 'max:255'],
            'renavam' => ['required', 'string', 'max:255'],
        ];

        $vehicleOwnerId = null;
        if ($this->creatingNewOwner) {
            $rules['newOwnerName'] = ['required', 'string', 'max:255'];
            $rules['newOwnerDocument'] = ['required', 'string', 'max:255', Rule::unique('vehicle_owners', 'document')];
        } else {
            $rules['selectedVehicleOwnerId'] = ['nullable', 'exists:vehicle_owners,id'];
        }

        $this->validate($rules, [
            'vehicleModelId.required' => 'O modelo é obrigatório.',
            'vehicleModelId.exists' => 'O modelo selecionado é inválido.',
            'selectedVehicleOwnerId.exists' => 'O proprietário selecionado é inválido.',
            'newOwnerName.required' => 'O nome do proprietário é obrigatório.',
            'newOwnerDocument.required' => 'O documento do proprietário é obrigatório.',
            'manufacturingModel.required' => 'A fabricação/modelo é obrigatória.',
            'licensePlate.required' => 'A placa é obrigatória.',
            'licensePlate.unique' => 'Esta placa já está cadastrada.',
            'newOwnerDocument.unique' => 'Este documento já está cadastrado.',
            'chassis.required' => 'O chassi é obrigatório.',
            'renavam.required' => 'O RENAVAM é obrigatório.',
        ]);

        if ($this->creatingNewOwner) {
            $vehicleOwner = VehicleOwner::create([
                'name' => $this->newOwnerName,
                'document' => $this->newOwnerDocument,
            ]);
            $vehicleOwnerId = $vehicleOwner->id;
        } else {
            $vehicleOwnerId = $this->selectedVehicleOwnerId;
        }

        Vehicle::create([
            'vehicle_model_id' => $this->vehicleModelId,
            'vehicle_owner_id' => $vehicleOwnerId,
            'manufacturing_model' => $this->manufacturingModel,
            'license_plate' => strtoupper($this->licensePlate),
            'chassis' => strtoupper($this->chassis),
            'renavam' => strtoupper($this->renavam),
        ]);

        session()->flash('toast', [
            'message' => 'Veículo criado com sucesso',
            'type' => 'success'
        ]);

        return $this->redirect(route('vehicles.index'), navigate: true);
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
                    <a href="{{ route('vehicles.index') }}" class="text-sm sm:text-base text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100" wire:navigate>Veículos</a>
                    <span class="hidden sm:inline text-gray-400 dark:text-gray-600">|</span>
                    <span class="text-sm sm:text-base text-gray-700 dark:text-gray-300">Criar</span>
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
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4 sm:mb-6">Criar Veículo</h1>

            <form wire:submit="save">
                <div class="border border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 sm:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informações Gerais</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Proprietário</label>
                            @if($creatingNewOwner)
                                <div class="space-y-4 p-4 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="newOwnerName" class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Nome</label>
                                            <input
                                                type="text"
                                                id="newOwnerName"
                                                wire:model="newOwnerName"
                                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                                placeholder="Nome do proprietário"
                                            >
                                            @error('newOwnerName')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="newOwnerDocument" class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Documento</label>
                                            <input
                                                type="text"
                                                id="newOwnerDocument"
                                                wire:model="newOwnerDocument"
                                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                                placeholder="000.000.000-00 ou 00.000.000/0000-00"
                                            >
                                            @error('newOwnerDocument')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="button" wire:click="showSearchOwner" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                        Buscar proprietário existente
                                    </button>
                                </div>
                            @else
                                <div x-data="{ open: false }" x-on:click.away="open = false">
                                    <div class="relative">
                                        <input
                                            type="text"
                                            id="vehicleOwnerSearch"
                                            wire:model.live="vehicleOwnerSearch"
                                            x-on:focus="open = true"
                                            x-on:input="open = true"
                                            class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                            placeholder="Digite o nome ou documento do proprietário"
                                        >
                                        @if($selectedVehicleOwnerId)
                                            <button type="button" wire:click="clearVehicleOwner" class="absolute right-2 top-1/2 -translate-y-1/2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Limpar</button>
                                        @endif
                                        @if($this->vehicleOwners->count() > 0 && $vehicleOwnerSearch && !$selectedVehicleOwnerId)
                                            <div x-show="open"
                                                 x-cloak
                                                 class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-auto">
                                                @foreach($this->vehicleOwners as $vehicleOwner)
                                                    <button
                                                        type="button"
                                                        wire:click="selectVehicleOwner({{ $vehicleOwner->id }})"
                                                        x-on:click="open = false"
                                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100"
                                                    >
                                                        <div class="font-medium">{{ $vehicleOwner->name }}</div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $vehicleOwner->document }}</div>
                                                    </button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" wire:click="showNewOwnerForm" class="mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                        Cadastrar novo proprietário
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div>
                            <label for="vehicleModelId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Modelo</label>
                            <select
                                id="vehicleModelId"
                                wire:model="vehicleModelId"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                            >
                                <option value="">Selecione o modelo</option>
                                @foreach($this->vehicleModels as $model)
                                    <option value="{{ $model->id }}">{{ $model->vehicleBrand->title }} - {{ $model->title }}</option>
                                @endforeach
                            </select>
                            @error('vehicleModelId')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div x-data="{ formatManufacturingModel(value) { if (!value) return ''; const digits = value.replace(/\D/g, '').slice(0, 8); if (digits.length <= 4) return digits; return digits.slice(0, 4) + '/' + digits.slice(4); }, handleInput(event) { const input = event.target; const formatted = this.formatManufacturingModel(input.value); input.value = formatted; $wire.set('manufacturingModel', formatted); } }" x-init="() => { const input = $el.querySelector('#manufacturingModel'); if (input && $wire.manufacturingModel) { input.value = formatManufacturingModel($wire.manufacturingModel); } $watch('$wire.manufacturingModel', value => { if (value !== undefined && input && input !== document.activeElement) { input.value = formatManufacturingModel(value); } }); }">
                            <label for="manufacturingModel" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fabricação/Modelo</label>
                            <input
                                type="text"
                                id="manufacturingModel"
                                x-on:input="handleInput($event)"
                                x-on:blur="$event.target.value = formatManufacturingModel($event.target.value)"
                                maxlength="9"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="1234/1234"
                            >
                            @error('manufacturingModel')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="licensePlate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Placa</label>
                            <input
                                type="text"
                                id="licensePlate"
                                wire:model="licensePlate"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="ABC1D23"
                            >
                            @error('licensePlate')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="chassis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Chassi</label>
                            <input
                                type="text"
                                id="chassis"
                                wire:model="chassis"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Chassi do veículo"
                            >
                            @error('chassis')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div x-data="{ handleInput(event) { const v = event.target.value.replace(/\D/g, ''); event.target.value = v; $wire.set('renavam', v); } }" x-init="() => { const input = $el.querySelector('#renavam'); if (input && $wire.renavam) { const v = ($wire.renavam || '').replace(/\D/g, ''); input.value = v; $wire.set('renavam', v); } $watch('$wire.renavam', value => { if (value !== undefined && input && input !== document.activeElement) { input.value = (value || '').replace(/\D/g, ''); } }); }">
                            <label for="renavam" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">RENAVAM</label>
                            <input
                                type="text"
                                id="renavam"
                                inputmode="numeric"
                                x-on:input="handleInput($event)"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="RENAVAM"
                            >
                            @error('renavam')
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
                        Salvar
                    </button>
                    <a
                        href="{{ route('vehicles.index') }}"
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

