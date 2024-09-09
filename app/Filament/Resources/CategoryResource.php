<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryResource\RelationManagers;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Product';
    protected static ?int $navigationSort = 1;
    protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Category Details')->schema([
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
                    Forms\Components\RichEditor::make('description_en')
                        ->label('Description (English)'),
                    Forms\Components\RichEditor::make('remark_en')
                        ->label('Remark (English)'),
                    Forms\Components\RichEditor::make('description_mm')
                        ->label('Description (Myanmar)'),
                    Forms\Components\RichEditor::make('remark_mm')
                        ->label('Remark (Myanmar)'),
                    Forms\Components\RichEditor::make('description_th')
                        ->label('Description (Thailand)'),
                    Forms\Components\RichEditor::make('remark_th')
                        ->label('Remark (Thailand)'),
                    Forms\Components\RichEditor::make('description_kr')
                        ->label('Description (Korea)'),
                    Forms\Components\RichEditor::make('remark_kr')
                        ->label('Remark (Korea)'),
                    Forms\Components\Toggle::make('is_show')
                        ->required()
                        ->default(1),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name (English)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description_en')
                    ->label('Description (English)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('remark_en')
                    ->label('Remark (English)')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_show')
                    ->label('show')
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
