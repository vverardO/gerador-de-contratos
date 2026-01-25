<?php

use App\Enums\ContractType;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public string $type = ContractType::OccasionalRental->value;
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

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return $this->redirect(route('welcome'), navigate: true);
    }

    public function save()
    {
        $this->validate([
            'type' => 'required|string|in:occasional_rental,app_rental',
            'driverName' => 'required|string|max:255',
            'driverDocument' => 'required|string|max:255',
            'driverStreet' => 'required|string|max:255',
            'driverNumber' => 'required|string|max:255',
            'driverNeighborhood' => 'required|string|max:255',
            'driverZipCode' => 'required|string|max:255',
            'vehicle' => 'required|string|max:255',
            'manufacturingModel' => 'required|string|max:255',
            'licensePlate' => 'required|string|max:255',
            'chassis' => 'required|string|max:255',
            'renavam' => 'required|string|max:255',
            'ownerName' => 'required|string|max:255',
            'ownerDocument' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'valueInWords' => 'required|string|max:255',
            'todayDate' => 'required|string|max:255',
        ]);

        Contract::create([
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
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4 sm:mb-6">Criar Contrato</h1>

            <form wire:submit="save">
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

                <div class="mb-4">
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

                <div class="mb-4">
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

                <div class="mb-4">
                    <label for="driverStreet" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rua do Motorista</label>
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

                <div class="mb-4">
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

                <div class="mb-4">
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

                <div class="mb-4">
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

                <div class="mb-4">
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

                <div class="mb-4">
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

                <div class="mb-4">
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

                <div class="mb-4">
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

                <div class="mb-4">
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

                <div class="mb-4">
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

                <div class="mb-4">
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

                <div class="mb-4">
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

                <div class="mb-4">
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

                <div class="mb-6">
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

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                    <button
                        type="submit"
                        class="w-full sm:w-auto px-6 py-2 text-sm sm:text-base bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                    >
                        Salvar
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

