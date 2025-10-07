<aside class="hidden md:flex md:flex-col sidebar bg-[#0f3b33] text-white py-6 gap-4 items-center sticky top-[56px] h-[calc(100vh-56px)]">
  {{-- Menu (decorativo por ahora) --}}
  <button type="button" aria-label="Abrir menú" class="w-9 h-9 grid place-content-center rounded-md hover:bg-white/10">
    <span class="block w-5 h-0.5 bg-white mb-1"></span>
    <span class="block w-5 h-0.5 bg-white mb-1"></span>
    <span class="block w-5 h-0.5 bg-white"></span>
  </button>

  {{-- Íconos / rutas reales (ajusta si tu routing cambia) --}}
  <a href="{{ url('/dashboard') }}" class="w-10 h-10 grid place-content-center rounded-xl bg-white/10 hover:bg-white/20" title="Dashboard">👤</a>
  <a href="{{ url('/u/historial') }}" class="w-10 h-10 grid place-content-center rounded-xl hover:bg-white/10" title="Historial">🕒</a>
  <a href="{{ url('/u/programar') }}" class="w-10 h-10 grid place-content-center rounded-xl hover:bg-white/10" title="Programar">📍</a>
  <a href="{{ url('/u/puntos') }}" class="w-10 h-10 grid place-content-center rounded-xl hover:bg-white/10" title="Puntos">💳</a>

  <a href="{{ url('/perfil') }}" class="mt-auto w-10 h-10 grid place-content-center rounded-xl hover:bg-white/10" title="Configuración">⚙️</a>
</aside>
