<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['title', 'emoji', 'location', 'tag', 'tag_color', 'description', 'target_amount', 'collected_amount', 'deadline', 'is_active'];

    protected $casts = ['deadline' => 'date', 'is_active' => 'boolean'];

    public function getPctAttribute()
    {
        if ($this->target_amount <= 0) return 0;
        return min(100, round($this->collected_amount / $this->target_amount * 100));
    }
}
