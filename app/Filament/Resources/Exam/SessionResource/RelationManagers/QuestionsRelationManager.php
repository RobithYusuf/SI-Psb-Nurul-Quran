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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $recordTitleAttribute = null;

    protected static ?string $modelLabel = 'Soal';

    protected function getTableHeading(): string|Htmlable|Closure|null
    {
        return 'Daftar Soal';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\RichEditor::make('question')
                    ->label('Soal')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('points')
                    ->label('Bobot Soal')
                    ->extraAttributes(['style' => 'max-width:100px'])
                    ->default(10)
                    ->numeric()
                    ->required(),
                TableRepeater::make('options')
                    ->label('Pilihan Jawaban')
                    ->columnWidths(['80%', '20%'])
                    ->schema([
                        Forms\Components\TextInput::make('option')
                            ->label('Jawaban')
                            ->disableLabel()
                            ->required(),
                        Forms\Components\Toggle::make('is_correct')
                            ->label('Benar?')
                            ->offIcon('heroicon-s-x')
                            ->onIcon('heroicon-s-check')
                            ->onColor('success')
                            ->disableLabel(),
                    ])
                    ->columns(2)
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label('Soal')
                    ->html(),
                Tables\Columns\TagsColumn::make('options')
                    ->label('Jawaban')
                    ->getStateUsing(function ($record) {
                        $opts = [];

                        foreach ($record->options as $option) {
                            if ($option['is_correct']) {
                                $opts[] = "{$option['option']} ✅";
                            } else {
                                $opts[] = $option['option'];
                            }

                        }
                        return $opts;
                    })
            ])
            ->reorderable('sort')
            ->defaultSort('sort')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Buat Soal'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
