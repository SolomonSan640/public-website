<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactPageResource\Pages;
use App\Models\ContactPage;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactPageResource extends Resource
{
    protected static ?string $model = ContactPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationGroup = 'Contents (English)';
    protected static ?int $navigationSort = 5;

    public static function canCreate(): bool
    {
        $recordCount = ContactPage::count();
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
                    Forms\Components\RichEditor::make('content_1'),
                ]),
                Section::make('Card 3')->schema([
                    Forms\Components\TextInput::make('title_2')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('content_2'),
                ]),
                Section::make('Card 4')->schema([
                    Forms\Components\TextInput::make('title_3')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('content_3'),
                ]),
                Section::make('Card 5')->schema([
                    Forms\Components\TextInput::make('title_4')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('content_4'),
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
            'index' => Pages\ListContactPages::route('/'),
            'create' => Pages\CreateContactPage::route('/create'),
            'view' => Pages\ViewContactPage::route('/{record}'),
            'edit' => Pages\EditContactPage::route('/{record}/edit'),
        ];
    }
}
