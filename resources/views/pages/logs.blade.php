<x-filament::page>
    <div class="flex items-center justify-between">
        <div class="w-full mr-2">
            {{ $this->search }}
        </div>
        <div class="w-auto ml-2">
            <x-filament::button :disabled="is_null($this->logFile)" type="button" color="danger">
                {{ __('filament-log-manager::translations.delete') }}
            </x-filament::button>
        </div>
        <div class="w-auto ml-2">
            <x-filament::button :disabled="is_null($this->logFile)" type="button" color="primary">
                {{ __('filament-log-manager::translations.download') }}
            </x-filament::button>
        </div>
    </div>
    <x-filament::hr />
    <div>
        <div>
            <div x-data="{ opened_tab: null }" class="flex flex-col">
            @forelse($this->getLogs() as $key => $log)
                    <div
                            class="rounded-xl relative mb-2 py-3 px-3 bg-{{ $log['level_class'] }}"
                            :class="{'no-bottom-radius mb-0': opened_tab == {{$key}}}"
                    >
                        <a
                                @click="opened_tab = opened_tab == {{$key}} ? null : {{$key}} "
                                style="cursor: pointer"
                                class="block overflow-hidden rounded-t-xl text-white"
                        >
                                <span>[{{ $log['date'] }}]</span>
                                {{ Str::limit($log['text'], 100) }}
                        </a>
                    </div>
                    <div x-show="opened_tab=={{$key}}" class="mb-2 px-4 py-4 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl no-top-radius">
                        <div>
                            <p>{{$log['text']}}</p>
                            @if(!empty($log['stack']))
                                <div class="bg-gray-100 dark:bg-gray-900 mt-4 p-4 text-sm opacity-40">
                                    <pre class="overflow-scroll"><code>{{ trim($log['stack']) }}</code></pre>
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
</x-filament::page>
