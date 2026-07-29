<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ $heading }}
        </x-slot>

        @if ($items->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $empty }}</p>
        @else
            @php
                $max = max(1, (int) $items->max('total'));
            @endphp
            <ul class="space-y-3">
                @foreach ($items as $item)
                    <li>
                        <div class="mb-1 flex items-center justify-between gap-3 text-sm">
                            <span class="truncate font-medium text-gray-950 dark:text-white" title="{{ $item['label'] }}">
                                {{ $item['label'] }}
                            </span>
                            <span class="shrink-0 tabular-nums text-gray-500 dark:text-gray-400">
                                {{ number_format($item['total']) }}
                            </span>
                        </div>
                        <div class="h-1.5 overflow-hidden rounded-full bg-gray-100 dark:bg-white/10">
                            <div
                                class="h-full rounded-full bg-primary-600"
                                style="width: {{ max(4, round(($item['total'] / $max) * 100)) }}%"
                            ></div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
