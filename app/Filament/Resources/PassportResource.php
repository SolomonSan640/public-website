<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Passport;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PassportResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PassportResource\RelationManagers;

class PassportResource extends Resource
{
    protected static ?string $model = Passport::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Idenfications';
    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Passport Details')->schema([
                    Forms\Components\Select::make('country_id')
                        ->relationship('passportCode', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('user.name')
                        ->maxLength(255)
                        ->label('User Name')
                        ->default(
                            function () {
                                return Filament::auth()->user()->id;
                            }
                        )
                        ->label('user.name')
                        ->readOnly()
                        // ->hidden()
                        ->required(),
                    Forms\Components\DatePicker::make('issue_date')
                        ->closeOnDateSelection()
                        ->required(),
                    Forms\Components\DatePicker::make('expire_date')
                        ->closeOnDateSelection()
                        ->afterOrEqual('issue_date')
                        ->required(),
                    Forms\Components\TextInput::make('passport_number')
                        ->maxLength(255)
                        ->numeric()
                        ->required(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('passportCode.name')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('passport_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('issue_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expire_date')
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
            'index' => Pages\ListPassports::route('/'),
            'create' => Pages\CreatePassport::route('/create'),
            'view' => Pages\ViewPassport::route('/{record}'),
            'edit' => Pages\EditPassport::route('/{record}/edit'),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
