<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\NrcTownship;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NrcTownshipResource\Pages;
use App\Filament\Resources\NrcTownshipResource\RelationManagers;

class NrcTownshipResource extends Resource
{
    protected static ?string $model = NrcTownship::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Idenfications';
    protected static ?int $navigationSort = 4;
    protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Nrc Township Details')->schema([
                    Forms\Components\Select::make('nrc_code_id')
                        ->relationship('nrcCode', 'name_en')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('township_id')
                        ->relationship('township', 'name_en')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nrcCode.name_en')
                    ->label('NRC Code (English)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('township.name_en')
                    ->label('NRC Township (Enlgish)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->outlined()->button(),
                Tables\Actions\EditAction::make()->outlined()->button(),
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
            'index' => Pages\ListNrcTownships::route('/'),
            'create' => Pages\CreateNrcTownship::route('/create'),
            'view' => Pages\ViewNrcTownship::route('/{record}'),
            'edit' => Pages\EditNrcTownship::route('/{record}/edit'),
        ];
    }
}
