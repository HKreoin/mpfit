<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [
            EditAction::make(),
        ];

       if ($this->record->status === 'новый') {
           $actions[] = Action::make('complete')
               ->label('Выполнить')
               ->icon('heroicon-o-check')
               ->color('success')
               ->action (function () {
                   $this->record->update(['status' => 'выполнен']);
                   $this->redirect(static::getUrl(['record' => $this->record]));
               });
       }

        return $actions;
    }
}
