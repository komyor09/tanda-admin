<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\InstitutionResource\Pages;
use App\Filament\Admin\Resources\InstitutionResource\RelationManagers;
use App\Models\Institution;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class InstitutionResource extends Resource
{
    protected static ?string $model = Institution::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'school' => 'School',
                        'kindergarten' => 'Kindergarten',
                        'agency' => 'Agency',
                        'prep_center' => 'Prep Center',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('city')
                    ->required(),

                Forms\Components\TextInput::make('address'),

                Forms\Components\TextInput::make('price_month')
                    ->numeric(),

                Forms\Components\Textarea::make('description'),

                Forms\Components\Toggle::make('status'),

                Forms\Components\Toggle::make('featured'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('type')->badge(),
                Tables\Columns\TextColumn::make('city')->searchable(),
                Tables\Columns\IconColumn::make('status')->boolean(),
                Tables\Columns\IconColumn::make('featured')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'school' => 'School',
                        'kindergarten' => 'Kindergarten',
                        'agency' => 'Agency',
                        'prep_center' => 'Prep Center',
                    ])
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole('partner')) {
            return parent::getEloquentQuery()
                ->whereIn('institutions.id', $user->institutions()->pluck('institutions.id'));
        }

        return parent::getEloquentQuery();
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->hasRole('superadmin');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->hasAnyRole(['admin', 'superadmin']);
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
            'index' => Pages\ListInstitutions::route('/'),
            'create' => Pages\CreateInstitution::route('/create'),
            'edit' => Pages\EditInstitution::route('/{record}/edit'),
        ];
    }
}
