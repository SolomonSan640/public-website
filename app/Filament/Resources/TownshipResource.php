<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Township;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TownshipResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TownshipResource\RelationManagers;

class TownshipResource extends Resource
{
    protected static ?string $model = Township::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationGroup = 'Locations';
    protected static ?int $navigationSort = 3;
    protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Township Details')->schema([
                    Forms\Components\Select::make('city')
                        ->relationship('city', 'name_en')
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\TextInput::make('name_en')
                        ->label('Name (English)')
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->required(),
                    Forms\Components\TextInput::make('name_mm')
                        ->label('Name (Myanmar)')
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->requiredWithout('name_en'),
                    Forms\Components\TextInput::make('name_th')
                        ->label('Name (Thailand)')
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->requiredWithout('name_en'),
                    Forms\Components\TextInput::make('name_kr')
                        ->label('Name (Korea)')
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->requiredWithout('name_en'),
                    Forms\Components\TextInput::make('short_name_en')
                        ->label('Short Name (English)')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('short_name_mm')
                        ->label('Short Name (Myanmar)')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('latitude')
                        ->numeric()
                        ->inputMode('decimal')
                        ->columnSpan(3)
                        ->minValue(0)
                        ->required(),
                    Forms\Components\TextInput::make('longitude')
                        ->numeric()
                        ->columnSpan(3)
                        ->inputMode('decimal')
                        ->minValue(0)
                        ->required(),
                    Forms\Components\Toggle::make('is_show')
                        ->default(1)
                        ->required()
                        ->columnSpan(2),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city.name_en')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_show')
                    ->label('Show')
                    ->boolean(),
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
            'index' => Pages\ListTownships::route('/'),
            'create' => Pages\CreateTownship::route('/create'),
            'view' => Pages\ViewTownship::route('/{record}'),
            'edit' => Pages\EditTownship::route('/{record}/edit'),
        ];
    }
}
