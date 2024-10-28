<?php

namespace App\Filament\Resources\BookingTransactionResource\Pages;

use App\Filament\Resources\BookingTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookingTransaction extends EditRecord
{
    protected static string $resource = BookingTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateDataBeforeFill(array $data): array
    {
        $data['participant']= $this->record->participant->map(function($participant){
            return[
                'name' => $participanr->name,
                'occupation'=>$participant->occupation,
                'email' => $participant->email,
            ];
        })->toArray();

        return $data;
    }

    protected function afterSave():void 
    {
    DB::transaction(function(){
        $record = $this->record;
        $record->participants()->delete();
        $participants = $this->form->getState()['participants'];

        foreach ($participants as $participant){
            WorkshopParticipant::create([
                'workshop_id '=> $record->workshop_id,
                'booking_trasaction_id '=> $record_id,
                'name' =>$participant['name'],
                'occupation' =>$participant['occupation'],
                'email' =>$participant['email'],
            ]);
        }
    });
    }
}
