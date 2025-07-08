<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = ["name", "color", "user_id"];

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, "category_task");
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
