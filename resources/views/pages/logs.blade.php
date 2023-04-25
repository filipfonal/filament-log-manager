<x-filament::page>
    <div class="flex flex-wrap items-center justify-between gap-y-4">
        <div class="mr-2 grow">
            {{ $this->search }}
        </div>
        @if (config('filament-log-manager.allow_delete'))
            <div class="ml-2 w-auto">
                <x-filament::button type="button" x-on:click="window.dispatchEvent(new CustomEvent('open-modal', { detail: { id: 'filament-log-manager-delete-log-file-modal' } }));" :disabled="is_null($this->logFile)" color="danger">
                    {{ __('filament-log-manager::translations.delete') }}
                </x-filament::button>
            </div>
        @endif
        @if (config('filament-log-manager.allow_download'))
            <div class="ml-2 w-auto">
                <x-filament::button type="button" wire:click="download" :disabled="is_null($this->logFile)" color="primary">
                    {{ __('filament-log-manager::translations.download') }}
                </x-filament::button>
            </div>
        @endif
        <div class="ml-2 w-auto">
            <x-filament::button type="button" wire:click="copyAndEmpty" :disabled="is_null($this->logFile)" color="warning">
                Copy/Empty
            </x-filament::button>
        </div>
    </div>
    <x-filament::hr />
    <div>
        <div>
            <div class="flex flex-col" x-data="{ isCardOpen: null }">
                @forelse($this->getLogs() as $key => $log)
                    <div class="bg-{{ $log['level_class'] }} relative mb-2 rounded-xl py-3 px-3" :class="{ 'no-bottom-radius mb-0': isCardOpen == {{ $key }} }">
                        <a class="block overflow-hidden rounded-t-xl text-white" style="cursor: pointer;" @click="isCardOpen = isCardOpen == {{ $key }} ? null : {{ $key }} ">
                            <span>[{{ $log['date'] }}]</span>
                            {{ Str::limit($log['text'], 100) }}
                        </a>
                    </div>
                    <div class="no-top-radius mb-2 rounded-xl bg-white px-4 py-4 text-gray-900 dark:bg-gray-700 dark:text-white" x-show="isCardOpen=={{ $key }}">
                        <div>
                            <p>{{ $log['text'] }}</p>
                            @if (!empty($log['stack']))
                                <div class="mt-4 bg-gray-100 p-4 text-sm opacity-40 dark:bg-gray-900">
                                    <pre style="overflow-x: scroll;"><code>{{ trim($log['stack']) }}</code></pre>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <h3 class="text-center">{{ __('filament-log-manager::translations.no_logs') }}</h3>
                @endforelse
            </div>
        </div>
    </div>
    <x-filament::modal id="filament-log-manager-delete-log-file-modal" :heading="__('filament-log-manager::translations.modal_delete_heading')" :subheading="__('filament-log-manager::translations.modal_delete_subheading')">
        <x-slot name="actions">
            <x-filament::modal.actions fullWidth="true">
                <x-filament::button class="filament-page-modal-button-action" type="button" x-on:click="isOpen = false" color="secondary" outlined="true">
                    {{ __('filament-log-manager::translations.modal_delete_action_cancel') }}
                </x-filament::button>
                <x-filament::button class="filament-page-modal-button-action" type="button" wire:click="delete" x-on:click="isOpen = false" color="danger">
                    {{ __('filament-log-manager::translations.modal_delete_action_confirm') }}
                </x-filament::button>
            </x-filament::modal.actions>
        </x-slot>
    </x-filament::modal>
</x-filament::page>
