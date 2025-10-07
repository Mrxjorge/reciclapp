<div class="overflow-x-auto">
  <table {{ $attributes->merge(['class'=>'w-full text-sm']) }}>
    <thead class="text-left text-gray-500">
      {{ $head }}
    </thead>
    <tbody class="divide-y">
      {{ $slot }}
    </tbody>
  </table>
</div>
