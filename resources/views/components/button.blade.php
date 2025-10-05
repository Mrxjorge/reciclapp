@props(['variant' => 'primary'])
@php
$styles = [
  'primary' => 'bg-brand-500 text-white hover:bg-brand-600',
  'outline' => 'ring-1 ring-brand-300 text-brand-700 hover:bg-brand-50',
  'ghost'   => 'text-gray-700 hover:bg-gray-100',
];
@endphp
<button {{ $attributes->merge(['class'=>"inline-flex items-center gap-2 px-4 py-2 rounded-xl transition ".$styles[$variant]]) }}>
  {{ $slot }}
</button>
