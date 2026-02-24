<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ApplicationResource\Pages;
use App\Filament\Admin\Resources\ApplicationResource\RelationManagers;
use App\Models\Application;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('institution_id')
                    ->relationship('institution', 'name')
                    ->disabled(),

                Forms\Components\TextInput::make('name')
                    ->disabled(),

                Forms\Components\TextInput::make('phone')
                    ->disabled(),

                Forms\Components\TextInput::make('email')
                    ->disabled(),

                Forms\Components\Textarea::make('message')
                    ->disabled(),

                Forms\Components\Select::make('status')
                    ->options([
                        'new' => 'New',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('institution.name')
                    ->label('Institution')
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')->searchable(),

                Tables\Columns\TextColumn::make('phone'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'new',
                        'info' => 'in_progress',
                        'success' => 'completed',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                    ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole('partner')) {
            return parent::getEloquentQuery()
                ->whereHas('institution.users', function ($q) use ($user) {
                    $q->where('users.id', $user->id);
                });
        }

        return parent::getEloquentQuery();
    }

    public static function canCreate(): bool
    {
        return false; // заявки создаёт только фронт
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->hasRole('superadmin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['partner', 'admin', 'superadmin']);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
