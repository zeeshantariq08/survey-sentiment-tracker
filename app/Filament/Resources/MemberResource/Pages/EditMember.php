<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Google\Model;
use Illuminate\Support\Facades\Hash;

class EditMember extends EditRecord
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']); // Hash password only if changed
        } else {
            unset($data['password']); // Prevent overwriting existing password with null
        }

        $record->update($data);
        return $record;
    }
}
