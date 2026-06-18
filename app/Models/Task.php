<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'category',
        'due_date',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    const PRIORITIES = ['low', 'medium', 'high', 'urgent'];
    const STATUSES = ['todo', 'in_progress', 'done'];
    const CATEGORIES = ['work', 'personal', 'health', 'finance', 'learning', 'other'];

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                     ->where('status', '!=', 'done');
    }

    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'done';
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'urgent' => 'red',
            'high'   => 'orange',
            'medium' => 'yellow',
            'low'    => 'green',
            default  => 'gray',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'done'        => 'green',
            'in_progress' => 'blue',
            'todo'        => 'gray',
            default       => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'done'        => 'Done',
            'in_progress' => 'In Progress',
            'todo'        => 'To Do',
            default       => ucfirst($this->status),
        };
    }

    public function getCategoryIconAttribute(): string
    {
        return match($this->category) {
            'work'     => '💼',
            'personal' => '🏠',
            'health'   => '💪',
            'finance'  => '💰',
            'learning' => '📚',
            'other'    => '📌',
            default    => '📌',
        };
    }
}
