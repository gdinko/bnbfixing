<?php

namespace Mchervenkov\BnbFixing\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Mchervenkov\BnbFixing\Models\BnbFixing
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $ratio
 * @property string $rate
 * @property string $reverse_rate
 * @method static Builder|BnbFixing create(array $attributes)
 * @method static Builder|BnbFixing updateOrCreate(array $attributes)
 */
class BnbFixing extends Model
{
    use HasFactory;

    protected $table = 'bnb_fixings';

    protected $fillable = [
        'name',
        'code',
        'ratio',
        'rate',
        'reverse_rate',
    ];
}
