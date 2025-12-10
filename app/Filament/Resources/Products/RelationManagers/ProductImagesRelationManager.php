<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ProductImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('url')
                    ->label('Image')
                    ->image()
                    ->directory('images')
                    ->disk('public')
                    ->visibility('public')
                    ->required()
                    ->maxSize(5120) // 5MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->helperText('Upload an image file (max 5MB). Supported formats: JPEG, PNG, WebP, GIF.')
                    // When loading for editing, get raw value (without 'storage/' prefix) for Filament
                    ->default(fn ($record) => $record && $record->getRawOriginal('url') 
                        ? str_replace('storage/', '', $record->getRawOriginal('url')) 
                        : null),

                TextInput::make('alt_text')
                    ->label('Alt text')
                    ->maxLength(255)
                    ->helperText('Alternative text for accessibility'),

                Toggle::make('is_primary')
                    ->label('Primary image')
                    ->default(false)
                    ->helperText('Mark this as the primary product image'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('url')
            ->columns([
                ImageColumn::make('url')
                    ->label('Preview')
                    ->square()
                    ->disk('public')
                    ->getStateUsing(fn ($record) => $record->getRawOriginal('url'))
                    ->defaultImageUrl(asset('images/placeholder.jpg')),
                TextColumn::make('alt_text')
                    ->label('Alt text')
                    ->limit(30),
                IconColumn::make('is_primary')
                    ->label('Primary')
                    ->boolean(),
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
