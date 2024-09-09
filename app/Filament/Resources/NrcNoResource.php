<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\NrcNo;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NrcNoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NrcNoResource\RelationManagers;

class NrcNoResource extends Resource
{
    protected static ?string $model = NrcNo::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Idenfications';
    protected static ?int $navigationSort = 6;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Nrc Township Details')->schema([
                    Forms\Components\Select::make('nrc_type_id')
                        ->relationship('nrcType.nrcTownship.nrcCode', 'name')
                        ->label('Nrc Code')
                        ->required(),
                    Forms\Components\Select::make('nrc_type_id')
                        ->relationship('nrcType.nrcTownship.township', 'name')
                        ->label('Nrc Township Name')
                        ->required(),
                    Forms\Components\Select::make('nrc_type_id')
                        ->relationship('nrcType', 'name')
                        ->label('Nrc Township Name')
                        ->required(),
                    Forms\Components\TextInput::make('name')
                        ->label('Nrc Number')
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListNrcNos::route('/'),
            'create' => Pages\CreateNrcNo::route('/create'),
            'view' => Pages\ViewNrcNo::route('/{record}'),
            'edit' => Pages\EditNrcNo::route('/{record}/edit'),
        ];
    }
}
