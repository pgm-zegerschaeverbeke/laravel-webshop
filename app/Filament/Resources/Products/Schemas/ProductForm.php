<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Toggle::make('is_available')
                    ->required()
                    ->label('Available'),
                Toggle::make('is_featured')
                    ->label('Featured')
                    ->default(false),
                TextInput::make('category_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('brand_id')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
