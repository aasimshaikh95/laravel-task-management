<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope tasks visible to the given user.
     * Admins can see everything, regular users only their own.
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $user->isAdmin() ? $query : $query->where('user_id', $user->id);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
            ->when($filters['due_date'] ?? null, fn ($q, $date) => $q->whereDate('due_date', $date));
    }

    public function scopeDueTomorrow(Builder $query): Builder
    {
        return $query->whereDate('due_date', now()->addDay()->toDateString())
            ->whereIn('status', ['pending', 'in-progress']);
    }
}
