<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServingResource\Pages;
use App\Filament\Resources\ServingResource\RelationManagers;
use App\Models\Serving;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServingResource extends Resource
{
    protected static ?string $model = Serving::class;

    protected static ?string $label = 'Talalás típus';
    protected static ?string $pluralLabel = 'Talalás típusok';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    protected static ?int $navigationSort = 3;

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
            'index' => Pages\ListServings::route('/'),
           /* 'create' => Pages\CreateServing::route('/create'),
            'edit' => Pages\EditServing::route('/{record}/edit'),*/
        ];
    }
}
