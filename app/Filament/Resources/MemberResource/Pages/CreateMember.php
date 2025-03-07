<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use App\Models\Member;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateMember extends CreateRecord
{
    protected static string $resource = MemberResource::class;


    protected function handleRecordCreation(array $data): Member
    {
        $data['password'] = Hash::make($data['password']); // Hash the password
        return static::getModel()::create($data);
    }
}
