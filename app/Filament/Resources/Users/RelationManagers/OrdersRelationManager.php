<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class OrdersRelationManager extends RelationManager
{
  protected static string $relationship = 'orders';

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('number')
      ->columns([
        TextColumn::make('number')
          ->label('Order Number')
          ->searchable()
          ->sortable(),
        TextColumn::make('status')
          ->label('Status')
          ->sortable(),
        TextColumn::make('subtotal')
          ->label('Subtotal')
          ->money()
          ->sortable(),
        TextColumn::make('tax_total')
          ->label('Tax')
          ->money()
          ->sortable(),
        TextColumn::make('grand_total')
          ->label('Grand Total')
          ->money()
          ->sortable(),
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
