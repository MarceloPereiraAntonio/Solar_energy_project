<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstallationType extends Model
{
    use HasFactory;
    protected $fillable = ['item'];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class); 
    }
}
