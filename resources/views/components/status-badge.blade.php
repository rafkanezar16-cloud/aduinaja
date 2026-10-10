@props(['status', 'label' => null])

@php
$classes = match ($status) {
    'diajukan' => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200',
    'diproses' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200',
    'selesai' => 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-200',
    'ditolak' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-200',
    default => 'bg-slate-50 text-slate-700 ring-1 ring-inset ring-slate-200',
};
$text = $label ?? ucfirst($status);
@endphp

<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $classes }}">
    {{ $text }}
</span>
