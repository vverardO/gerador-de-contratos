<?php

use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public Driver $driver;

    public string $name = '';

    public string $document = '';

    public string $postalCode = '';

    public string $street = '';

    public string $number = '';

    public string $complement = '';

    public string $neighborhood = '';

    public string $city = '';

    public string $state = '';

    public function mount($id)
    {
        $this->driver = Driver::findOrFail($id);
        $this->name = $this->driver->name;
        $this->document = $this->driver->document;

        if ($this->driver->address) {
            $this->postalCode = $this->driver->address->postal_code;
            $this->street = $this->driver->address->street;
            $this->number = $this->driver->address->number ?? '';
            $this->complement = $this->driver->address->complement ?? '';
            $this->neighborhood = $this->driver->address->neighborhood;
            $this->city = $this->driver->address->city;
            $this->state = $this->driver->address->state;
        }
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
            'name' => ['required', 'string', 'max:255'],
            'document' => ['required', 'string', 'max:255', Rule::unique('drivers', 'document')->ignore($this->driver->id)],
            'postalCode' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:255'],
            'complement' => ['nullable', 'string', 'max:255'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'document.required' => 'O documento é obrigatório.',
            'document.unique' => 'Este documento já está cadastrado.',
            'postalCode.required' => 'O CEP é obrigatório.',
            'street.required' => 'A rua é obrigatória.',
            'neighborhood.required' => 'O bairro é obrigatório.',
            'city.required' => 'A cidade é obrigatória.',
            'state.required' => 'O estado é obrigatório.',
        ]);

        $this->driver->update([
            'name' => $this->name,
            'document' => $this->document,
        ]);

        if ($this->driver->address) {
            $this->driver->address->update([
                'postal_code' => $this->postalCode,
                'street' => $this->street,
                'number' => $this->number ?: null,
                'complement' => $this->complement ?: null,
                'neighborhood' => $this->neighborhood,
                'city' => $this->city,
                'state' => $this->state,
            ]);
        } else {
            $this->driver->address()->create([
                'postal_code' => $this->postalCode,
                'street' => $this->street,
                'number' => $this->number ?: null,
                'complement' => $this->complement ?: null,
                'neighborhood' => $this->neighborhood,
                'city' => $this->city,
                'state' => $this->state,
            ]);
        }

        session()->flash('toast', [
            'message' => 'Motorista editado com sucesso',
            'type' => 'success'
        ]);

        return $this->redirect(route('drivers.index'), navigate: true);
    }

    public function updatedPostalCode()
    {
        if (strlen($this->postalCode) !== 8) {
            return;
        }

        $address = Http::get(
            "https://viacep.com.br/ws/{$this->postalCode}/json/"
        )->json();

        if (isset($address['erro']) || ! $address) {
            $this->dispatch('alert', type: 'error', message: 'CEP não encontrado, digite o endereço manualmente!');

            return;
        }

        $this->street = $address['logradouro'];
        $this->neighborhood = $address['bairro'];
        $this->city = $address['localidade'];
        $this->state = $address['uf'];
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
                    <a href="{{ route('drivers.index') }}" class="text-sm sm:text-base text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100" wire:navigate>Motoristas</a>
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
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4 sm:mb-6">Editar Motorista</h1>
            <form wire:submit="update">
                <div class="border border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 sm:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informações Gerais</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome</label>
                            <input
                                type="text"
                                id="name"
                                wire:model="name"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Nome do motorista"
                            >
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div x-data="{formatDocument(value){if(!value)return'';const numbers=value.replace(/\D/g,'').slice(0,11);if(numbers.length<=3)return numbers;if(numbers.length<=6)return numbers.replace(/(\d{3})(\d+)/,'$1.$2');if(numbers.length<=9)return numbers.replace(/(\d{3})(\d{3})(\d+)/,'$1.$2.$3');return numbers.replace(/(\d{3})(\d{3})(\d{3})(\d+)/,'$1.$2.$3-$4').slice(0,14);},handleInput(event){const input=event.target;const formatted=this.formatDocument(input.value);input.value=formatted;$wire.set('document',formatted);}}" x-init="()=>{const input=$el.querySelector('#document');if(input&&$wire.document){input.value=formatDocument($wire.document);} $watch('$wire.document',value=>{if(value&&input&&input!==document.activeElement){input.value=formatDocument(value);}});}">
                            <label for="document" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Documento</label>
                            <input
                                type="text"
                                id="document"
                                x-on:input="handleInput($event)"
                                x-on:blur="$event.target.value = formatDocument($event.target.value)"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="000.000.000-00"
                            >
                            @error('document')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="border border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 sm:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Endereço</h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="postalCode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CEP</label>
                                <input
                                    type="text"
                                    id="postalCode"
                                    wire:model.live="postalCode"
                                    class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="00000-000"
                                >
                                @error('postalCode')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="street" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rua</label>
                                <input
                                    type="text"
                                    id="street"
                                    wire:model="street"
                                    class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="Nome da rua"
                                >
                                @error('street')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número</label>
                                <input
                                    type="text"
                                    id="number"
                                    wire:model="number"
                                    class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="Número"
                                >
                                @error('number')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="complement" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Complemento</label>
                                <input
                                    type="text"
                                    id="complement"
                                    wire:model="complement"
                                    class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="Complemento"
                                >
                                @error('complement')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="neighborhood" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bairro</label>
                            <input
                                type="text"
                                id="neighborhood"
                                wire:model="neighborhood"
                                class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Bairro"
                            >
                            @error('neighborhood')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cidade</label>
                                <input
                                    type="text"
                                    id="city"
                                    wire:model="city"
                                    class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="Cidade"
                                >
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado</label>
                                <input
                                    type="text"
                                    id="state"
                                    wire:model="state"
                                    class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="Estado"
                                >
                                @error('state')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
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
                        href="{{ route('drivers.index') }}"
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

