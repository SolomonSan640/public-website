<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\NrcCode;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NrcCodeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NrcCodeResource\RelationManagers;

class NrcCodeResource extends Resource
{
    protected static ?string $model = NrcCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Idenfications';
    protected static ?int $navigationSort = 3;
    protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Nrc Code Details')->schema([
                    Forms\Components\TextInput::make('name_en')
                        ->maxLength(255)
                        ->label('NRC Code (English)')
                        ->placeholder('e.g. for 1/ , 2/')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('name_mm')
                        ->maxLength(255)
                        ->label('NRC Code (Myanmar)')
                        ->placeholder('e.g. for ၁/ , ၂/')
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->label('NRC code (English)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_mm')
                    ->label('NRC code (Myanmar)')
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
            'index' => Pages\ListNrcCodes::route('/'),
            'create' => Pages\CreateNrcCode::route('/create'),
            'view' => Pages\ViewNrcCode::route('/{record}'),
            'edit' => Pages\EditNrcCode::route('/{record}/edit'),
        ];
    }
}
