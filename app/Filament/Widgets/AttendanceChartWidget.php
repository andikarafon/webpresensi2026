<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class AttendanceChartWidget extends ChartWidget
{
    protected ?string $heading = 'Statistik Kehadiran 30 Hari Terakhir';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {

        $data = collect();
        $labels = collect();
        $lateData = collect();
        $onTimeData = collect();

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels->push($date->format('d M'));

            $dayAttendance = Attendance::whereDate('attendance_date', $date);
            $onTimeData->push((clone $dayAttendance)->where('status', 'on_time')->count());
            $lateData->push((clone $dayAttendance)->where('status', 'late')->count());
        }
        return [
            'labels' => $labels->toArray(),
            'datasets' => [
                [
                    'label' => 'Tepat Waktu',
                    'data' => $onTimeData->toArray(),
                    'backgroundColor' => '#10B981',
                    'borderColor' => '#10B981',
                ],
                [
                    'label' => 'Terlambat',
                    'data' => $lateData->toArray(),
                    'backgroundColor' => '#EF4444',
                    'borderColor' => '#EF4444',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
