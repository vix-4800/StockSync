<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GeneratedPdf extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_name',
        'marketplace_account_id',
        'supply_numbers',
        'supply_dates',
        'sticker_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'supply_numbers' => 'array',
        'sticker_count' => 'integer',
    ];

    /**
     * Get the account that the GeneratedPdf belongs to.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(MarketplaceAccount::class);
    }

    /**
     * Set the file_name attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setFileNameAttribute($value)
    {
        $this->attributes['file_name'] = 'generated_stickers/'.$value.'.pdf';
    }

    public function download()
    {
        return response()->download(Storage::disk('public')->path($this->file_name));
    }
}
