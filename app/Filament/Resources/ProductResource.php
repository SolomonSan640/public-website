<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Product';
    protected static ?int $navigationSort = 3;
    protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Product Details')->schema([
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
                    Forms\Components\Select::make('country_id')
                        ->label('Product Origin')
                        ->relationship('country', 'name_en')
                        ->required(),
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name_en')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('sub_category_id')
                        ->relationship('subCategory', 'name_en')
                        ->searchable()
                        ->preload(),
                    Forms\Components\TextInput::make('sku')
                        ->label('SKU')
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\Select::make('unit')
                        ->options([
                            'kg' => 'kg',
                            'g' => 'g',
                            'lb' => 'lb',
                        ])
                        ->searchable()
                        ->required(),
                    Forms\Components\TextInput::make('quantity')
                        ->minValue(0)
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('price')
                        ->minValue(0)
                        ->numeric()
                        ->required(),
                ])->columns(3),

                Section::make('Product Notes')->schema([
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
                    ->label('Product Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country.name_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subCategory.name_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description_en')
                    ->label('Description (English)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('remark_en')
                    ->label('Remark (English)')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_show')
                    ->label('Show')
                    ->default(1)
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
