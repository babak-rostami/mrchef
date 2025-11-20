<?php

namespace App\Models;

use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Model;

class CkeditorImage extends Model
{
    use Imageable;

    protected $fillable = ['image', 'editorable_id', 'editorable_type'];

    public function editorable()
    {
        return $this->morphTo();
    }
}
