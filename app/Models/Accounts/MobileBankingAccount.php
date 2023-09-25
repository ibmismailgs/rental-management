<?php

namespace App\Models\Accounts;

use App\Models\RentInfo\OwnerInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MobileBankingAccount extends Model
{
    use HasFactory, SoftDeletes;

    public function mobileBankings(): BelongsTo
    {
        return $this->belongsTo(MobileBanking::class, 'mobile_banking_id', 'id')->withTrashed();
    }
    public function owners(): BelongsTo
    {
        return $this->belongsTo(OwnerInfo::class, 'owner_info_id', 'id')->withTrashed();
    }
}
