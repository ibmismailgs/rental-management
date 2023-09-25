<?php

namespace App\Models\RentInfo;

use App\Models\RentInfo\FlatInfo;
use App\Models\RentInfo\OwnerInfo;
use App\Models\RentInfo\TenantInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentInfo extends Model
{
    use HasFactory, SoftDeletes;

    public function owners(): BelongsTo
    {
        return $this->belongsTo(OwnerInfo::class, 'owner_info_id', 'id')->withTrashed();
    }

    public function flats(): BelongsTo
    {
        return $this->belongsTo(FlatInfo::class, 'flat_info_id', 'id')->withTrashed();
    }

    public function tenants(): BelongsTo
    {
        return $this->belongsTo(TenantInfo::class, 'tenant_info_id', 'id')->withTrashed();
    }
}
