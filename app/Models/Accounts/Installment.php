<?php

namespace App\Models\Accounts;

use App\Models\RentInfo\RentInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Installment extends Model
{
    use HasFactory, SoftDeletes;

    public function rents(): BelongsTo
    {
    return $this->belongsTo(RentInfo::class, 'rent_info_id', 'id')->withTrashed();
    }
}
