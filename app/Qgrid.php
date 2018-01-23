<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qgrid extends Model
{
    protected $fillable = ['id','content_id', 'parent_id', 'content_type', 'content', 'content_order', 'creation_date', 'change_date'];
}
