<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Widgets\TableWidget;


class LatestAttendanceWidget extends TableWidget
{
    protected static ?string $heading = 'Kehadiran Hari Ini';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';



    public function table(Table $table): Table
    {
        return $table
            ->query(
                Attendance::query()
                    ->with('user')
                    ->whereDate('attendance_date', Carbon::today())
                    ->latest('check_in_time')
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.employee_id')
                    ->label('ID Karyawan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('check_in_time')
                    ->label('Check-in')
                    ->dateTime('H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('check_out_time')
                    ->label('Check-out')
                    ->dateTime('H:i')
                    ->placeholder('-')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'on_time' => 'success',
                        'late' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'on_time' => 'Tepat Waktu',
                        'late' => 'Terlambat',
                        default => $state,
                    }),
            ])
            ->defaultSort('check_in_time', 'desc');
    }
}
