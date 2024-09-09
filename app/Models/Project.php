<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['client_id', 'install_type_id', 'name', 'region'];

    //Relations
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function installionType(): BelongsTo
    {
        return $this->belongsTo(InstallationType::class);
    }

    public function equipment(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'project_equipment')
                    ->withPivot(['amount']);
    }

    //Scope
    public function scopeFilter($query, $request)
    {
        if(filled($request->client_id)){
            $query->where('client_id', $request->client_id);
        }

        if(filled($request->name)){
            $query->where('name', 'LIKE', "%{$request->name}%");
        }

        if(filled($request->region)){
            $query->where('region', $request->region);
        }

        return $query;
    }
}
