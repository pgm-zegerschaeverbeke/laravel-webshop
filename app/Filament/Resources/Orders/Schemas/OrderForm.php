<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('number')
                    ->required(),
                TextInput::make('user_id')
                    ->numeric()
                    ->default(null),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'shipped' => 'Shipped',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->default(0.0)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($get, $set) {
                        $subtotal = floatval($get('subtotal') ?? 0);
                        $taxTotal = round($subtotal * 0.21, 2);
                        $set('tax_total', $taxTotal);
                        $set('grand_total', $subtotal + $taxTotal);
                    }),
                TextInput::make('tax_total')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->default(0.0)
                    ->readOnly()
                    ->dehydrated(),
                TextInput::make('grand_total')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->default(0.0)
                    ->readOnly()
                    ->dehydrated(),
                
                // Shipping Information
                TextInput::make('shipping_name')
                    ->label('Shipping Name')
                    ->maxLength(255),
                
                TextInput::make('shipping_email')
                    ->label('Shipping Email')
                    ->email()
                    ->maxLength(255),
                
                TextInput::make('shipping_address')
                    ->label('Shipping Address (Street)')
                    ->maxLength(500),
                
                TextInput::make('shipping_postal_code')
                    ->label('Shipping Postal Code')
                    ->maxLength(20),
                
                TextInput::make('shipping_city')
                    ->label('Shipping City')
                    ->maxLength(255),
                
                TextInput::make('shipping_country')
                    ->label('Shipping Country')
                    ->maxLength(255),
            ]);
    }
}
