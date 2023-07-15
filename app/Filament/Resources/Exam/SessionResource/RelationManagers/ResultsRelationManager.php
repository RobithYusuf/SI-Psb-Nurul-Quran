<?php

namespace App\Filament\Resources\Exam\SessionResource\RelationManagers;

use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Contracts\Support\Htmlable;

class ResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'results';

    protected static ?string $recordTitleAttribute = null;

    protected static ?string $modelLabel = 'Hasil';

    protected function getTableHeading(): string|Htmlable|Closure|null
    {
        return 'Daftar Hasil Ujian';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Peserta'),
                Forms\Components\TextInput::make('score')
                    ->label('Nilai'),
                TableRepeater::make('answers')
                    ->disableLabel()
                    ->columnSpan(2)
                    ->columnWidths(['50%', '30%', '20%'])
                    ->schema([
                        Forms\Components\TextInput::make('question')->label('Soal')->disableLabel()->formatStateUsing(fn ($state) => strip_tags($state)),
                        Forms\Components\TextInput::make('answer')->label('Jawaban')->disableLabel(),
                        Forms\Components\TextInput::make('result')->label('Hasil')->disableLabel()->formatStateUsing(fn ($state) => $state ? '✅ Benar' : '❌ Salah')
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Peserta'),
                Tables\Columns\TextColumn::make('score')
                    ->label('Nilai'),
                Tables\Columns\TextColumn::make('session.minimum_score')
                    ->label('Minimal'),
                Tables\Columns\IconColumn::make('is_passed')
                    ->label('Lulus')
                    ->getStateUsing(fn ($record) => $record->score >= $record->session->minimum_score)
                    ->boolean()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading(fn ($record) => $record->score >= $record->session->minimum_score ? '✅ LULUS' : '❌ TIDAK LULUS'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
