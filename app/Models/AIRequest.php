<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AIRequest extends Model
{
    use HasFactory;

    protected $table = 'ai_requests';

    protected $fillable = [
        'user_id',
        'prompt_text', 
        'response_text',
        'model_used',
        'tokens_used',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getTypeAttribute()
    {
        return 'general';
    }
    
    public function getTypeNameAttribute()
    {
        return 'Общий запрос';
    }
}