<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class ReviewsRelationManager extends RelationManager
{
  protected static string $relationship = 'reviews';

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('title')
      ->columns([
        TextColumn::make('user.email')
          ->label('User')
          ->searchable(),
        TextColumn::make('rating')
          ->label('Rating')
          ->sortable(),
        TextColumn::make('title')
          ->label('Title')
          ->searchable(),
        TextColumn::make('body')
          ->label('Review')
          ->limit(50),
        TextColumn::make('created_at')
          ->label('Created')
          ->dateTime()
          ->sortable(),
      ])
      ->recordActions([
        EditAction::make(),
        DeleteAction::make(),
      ]);
  }
}
