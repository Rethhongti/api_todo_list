<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory;

    public function getIsCompletedToBoolAttribute(){
        if($this->isCompleted == 1){
            return true;
        }
        if($this->isCompleted == 0){
            return false;
        }
    }

    public function setIsCompletedAttribute($value){
        if($value == "true"){
            $this->attributes['isCompleted'] = 1;
        }else if($value == "false"){
            $this->attributes['isCompleted'] = 0;
        }
    }

    protected $fillable = ['todo', 'isCompleted'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot(){
        parent::boot();

        static::creating(function ($model){
            if(empty($model->{$model->getKeyName()})){
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }
}
