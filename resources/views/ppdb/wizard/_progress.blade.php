@php
    $steps = [
        1 => 'Biodata',
        2 => 'Data Ortu',
        3 => 'Dokumen',
        4 => 'Foto Rapor',
        5 => 'Konfirmasi Nilai',
        6 => 'Rekomendasi',
        7 => 'Pilih Jurusan',
    ];
@endphp

<div class="max-w-3xl mx-auto px-6 pt-8">
    <div class="flex items-center overflow-x-auto pb-2 gap-1">
        @foreach($steps as $num => $label)
            <div class="flex items-center shrink-0">
                <div class="flex flex-col items-center gap-1.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 transition-colors
                        {{ $num < $currentStep ? 'bg-skblue-600 text-white' : ($num === $currentStep ? 'bg-skblue-600 text-white ring-4 ring-skblue-100' : 'bg-skblue-50 text-skblue-300 border border-skblue-200') }}">
                        @if($num < $currentStep)
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        @else
                            {{ $num }}
                        @endif
                    </div>
                    <span class="text-[10px] font-medium {{ $num === $currentStep ? 'text-skblue-700' : 'text-slate-400' }} whitespace-nowrap">{{ $label }}</span>
                </div>
                @if($num < count($steps))
                    <div class="w-8 md:w-12 h-0.5 mx-1 mb-4 {{ $num < $currentStep ? 'bg-skblue-600' : 'bg-skblue-100' }}"></div>
                @endif
            </div>
        @endforeach
    </div>
</div>