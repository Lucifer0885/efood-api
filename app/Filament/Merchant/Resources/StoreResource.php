<?php

namespace App\Filament\Merchant\Resources;

use App\Filament\Merchant\Resources\StoreResource\Pages;
use App\Filament\Merchant\Resources\StoreResource\RelationManagers;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use ArberMustafa\FilamentLocationPickrField\Forms\Components\LocationPickr;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'building-storefront';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->user()->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic information')
                ->aside()
                ->description("Name, address, category, phone...")
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->translatable(),
                    Forms\Components\TextInput::make('address')
                        ->required()
                        ->translatable(),
                    Forms\Components\Select::make('categories')
                        ->preload()
                        ->multiple()
                        ->relationship(titleAttribute: 'name'),
                    Forms\Components\TextInput::make('phone')
                        ->tel(),
                ]),
                Forms\Components\Section::make('Operating information')
                ->aside()
                ->description("Minimum cart value, working hours, etc...")
                ->schema([
                    Forms\Components\TextInput::make('minimum_cart_value')
                        ->numeric()
                        ->minValue(0)
                        ->suffix('€'),
                    Forms\Components\TextInput::make('delivery_range')
                        ->numeric()
                        ->minValue(0)
                        ->suffix('km'),
                    Forms\Components\TextInput::make('working_hours')
                ]),
                Forms\Components\Section::make('Location')
                ->aside()
                ->description("Drag the marker to set the store's location")
                ->schema([
                    LocationPickr::make('location')
                        ->defaultLocation(config('filament-locationpickr-field.default_location'))
                        ->defaultZoom(config('filament-locationpickr-field.default_zoom'))
                        ->height(config('filament-locationpickr-field.default_height'))
                        ->draggable(),
                ]),
                Forms\Components\Section::make('Photos')
                ->aside()
                ->description("Add a logo and a cover photo")
                ->schema([
                    SpatieMediaLibraryFileUpload::make('logo')
                    ->collection('logo'),
                    SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('cover'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('logo')
                    ->collection("logo"),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('categories.name')
                    ->limitList(3),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('minimum_cart_value')
                    ->money("EUR"),
                Tables\Columns\TextColumn::make('delivery_range')
                    ->suffix(" km"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}
