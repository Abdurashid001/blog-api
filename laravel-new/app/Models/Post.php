<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    protected $fillable = [
        'title',
        'content',
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
// id: 4,
// name: "Temp Admin",
// email: "tempadmin@test.com",
// token: "9|pQ51YoMdpjMA9h0HHvpjrIVUzUkeTabolYVSct7ub7fb7a40"