<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'status';

    protected $fillable = [
        'name',
    ];

    protected $appends = [
        'created_at_formatted',
        'updated_at_formatted'
    ];

}
