<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\DeleteAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CartsRelationManager extends RelationManager
{
    protected static string $relationship = 'carts';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->label('Cart ID')
                    ->sortable(),
                
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'checked_out' => 'info',
                        'abandoned' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                
                TextColumn::make('items_summary')
                    ->label('Items')
                    ->getStateUsing(function ($record) {
                        if ($record->items->isEmpty()) {
                            return 'Empty';
                        }
                        return $record->items->map(function ($item) {
                            $productName = $item->product->title ?? 'Unknown';
                            return "{$productName} (×{$item->qty})";
                        })->join(', ');
                    })
                    ->wrap()
                    ->limit(50),
                
                TextColumn::make('items_count')
                    ->label('Item Count')
                    ->counts('items')
                    ->sortable(),
                
                TextColumn::make('total_items_qty')
                    ->label('Total Qty')
                    ->getStateUsing(function ($record) {
                        return $record->items->sum('qty');
                    })
                    ->sortable(),
                
                TextColumn::make('total_value')
                    ->label('Total Value')
                    ->getStateUsing(function ($record) {
                        return $record->items->sum(fn($item) => $item->qty * $item->unit_price);
                    })
                    ->money('EUR')
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                DeleteAction::make(),
            ])
            ->modifyQueryUsing(function ($query) {
                $query->with('items.product');
            });
    }
}

