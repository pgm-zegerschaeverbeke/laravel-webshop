<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class FavoritesRelationManager extends RelationManager
{
  protected static string $relationship = 'favorites';

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('title')
      ->columns([
        TextColumn::make('title')
          ->label('Product')
          ->searchable(),
        TextColumn::make('price')
          ->label('Price')
          ->money(),
      ]);
  }
}
