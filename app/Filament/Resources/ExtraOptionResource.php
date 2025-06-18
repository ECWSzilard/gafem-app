<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtraOptionResource\Pages;
use App\Filament\Resources\ExtraOptionResource\RelationManagers;
use App\Models\ExtraOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExtraOptionResource extends Resource
{
    protected static ?string $model = ExtraOption::class;

    protected static ?string $label = 'Extra opció';
    protected static ?string $pluralLabel = 'Extra opciók';
    protected static ?string $navigationIcon = 'heroicon-o-percent-badge';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Adatok')
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Megnevezés'),
                        Forms\Components\Toggle::make('is_visible')
                            ->label('Látható')
                            ->onColor('success')
                            ->offColor('danger'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Megnevezés')->searchable(),
                Tables\Columns\ToggleColumn::make('is_visible')->onColor('success')->offColor('danger')->label('Látható')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExtraOptions::route('/'),
            /* 'create' => Pages\CreateExtraOption::route('/create'),
             'edit' => Pages\EditExtraOption::route('/{record}/edit'),*/
        ];
    }
}
