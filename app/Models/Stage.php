<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Stage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'start_date_time',
        'end_date_time',
        'distance',
        'status',
        'user_id_creator',
        'start_location_id',
        'end_location_id',
    ];

    public function stageComments(): HasMany
    {
        return $this->hasMany(StageComments::class);
    }

    public function stageParticipants(): HasMany
    {
        return $this->hasMany(StageParticipants::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function startLocation(): HasOne
    {
        return $this->hasOne(Location::class);
    }

    public function endLocation(): HasOne
    {
        return $this->hasOne(Location::class);
    }
}
