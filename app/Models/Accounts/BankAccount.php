<?php

namespace App\Models\Accounts;

use App\Models\RentInfo\OwnerInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccount extends Model
{
    use HasFactory, SoftDeletes;

    public function banks(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id')->withTrashed();
    }
    public function owners(): BelongsTo
    {
        return $this->belongsTo(OwnerInfo::class, 'owner_info_id', 'id')->withTrashed();
    }

}
