<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderItemsRelationManager extends RelationManager
{
  protected static string $relationship = 'items';

  public function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        Select::make('product_id')
          ->label('Product')
          ->relationship('product', 'title')
          ->required()
          ->searchable()
          ->preload(),

        TextInput::make('qty')
          ->label('Quantity')
          ->required()
          ->numeric()
          ->default(1)
          ->minValue(1),

        TextInput::make('unit_price')
          ->label('Unit Price')
          ->required()
          ->numeric()
          ->prefix('$')
          ->default(0),

        TextInput::make('line_total')
          ->label('Line Total')
          ->required()
          ->numeric()
          ->prefix('$')
          ->default(0),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('product.title')
      ->columns([
        TextColumn::make('product.title')
          ->label('Product')
          ->searchable()
          ->sortable(),

        TextColumn::make('qty')
          ->label('Quantity')
          ->sortable(),

        TextColumn::make('unit_price')
          ->label('Unit Price')
          ->money()
          ->sortable(),

        TextColumn::make('line_total')
          ->label('Line Total')
          ->money()
          ->sortable(),

        TextColumn::make('created_at')
          ->label('Added')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->headerActions([
        CreateAction::make(),
      ])
      ->recordActions([
        EditAction::make(),
        DeleteAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
