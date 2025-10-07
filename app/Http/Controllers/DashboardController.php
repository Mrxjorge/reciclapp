<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        Carbon::setLocale(app()->getLocale());
        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();
        $startOfWeek = $today->copy()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = $today->copy()->endOfWeek(Carbon::SUNDAY);

        $baseQuery = Pickup::query()->with('localidad')->where('user_id', $user->id);
        $completedQuery = (clone $baseQuery)->where('estado', 'completada');

        $upcomingPickup = (clone $baseQuery)
            ->whereDate('fecha_programada', '>=', $today)
            ->orderBy('fecha_programada')
            ->orderBy('hora_programada')
            ->first();

        $recentPickups = (clone $baseQuery)
            ->orderByDesc('fecha_programada')
            ->orderByDesc('hora_programada')
            ->limit(6)
            ->get();

        $completedPickups = (clone $completedQuery)->get();
        $completedThisMonth = $completedPickups->filter(fn($pickup) => $pickup->fecha_programada && $pickup->fecha_programada->between($startOfMonth, $endOfMonth, true));
        $completedThisWeek = $completedPickups->filter(fn($pickup) => $pickup->fecha_programada && $pickup->fecha_programada->between($startOfWeek, $endOfWeek, true));

        $totalKilos = (float) $completedPickups->sum(fn($pickup) => (float) ($pickup->kilos ?? 0));
        $co2Avoided = round($totalKilos * 1.8, 1);
        $streakDays = $this->calculateStreak($completedPickups);

        $pointsGoal = 1250;
        $pointsTotal = $this->calculatePoints($completedPickups);
        $pointsThisMonth = $this->calculatePoints($completedThisMonth);
        $pointsProgress = $pointsGoal > 0 ? min(100, round(($pointsThisMonth / $pointsGoal) * 100)) : 0;

        $impactWeek = $this->buildImpactMetrics($completedThisWeek);

        $calendar = $this->buildCalendar($baseQuery, $startOfMonth, $endOfMonth, $today);
        $availableSlotsCount = $calendar['available_days_count'];
        $nextAvailableDates = $calendar['next_available_dates'];

        $level = $this->determineLevel($totalKilos, $completedPickups->count());
        $firstName = Str::of($user->name ?? '')->squish()->before(' ');
        $firstName = $firstName !== '' ? $firstName : $user->name;

        return view('dashboard', [
            'user' => $user,
            'firstName' => $firstName,
            'upcomingPickup' => $upcomingPickup,
            'recentPickups' => $recentPickups,
            'totalKilos' => $totalKilos,
            'co2Avoided' => $co2Avoided,
            'streakDays' => $streakDays,
            'pointsTotal' => $pointsTotal,
            'pointsThisMonth' => $pointsThisMonth,
            'pointsGoal' => $pointsGoal,
            'pointsProgress' => $pointsProgress,
            'impactWeek' => $impactWeek,
            'calendarWeeks' => $calendar['weeks'],
            'calendarMonthLabel' => Str::title($startOfMonth->translatedFormat('F Y')),
            'availableSlotsCount' => $availableSlotsCount,
            'nextAvailableDates' => $nextAvailableDates,
            'level' => $level,
        ]);
    }

    private function calculatePoints($pickups): int
    {
        return (int) round($pickups->sum(function ($pickup) {
            $base = match ($pickup->tipo_residuo) {
                'organico' => 60,
                'inorganico' => 80,
                'peligroso' => 120,
                default => 50,
            };

            $weightBonus = ($pickup->kilos ?? 0) * 12;

            return $base + $weightBonus;
        }));
    }

    private function buildImpactMetrics($pickups): array
    {
        $defaults = [
            'organico' => ['label' => 'Residuos orgánicos', 'goal' => 30],
            'inorganico' => ['label' => 'Inorgánicos', 'goal' => 20],
            'peligroso' => ['label' => 'Residuos peligrosos', 'goal' => 5],
        ];

        $grouped = collect($defaults)->map(function ($meta, $type) use ($pickups) {
            $totalKg = $pickups->where('tipo_residuo', $type)->sum(fn($pickup) => (float) ($pickup->kilos ?? 0));
            $totalKg = $totalKg > 0 ? round($totalKg, 1) : 0;

            return [
                'label' => $meta['label'],
                'kg' => $totalKg,
                'goal' => $meta['goal'],
            ];
        })->toArray();

        return $grouped;
    }

    private function buildCalendar($baseQuery, Carbon $startOfMonth, Carbon $endOfMonth, Carbon $today): array
    {
        $pickupsMonth = (clone $baseQuery)
            ->whereBetween('fecha_programada', [$startOfMonth, $endOfMonth])
            ->orderBy('fecha_programada')
            ->get()
            ->groupBy(fn($pickup) => optional($pickup->fecha_programada)->day);

        $daysInMonth = $startOfMonth->daysInMonth;
        $leadingBlankDays = $startOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)

        $weeks = [];
        $week = [];
        for ($i = 0; $i < $leadingBlankDays; $i++) {
            $week[] = null;
        }

        $availableDays = collect();

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $startOfMonth->copy()->day($day);
            $pickupsForDay = $pickupsMonth->get($day, collect());
            $isPast = $date->lt($today);
            $isToday = $date->isSameDay($today);
            $hasPickup = $pickupsForDay->isNotEmpty();

            $week[] = [
                'day' => $day,
                'date' => $date,
                'pickups' => $pickupsForDay,
                'isPast' => $isPast,
                'isToday' => $isToday,
            ];

            if (!$isPast && !$hasPickup) {
                $availableDays->push($date);
            }

            if (count($week) === 7) {
                $weeks[] = $week;
                $week = [];
            }
        }

        if (!empty($week)) {
            while (count($week) < 7) {
                $week[] = null;
            }
            $weeks[] = $week;
        }

        $nextAvailableDates = $availableDays
            ->sort()
            ->take(3)
            ->map(fn(Carbon $date) => $date->translatedFormat('d M'))
            ->values();

        return [
            'weeks' => $weeks,
            'available_days_count' => $availableDays->count(),
            'next_available_dates' => $nextAvailableDates,
        ];
    }

    private function calculateStreak($pickups): int
    {
        $dates = $pickups
            ->filter(fn($pickup) => $pickup->estado === 'completada' && $pickup->fecha_programada)
            ->map(fn($pickup) => $pickup->fecha_programada->toDateString())
            ->unique()
            ->sortDesc()
            ->values();

        if ($dates->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $previous = null;

        foreach ($dates as $dateString) {
            $date = Carbon::parse($dateString);

            if ($previous === null) {
                $streak = 1;
                $previous = $date;
                continue;
            }

            if ($previous->diffInDays($date) === 1) {
                $streak++;
                $previous = $date;
                continue;
            }

            break;
        }

        return $streak;
    }

    private function determineLevel(float $totalKilos, int $completedCount): array
    {
        return match (true) {
            $totalKilos >= 300 || $completedCount >= 40 => [
                'badge' => 'Embajador circular',
                'message' => '¡Impacto excepcional! Tu constancia inspira a toda la comunidad.',
            ],
            $totalKilos >= 150 || $completedCount >= 25 => [
                'badge' => 'Nivel Eco Avanzado',
                'message' => 'Gracias por mantener una rutina sostenible. ¡Sigamos sumando!',
            ],
            $totalKilos >= 60 || $completedCount >= 10 => [
                'badge' => 'Nivel Eco Intermedio',
                'message' => 'Cada aporte cuenta. Estás construyendo hábitos sólidos.',
            ],
            $totalKilos > 0 => [
                'badge' => 'Nivel Eco Inicial',
                'message' => 'Excelente comienzo. Programa tus próximas recolecciones para avanzar.',
            ],
            default => [
                'badge' => 'Bienvenida/o a Reciclapp',
                'message' => 'Programa tu primera recolección para ver aquí tus logros ambientales.',
            ],
        };
    }
}
