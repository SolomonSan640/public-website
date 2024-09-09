<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Country;
use App\Models\Regional;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ServiceArea;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NorthAmericaResource\Pages;

class NorthAmericaResource extends Resource
{
    protected static ?string $model = ServiceArea::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Service Area';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'North America';

    public static function getLabel(): ?string
    {
        return 'North America';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Asia Pacific Detail')->schema([
                    Forms\Components\Select::make('country_id')
                        ->label('Country')
                        ->options(Country::all()->pluck('name_en', 'id'))
                        ->unique(ignoreRecord: true)
                        ->preload()
                        ->searchable()
                        ->required(),
                    Forms\Components\Select::make('regional_id')
                        ->label('Region')
                        ->options(Regional::all()->pluck('name', 'id'))
                        ->preload()
                        ->default(4)
                        ->disabled()
                        ->searchable()
                        ->required(),
                    Hidden::make('regional_id')
                        ->default(4),
                    Forms\Components\Toggle::make('is_show')
                        ->default(1)
                        ->required(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('regional.name')
                    ->label('Region (English)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country.name_en')
                    ->label('Country (English)')
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
            'index' => Pages\ListNorthAmericas::route('/'),
            'create' => Pages\CreateNorthAmerica::route('/create'),
            'view' => Pages\ViewNorthAmerica::route('/{record}'),
            'edit' => Pages\EditNorthAmerica::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('regional_id', '=', 3);
    }
}
