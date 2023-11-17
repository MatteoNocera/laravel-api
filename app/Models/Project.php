<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Type;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Technology;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'projects';

    protected $fillable = ['title', 'description', 'slug', 'cover_image', 'content', 'type_id', 'technology_id'];

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    public static function generateSlug($title)
    {
        return Str::slug($title, '-');
    }
}
