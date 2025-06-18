<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IceCreamResource\Pages;
use App\Filament\Resources\IceCreamResource\RelationManagers;
use App\Models\IceCream;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IceCreamResource extends Resource
{
    protected static ?string $model = IceCream::class;

    protected static ?string $label = 'Fagylalt';
    protected static ?string $pluralLabel = 'Fagylaltok';

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';

    protected static ?int $navigationSort = 5;

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
                            ->label('Termék neve'),
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
                Tables\Columns\TextColumn::make('name')->label('Termék neve')->searchable(),
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
            'index' => Pages\ListIceCreams::route('/'),
           /* 'create' => Pages\CreateIceCream::route('/create'),
            'edit' => Pages\EditIceCream::route('/{record}/edit'),*/
        ];
    }
}
