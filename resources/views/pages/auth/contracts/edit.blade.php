<?php

use App\Enums\ContractType;
use App\Models\Contract;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleOwner;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public Contract $contract;

    public string $type = 'occasional_rental';

    public string $driverSearch = '';

    public ?int $selectedDriverId = null;

    public string $vehicleOwnerSearch = '';

    public ?int $selectedVehicleOwnerId = null;

    public string $vehicleSearch = '';

    public ?int $selectedVehicleId = null;

    public string $driverName = '';

    public string $driverDocument = '';

    public string $driverStreet = '';

    public string $driverNumber = '';

    public string $driverNeighborhood = '';

    public string $driverZipCode = '';

    public string $vehicle = '';

    public string $manufacturingModel = '';

    public string $licensePlate = '';

    public string $chassis = '';

    public string $renavam = '';

    public string $ownerName = '';

    public string $ownerDocument = '';

    public string $value = '';

    public string $valueInWords = '';

    public string $todayDate = '';

    public function mount($id)
    {
        $this->contract = Contract::findOrFail($id);
        $this->type = $this->contract->type->value;
        $this->driverName = $this->contract->driver_name;
        $this->driverDocument = $this->contract->driver_document;
        $this->driverStreet = $this->contract->driver_street;
        $this->driverNumber = $this->contract->driver_number;
        $this->driverNeighborhood = $this->contract->driver_neighborhood;
        $this->driverZipCode = $this->contract->driver_zip_code;
        $this->vehicle = $this->contract->vehicle;
        $this->manufacturingModel = $this->contract->manufacturing_model;
        $this->licensePlate = $this->contract->license_plate;
        $this->chassis = $this->contract->chassis;
        $this->renavam = $this->contract->renavam;
        $this->ownerName = $this->contract->owner_name;
        $this->ownerDocument = $this->contract->owner_document;
        $this->value = $this->contract->value;
        $this->valueInWords = $this->contract->value_in_words;
        $this->todayDate = $this->contract->today_date;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return $this->redirect(route('welcome'), navigate: true);
    }

    public function selectDriver($driverId)
    {
        $driver = Driver::with('address')->findOrFail($driverId);
        $this->selectedDriverId = $driverId;
        $this->driverName = $driver->name;
        $this->driverDocument = $driver->document;
        $this->driverSearch = $driver->name;

        if ($driver->address) {
            $this->driverStreet = $driver->address->street;
            $this->driverNumber = $driver->address->number ?? '';
            $this->driverNeighborhood = $driver->address->neighborhood;
            $this->driverZipCode = $driver->address->postal_code;
        }
    }

    public function getDriversProperty()
    {
        if (strlen($this->driverSearch) < 2) {
            return collect();
        }

        return Driver::where('name', 'like', '%' . $this->driverSearch . '%')
            ->orWhere('document', 'like', '%' . $this->driverSearch . '%')
            ->limit(10)
            ->get();
    }

    public function selectVehicleOwner($vehicleOwnerId)
    {
        $vehicleOwner = VehicleOwner::findOrFail($vehicleOwnerId);
        $this->selectedVehicleOwnerId = $vehicleOwnerId;
        $this->ownerName = $vehicleOwner->name;
        $this->ownerDocument = $vehicleOwner->document;
        $this->vehicleOwnerSearch = $vehicleOwner->name;
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

    public function selectVehicle($vehicleId)
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        $this->selectedVehicleId = $vehicleId;
        $this->vehicle = $vehicle->name;
        $this->manufacturingModel = $vehicle->manufacturing_model;
        $this->licensePlate = $vehicle->license_plate;
        $this->chassis = $vehicle->chassis;
        $this->renavam = $vehicle->renavam;
        $this->vehicleSearch = $vehicle->name;
    }

    public function getVehiclesProperty()
    {
        if (strlen($this->vehicleSearch) < 2) {
            return collect();
        }

        return Vehicle::where('name', 'like', '%' . $this->vehicleSearch . '%')
            ->orWhere('license_plate', 'like', '%' . $this->vehicleSearch . '%')
            ->limit(10)
            ->get();
    }

    public function update()
    {
        $this->validate([
            'type' => ['required', 'string', 'in:occasional_rental,app_rental'],
            'driverName' => ['required', 'string', 'max:255'],
            'driverDocument' => ['required', 'string', 'max:255'],
            'driverStreet' => ['required', 'string', 'max:255'],
            'driverNumber' => ['required', 'string', 'max:255'],
            'driverNeighborhood' => ['required', 'string', 'max:255'],
            'driverZipCode' => ['required', 'string', 'max:255'],
            'vehicle' => ['required', 'string', 'max:255'],
            'manufacturingModel' => ['required', 'string', 'max:255'],
            'licensePlate' => ['required', 'string', 'max:255'],
            'chassis' => ['required', 'string', 'max:255'],
            'renavam' => ['required', 'string', 'max:255'],
            'ownerName' => ['required', 'string', 'max:255'],
            'ownerDocument' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:255'],
            'valueInWords' => ['required', 'string', 'max:255'],
            'todayDate' => ['required', 'string', 'max:255'],
        ], [
            'type.required' => 'O tipo de contrato é obrigatório.',
            'driverName.required' => 'O nome do motorista é obrigatório.',
            'driverDocument.required' => 'O documento do motorista é obrigatório.',
            'driverStreet.required' => 'A rua do motorista é obrigatória.',
            'driverNumber.required' => 'O número do motorista é obrigatório.',
            'driverNeighborhood.required' => 'O bairro do motorista é obrigatório.',
            'driverZipCode.required' => 'O CEP do motorista é obrigatório.',
            'vehicle.required' => 'O veículo é obrigatório.',
            'manufacturingModel.required' => 'O modelo/fabricação é obrigatório.',
            'licensePlate.required' => 'A placa é obrigatória.',
            'chassis.required' => 'O chassi é obrigatório.',
            'renavam.required' => 'O RENAVAM é obrigatório.',
            'ownerName.required' => 'O nome do proprietário é obrigatório.',
            'ownerDocument.required' => 'O documento do proprietário é obrigatório.',
            'value.required' => 'O valor do contrato é obrigatório.',
            'valueInWords.required' => 'O valor por extenso é obrigatório.',
            'todayDate.required' => 'A data de hoje é obrigatória.',
        ]);

        $this->contract->update([
            'type' => $this->type,
            'driver_name' => $this->driverName,
            'driver_document' => $this->driverDocument,
            'driver_street' => $this->driverStreet,
            'driver_number' => $this->driverNumber,
            'driver_neighborhood' => $this->driverNeighborhood,
            'driver_zip_code' => $this->driverZipCode,
            'vehicle' => $this->vehicle,
            'manufacturing_model' => $this->manufacturingModel,
            'license_plate' => $this->licensePlate,
            'chassis' => $this->chassis,
            'renavam' => $this->renavam,
            'owner_name' => $this->ownerName,
            'owner_document' => $this->ownerDocument,
            'value' => $this->value,
            'value_in_words' => $this->valueInWords,
            'today_date' => $this->todayDate,
        ]);

        session()->flash('toast', [
            'message' => 'Contrato editado com sucesso',
            'type' => 'success'
        ]);

        return $this->redirect(route('contracts.index'), navigate: true);
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
                    <a href="{{ route('contracts.index') }}" class="text-sm sm:text-base text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100" wire:navigate>Contratos</a>
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
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4 sm:mb-6">Editar Contrato</h1>

            <form wire:submit="update">
                <div class="border border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 sm:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informações Gerais</h2>
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo</label>
                        <select
                            id="type"
                            wire:model="type"
                            class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                        >
                            <option value="occasional_rental">Locação Ocasional</option>
                            <option value="app_rental">Locação por App</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="border border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 sm:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Motorista</h2>
                    <div class="mb-4" x-data="{ open: false }" x-on:click.away="open = false">
                        <label for="driverSearch" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buscar Motorista</label>
                        <div class="relative">
                            <input
                                type="text"
                                id="driverSearch"
                                wire:model.live="driverSearch"
                                x-on:focus="open = true"
                                x-on:input="open = true"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Digite o nome ou documento do motorista"
                            >
                            @if($this->drivers->count() > 0 && $driverSearch && !$selectedDriverId)
                                <div x-show="open" 
                                     x-cloak
                                     class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-auto">
                                    @foreach($this->drivers as $driver)
                                        <button
                                            type="button"
                                            wire:click="selectDriver({{ $driver->id }})"
                                            x-on:click="open = false"
                                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100"
                                        >
                                            <div class="font-medium">{{ $driver->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $driver->document }}</div>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="driverName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome do Motorista</label>
                            <input
                                type="text"
                                id="driverName"
                                wire:model="driverName"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Nome do motorista"
                            >
                            @error('driverName')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="driverDocument" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Documento do Motorista</label>
                            <input
                                type="text"
                                id="driverDocument"
                                wire:model="driverDocument"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="000.000.000-00 ou 00.000.000/0000-00"
                            >
                            @error('driverDocument')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="driverZipCode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CEP</label>
                                <input
                                    type="text"
                                    id="driverZipCode"
                                    wire:model="driverZipCode"
                                    class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="00000-000"
                                >
                                @error('driverZipCode')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="driverStreet" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rua</label>
                                <input
                                    type="text"
                                    id="driverStreet"
                                    wire:model="driverStreet"
                                    class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="Rua do motorista"
                                >
                                @error('driverStreet')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="driverNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número</label>
                                <input
                                    type="text"
                                    id="driverNumber"
                                    wire:model="driverNumber"
                                    class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="Número"
                                >
                                @error('driverNumber')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="driverNeighborhood" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bairro</label>
                                <input
                                    type="text"
                                    id="driverNeighborhood"
                                    wire:model="driverNeighborhood"
                                    class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="Bairro"
                                >
                                @error('driverNeighborhood')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 sm:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Veículo</h2>
                    <div class="mb-4" x-data="{ open: false }" x-on:click.away="open = false">
                        <label for="vehicleSearch" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buscar Veículo</label>
                        <div class="relative">
                            <input
                                type="text"
                                id="vehicleSearch"
                                wire:model.live="vehicleSearch"
                                x-on:focus="open = true"
                                x-on:input="open = true"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Digite o nome ou placa do veículo"
                            >
                            @if($this->vehicles->count() > 0 && $vehicleSearch && !$selectedVehicleId)
                                <div x-show="open" 
                                     x-cloak
                                     class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-auto">
                                    @foreach($this->vehicles as $vehicle)
                                        <button
                                            type="button"
                                            wire:click="selectVehicle({{ $vehicle->id }})"
                                            x-on:click="open = false"
                                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100"
                                        >
                                            <div class="font-medium">{{ $vehicle->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $vehicle->license_plate }}</div>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="vehicle" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Veículo</label>
                            <input
                                type="text"
                                id="vehicle"
                                wire:model="vehicle"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Ex: Chevrolet Onix"
                            >
                            @error('vehicle')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="manufacturingModel" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fabricação/Modelo</label>
                            <input
                                type="text"
                                id="manufacturingModel"
                                wire:model="manufacturingModel"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Ex: 2023/2024"
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
                        <div>
                            <label for="renavam" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">RENAVAM</label>
                            <input
                                type="text"
                                id="renavam"
                                wire:model="renavam"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="RENAVAM"
                            >
                            @error('renavam')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="border border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 sm:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Proprietário</h2>
                    <div class="mb-4" x-data="{ open: false }" x-on:click.away="open = false">
                        <label for="vehicleOwnerSearch" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buscar Proprietário</label>
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
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="ownerName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome do Proprietário</label>
                            <input
                                type="text"
                                id="ownerName"
                                wire:model="ownerName"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Nome do proprietário"
                            >
                            @error('ownerName')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="ownerDocument" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Documento do Proprietário</label>
                            <input
                                type="text"
                                id="ownerDocument"
                                wire:model="ownerDocument"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="000.000.000-00 ou 00.000.000/0000-00"
                            >
                            @error('ownerDocument')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="border border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 sm:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Valores e Data</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valor</label>
                            <input
                                type="text"
                                id="value"
                                wire:model="value"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Ex: 89,90"
                            >
                            @error('value')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="todayDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Hoje</label>
                            <input
                                type="text"
                                id="todayDate"
                                wire:model="todayDate"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Ex: 24 de janeiro de 2026"
                            >
                            @error('todayDate')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="valueInWords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valor por Extenso</label>
                        <input
                            type="text"
                            id="valueInWords"
                            wire:model="valueInWords"
                            class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                            placeholder="Ex: oitenta e nove reais e noventa centavos"
                        >
                        @error('valueInWords')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
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
                        href="{{ route('contracts.index') }}"
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

