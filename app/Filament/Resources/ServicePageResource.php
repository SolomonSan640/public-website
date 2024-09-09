<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicePageResource\Pages;
use App\Models\ServicePage;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServicePageResource extends Resource
{
    protected static ?string $model = ServicePage::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Contents (English)';
    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        $recordCount = ServicePage::count();
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
                ]),
                Section::make('Card 3')->schema([
                    Forms\Components\TextInput::make('title_3')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('content_3'),
                    Forms\Components\FileUpload::make('image_3')->directory('/images')->image(),
                ]),
                Section::make('Card 4')->schema([
                    Forms\Components\TextInput::make('title_4')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('content_4'),
                    Forms\Components\FileUpload::make('image_4')->directory('/images')->image(),
                ]),
                Section::make('Card 5')->schema([
                    Forms\Components\TextInput::make('title_5')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('content_5'),
                    Forms\Components\FileUpload::make('image_5')->directory('/images')->image(),
                ]),
                Section::make('Card 6')->schema([
                    Forms\Components\TextInput::make('title_6')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('content_6'),
                    Forms\Components\FileUpload::make('image_6')->directory('/images')->image(),
                ]),
                Section::make('Card 7')->schema([
                    Forms\Components\TextInput::make('title_7')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('content_7'),
                    Forms\Components\FileUpload::make('image_7')->directory('/images')->image(),
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
            'index' => Pages\ListServicePages::route('/'),
            'create' => Pages\CreateServicePage::route('/create'),
            'view' => Pages\ViewServicePage::route('/{record}'),
            'edit' => Pages\EditServicePage::route('/{record}/edit'),
        ];
    }
}
