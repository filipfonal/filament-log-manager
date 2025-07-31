<x-filament::page>
    <!-- Cabeçalho com campo de pesquisa e botões de ação -->
    <div class="flex flex-col md:flex-row items-start justify-between gap-4">
        <!-- Campo de pesquisa -->
        <div class="w-full">
            {{ $this->search }}
        </div>
        
        <!-- Botões de ação (download e exclusão) -->
        <div class="flex items-center gap-3 self-end">
            @if(config('filament-log-manager.allow_download'))
                <x-filament::button
                    wire:click="download"
                    :disabled="is_null($this->logFile)"
                    type="button"
                    color="primary"
                >
                    {{ __('filament-log-manager::translations.download') }}
                </x-filament::button>
            @endif
            
            @if(config('filament-log-manager.allow_delete'))
                <x-filament::button
                    x-on:click="window.dispatchEvent(new CustomEvent('open-modal', { detail: { id: 'filament-log-manager-delete-log-file-modal' } }));"
                    :disabled="is_null($this->logFile)"
                    type="button"
                    color="danger"
                >
                    {{ __('filament-log-manager::translations.delete') }}
                </x-filament::button>
            @endif
        </div>
    </div>
    
    <hr class="border-t border-gray-200 dark:border-gray-800">
    
    <!-- Lista de logs com espaçamento vertical -->
    <div x-data="{ openItem: null }" class="space-y-2">
        @forelse($this->getLogs() as $key => $log)
            <!-- Card de log individual -->
            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
                <!-- Cabeçalho expansível do log -->
                <button
                    type="button"
                    x-on:click="openItem = openItem === {{ $key }} ? null : {{ $key }}"
                    class="w-full flex items-center justify-between p-3 text-left bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                >
                    <div class="flex items-center gap-3">
                        <!-- Ícone baseado no nível de log -->
                        <div class="flex-shrink-0">
                            @if(in_array($log['level'], ['emergency', 'alert', 'critical', 'error']))
                                <!-- Ícone para erros - versão mais suave -->
                                <div class="flex items-center justify-center h-8 w-8 rounded-full bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-red-500 dark:text-red-400">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @elseif($log['level'] === 'warning')
                                <!-- Ícone para avisos - versão mais suave -->
                                <div class="flex items-center justify-center h-8 w-8 rounded-full bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-400/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-amber-500 dark:text-amber-400">
                                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @else
                                <!-- Ícone para informações - versão mais suave -->
                                <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-50 dark:bg-blue-900/10 border border-blue-200 dark:border-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-blue-500 dark:text-blue-400">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Conteúdo principal do log -->
                        <div>
                            <div class="text-sm font-medium text-gray-700 dark:text-gray-100">
                                {{ Str::limit($log['text'], 100) }}
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <!-- Data e nível do log -->
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $log['date'] }}</span>
                                @if(in_array($log['level'], ['emergency', 'alert', 'critical', 'error']))
                                    <span class="inline-flex items-center px-2 py-0.5 justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset min-w-[theme(spacing.4)] tracking-tighter fi-color-red bg-red-50 text-red-600 ring-red-600/10 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/30 ">
                                        {{ Str::upper($log['level']) }}
                                    </span>
                                @elseif($log['level'] === 'warning')
                                    <span class="inline-flex items-center px-2 py-0.5 justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset min-w-[theme(spacing.4)] tracking-tighter fi-color-red bg-amber-50 text-amber-600 ring-amber-600/10 dark:bg-amber-400/10 dark:text-amber-400 dark:ring-amber-400/30">
                                        {{ Str::upper($log['level']) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset min-w-[theme(spacing.4)] tracking-tighter fi-color-blue bg-blue-50 text-blue-600 ring-blue-600/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30 fi-color-primary">
                                        {{ Str::upper($log['level']) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ícone de expansão/recolhimento -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                        class="h-5 w-5 text-gray-400 dark:text-gray-500 transition-transform duration-200"
                        x-bind:class="{'rotate-180': openItem === {{ $key }}}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                
                <!-- Detalhes expandidos do log -->
                <div x-show="openItem === {{ $key }}" x-cloak class="p-4 border-t border-gray-200 dark:border-gray-700">
                    <!-- Texto completo do log -->
                    <div class="text-sm text-gray-800 dark:text-gray-200">
                        {{ $log['text'] }}
                    </div>
                    
                    <!-- Stack trace, se disponível -->
                    @if(!empty($log['stack']))
                        <div class="mt-4">
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Stack Trace:</div>
                            <div class="rounded-lg bg-gray-50 dark:bg-gray-900 p-3">
                                <pre class="text-xs font-mono overflow-x-auto max-h-64">{{ trim($log['stack']) }}</pre>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <!-- Estado vazio quando não há logs -->
            <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-8 w-8 text-gray-400 dark:text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-400">{{ __('filament-log-manager::translations.no_logs') }}</h3>
            </div>
        @endforelse
    </div>
    
    <!-- Modal de confirmação para exclusão de logs -->
    <x-filament::modal id="filament-log-manager-delete-log-file-modal">
        <x-slot name="heading">
            {{ __('filament-log-manager::translations.modal_delete_heading') }}
        </x-slot>
        <x-slot name="description">
            {{ __('filament-log-manager::translations.modal_delete_subheading') }}
        </x-slot>
        <x-slot name="footerActions">
            <!-- Botão cancelar -->
            <x-filament::button
                type="button"
                x-on:click="isOpen = false"
                color="secondary"
                outlined
            >
                {{ __('filament-log-manager::translations.modal_delete_action_cancel') }}
            </x-filament::button>
            
            <!-- Botão confirmar exclusão -->
            <x-filament::button
                wire:click="delete"
                x-on:click="isOpen = false"
                type="button"
                color="danger"
            >
                {{ __('filament-log-manager::translations.modal_delete_action_confirm') }}
            </x-filament::button>
        </x-slot>
    </x-filament::modal>
</x-filament::page>