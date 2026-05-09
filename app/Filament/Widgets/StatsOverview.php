<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today = Carbon::today();
        $totalEmployees = User::where('role', 'employee')->count();

        $attendanceToday = Attendance::whereDate('attendance_date', $today);
        $presentToday = $attendanceToday->count();
        $lateToday = (clone $attendanceToday)->where('status', 'late')->count();
        $onTimeToday = (clone $attendanceToday)->where('status', 'on_time')->count();
        $notCheckedIn = $totalEmployees - $presentToday;

        return [
            Stat::make('Total Karyawan', $totalEmployees)
                ->description('Karyawan Terdaftar')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Hadir Hari Ini', $presentToday)
                ->description("{$onTimeToday} Tepat Waktu, {$lateToday} Terlambat")
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Belum Absen', $notCheckedIn)
                ->description('Hari Ini')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}
