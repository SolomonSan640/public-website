<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutPageMmResource\Pages;
use App\Models\AboutPageMM;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutPageMmResource extends Resource
{
    protected static ?string $model = AboutPageMM::class;
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationGroup = 'Contents (Myanmar)';
    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        $recordCount = AboutPageMM::count();
        if ($recordCount < 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Card 1')->schema([
                    Forms\Components\TextInput::make('title_1')
                        ->maxLength(255)
                        ->required(),
                ]),
                Section::make('Card 2')->schema([
                    Forms\Components\TextInput::make('title_2')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('content_2'),
                    Forms\Components\FileUpload::make('image_2')->directory('/images')->image(),
                ]),
                Section::make('Card 3')->schema([
                    Forms\Components\FileUpload::make('image_3')->directory('/images')->image(),
                ]),
                Section::make('Card 4')->schema([
                    Forms\Components\FileUpload::make('image_4')->directory('/images')->image(),
                ]),
                Section::make('Card 5')->schema([
                    Forms\Components\FileUpload::make('image_5')->directory('/images')->image(),
                ]),
                Section::make('Card 6')->schema([
                    Forms\Components\FileUpload::make('image_6')->directory('/images')->image(),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_1')
                    ->label('Title')
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
            'index' => Pages\ListAboutPageMms::route('/'),
            'create' => Pages\CreateAboutPageMm::route('/create'),
            'view' => Pages\ViewAboutPageMm::route('/{record}'),
            'edit' => Pages\EditAboutPageMm::route('/{record}/edit'),
        ];
    }
}
