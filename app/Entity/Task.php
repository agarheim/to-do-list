<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Task extends Model
{
    use Notifiable;
    protected $table = 'tasks';
    public const STATUS_NEW = 'new';
    public const STATUS_TO_WORK = 'to_work';
    public const STATUS_FNISHED = 'finished';
    public const STATUS_ARCHIVE = 'archive';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_task', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime',
    ];

}
