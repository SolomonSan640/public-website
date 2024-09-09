<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SubCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubCategoryResource\Pages;
use App\Filament\Resources\SubCategoryResource\RelationManagers;

class SubCategoryResource extends Resource
{
    protected static ?string $model = SubCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Product';
    protected static ?int $navigationSort = 2;
    protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sub Category Details')->schema([
                    Forms\Components\Select::make('category')
                        ->relationship('category', 'name_en')
                        ->searchable()
                        ->columnSpanFull()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('name_en')
                        ->label('Name (English)')
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
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
                        ->default(1)
                        ->required(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Sub Category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name_en')
                    ->label('Name (English)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description_en')
                    ->label('Description (English)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('remark_en')
                    ->label('Remark (English)')
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
            'index' => Pages\ListSubCategories::route('/'),
            'create' => Pages\CreateSubCategory::route('/create'),
            'view' => Pages\ViewSubCategory::route('/{record}'),
            'edit' => Pages\EditSubCategory::route('/{record}/edit'),
        ];
    }
}
