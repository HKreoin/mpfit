<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Заказы';
    protected static ?string $modelLabel = 'Заказ';
    protected static ?string $pluralModelLabel = 'Заказы';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('customer_name')
                    ->label('ФИО покупателя')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(['md' => 2]),
                Select::make('product_id')
                    ->label('Товар')
                    ->relationship('product', 'name')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        if ($state && $get('quantity')) {
                            $product = Product::find($state);
                            $set('total_price', $product->price * $get('quantity'));
                        }
                    }),
                TextInput::make('quantity')
                    ->label('Количество')
                    ->numeric()
                    ->required()
                    ->default(1)
                    ->minValue(1)
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        if ($state && $get('product_id')) {
                            $product = Product::find($get('product_id'));
                            $set('total_price', $product->price * $state);
                        }
                    }),
                TextInput::make('total_price')
                    ->label('Итоговая сумма (руб.)')
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
                    ->prefix('₽'),
                Select::make('status')
                    ->label('Статус')
                    ->options([
                        'новый' => 'Новый',
                        'выполнен' => 'Выполнен',
                    ])
                    ->default('новый')
                    ->required(),
                TextArea::make('comment')
                    ->label('Комментарий покупателя')
                    ->rows(3)
                    ->columnSpan(['md' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('№ заказа')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('customer_name')
                    ->label('ФИО покупателя')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->colors([
                        'warning' => 'новый',
                        'success' => 'выполнен',
                    ]),
                TextColumn::make('total_price')
                    ->label('Итоговая цена')
                    ->money('RUB')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                ->options([
                    'новый' => 'Новый',
                    'выполнен' => 'Выполнен',
                ])

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('complete')
                    ->label('Выполнить')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action (fn (Order $record) => $record->update(['status' => 'выполнен']))
                    ->visible(fn (Order $record) => $record->status === 'новый'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
