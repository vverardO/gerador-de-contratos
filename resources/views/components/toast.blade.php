<div
    x-data="{
        toasts: [],
        init() {
            @if(session('toast'))
                this.addToast('{{ session('toast')['message'] }}', '{{ session('toast')['type'] ?? 'success' }}');
            @endif

            window.addEventListener('toast', (event) => {
                const detail = event.detail || {};
                const message = detail.message || (Array.isArray(detail) && detail[0]?.message) || 'Operação realizada com sucesso';
                const type = detail.type || (Array.isArray(detail) && detail[0]?.type) || 'success';
                this.addToast(message, type);
            });
        },
        addToast(message, type = 'success') {
            const id = Date.now();
            this.toasts.push({ id, message, type });
            setTimeout(() => this.removeToast(id), 5000);
        },
        removeToast(id) {
            this.toasts = this.toasts.filter(toast => toast.id !== id);
        }
    }"
    class="fixed top-4 right-4 z-50 space-y-2"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-full"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-full"
            class="max-w-md w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
        >
            <div class="p-5">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <template x-if="toast.type === 'success'">
                            <i class="fas fa-check-circle text-green-400 text-2xl"></i>
                        </template>
                        <template x-if="toast.type === 'error'">
                            <i class="fas fa-times-circle text-red-400 text-2xl"></i>
                        </template>
                    </div>
                    <div class="ml-4 flex-1 min-w-0">
                        <p class="text-base font-medium text-gray-900 dark:text-gray-100 break-words" x-text="toast.message"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button
                            @click="removeToast(toast.id)"
                            class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

