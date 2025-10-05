@props(['color'=>'brand'])
@php
$map = [
 'brand'      => 'bg-brand-50 text-brand-700 ring-brand-200',
 'inorganico' => 'bg-blue-50 text-inorganico ring-blue-200',
 'peligroso'  => 'bg-red-50 text-peligroso ring-red-200',
 'muted'      => 'bg-gray-100 text-gray-600 ring-gray-200',
];
@endphp
<span {{ $attributes->merge(['class'=>'text-xs px-2.5 py-1 rounded-full ring-1 '.$map[$color]]) }}>
  {{ $slot }}
</span>
