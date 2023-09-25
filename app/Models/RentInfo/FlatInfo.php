<?php

namespace App\Models\RentInfo;

use App\Models\RentInfo\OwnerInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlatInfo extends Model
{
    use HasFactory, SoftDeletes ;

    public function owners(): BelongsTo
    {
        return $this->belongsTo(OwnerInfo::class, 'owner_info_id', 'id')->withTrashed();
    }
}
