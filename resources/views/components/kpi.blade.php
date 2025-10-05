@props(['label'=>'', 'value'=>'-', 'hint'=>null])
<div class="bg-white rounded-2xl shadow-soft p-5">
  <div class="text-sm text-gray-500">{{ $label }}</div>
  <div class="text-3xl font-semibold mt-1">{{ $value }}</div>
  @if($hint)<div class="text-xs text-gray-400 mt-1">{{ $hint }}</div>@endif
</div>
