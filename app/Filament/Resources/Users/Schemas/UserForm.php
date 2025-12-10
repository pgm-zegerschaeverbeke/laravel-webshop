<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('name')
                    ->label('Role')
                    ->options([
                        'customer' => 'Customer',
                        'admin' => 'Admin',
                    ])
                    ->default('customer')
                    ->required()
                    ->afterStateHydrated(function ($state, $record, $set) {
                        // Set dropdown value based on is_admin when loading existing record
                        if ($record) {
                            $set('name', $record->is_admin ? 'admin' : 'customer');
                        }
                    })
                    ->afterStateUpdated(function ($state, $set) {
                        $set('is_admin', $state === 'admin');
                    })
                    ->live()
                    ->helperText('Select the role for this user.'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('first_name')
                    ->default(null),
                TextInput::make('last_name')
                    ->default(null),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                    ->required(fn(string $operation) => $operation === 'create')
                    ->dehydrated(fn($state) => filled($state))
                    ->helperText('Leave blank to keep current password.'),
                Toggle::make('is_admin')
                    ->required()
                    ->afterStateUpdated(function ($state, $set) {
                        $set('name', $state ? 'admin' : 'customer');
                    })
                    ->live(),
            ]);
    }
}
