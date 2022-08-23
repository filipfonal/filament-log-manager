<x-filament::page>
    <div class="flex items-center justify-between">
        <div class="w-full">
            {{ $this->search }}
        </div>
    </div>
    <x-filament::hr />
    <div>
        <div id="accordion" role="tablist" aria-multiselectable="true">
            <div x-data="{ opened_tab: null }" class="flex flex-col">
            @forelse($logs as $key => $log)
                    <div
                            @class([
                                'bg-white border border-gray-300 shadow-sm rounded-xl relative',
                                'dark:bg-gray-800 dark:border-gray-600' => config('forms.dark_mode'),
                            ])
                    >
                        <a @click="opened_tab = opened_tab == {{$key}} ? null : {{$key}} "
                                @class([
                                       'flex items-center h-10 overflow-hidden border-b bg-gray-50 rounded-t-xl',
                                       'dark:bg-gray-800 dark:border-gray-700' => config('forms.dark_mode'),
                                   ])
                        >
                                <i class="la la-{{ $log['level_img'] }}"></i>
                                <span>[{{ $log['date'] }}]</span>
                                {{ Str::limit($log['text'], 150) }}
                        </a>
                        <div x-show="opened_tab=={{$key}}" class="px-4 pb-4">
                            <div class="panel-body">
                                <p>{{$log['text']}}</p>
                                <pre><code class="php">{{ trim($log['stack']) }}</code></pre>
                            </div>
                        </div>
                    </div>
{{--                <div--}}
{{--                        @class([--}}
{{--                            'accordion-item bg-white border border-gray-300 shadow-sm rounded-xl relative',--}}
{{--                            'dark:bg-gray-800 dark:border-gray-600' => config('forms.dark_mode'),--}}
{{--                        ])--}}
{{--                >--}}
{{--                        <h2 class="accordion-header mb-0 bg-{{ $log['level_class'] }}" role="tab" id="heading{{ $key }}">--}}
{{--                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapse{{ $key }}" class="text-white">--}}
{{--                                <i class="la la-{{ $log['level_img'] }}"></i>--}}
{{--                                <span>[{{ $log['date'] }}]</span>--}}
{{--                                {{ Str::limit($log['text'], 150) }}--}}
{{--                            </a>--}}
{{--                        </h2>--}}
{{--                        <div id="collapse{{ $key }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $key }}"--}}
{{--                             data-bs-parent="#accordionExample">--}}
{{--                            <div class="accordion-body py-4 px-5">--}}
{{--                                <div class="panel-body">--}}
{{--                                    <p>{{$log['text']}}</p>--}}
{{--                                    <pre><code class="php">{{ trim($log['stack']) }}</code></pre>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                </div>--}}
            @empty
                <h3 class="text-center">No Logs to display.</h3>
            @endforelse
            </div>
        </div>
    </div>
</x-filament::page>
