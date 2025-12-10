<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Automatically set role based on is_admin
        $data['name'] = ($data['is_admin'] ?? false) ? 'admin' : 'customer';
        
        return $data;
    }
}
