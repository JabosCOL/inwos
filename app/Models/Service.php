<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
      return $this->belongsTo(Category::class, 'category_id');
    //   se supone que como segundo parametro debemos pasar el nombre de la llave foranea
    // pero no es necesario ya que por defecto tomara el nombre del modelo y le agregara _id,
    // en este caso category_id, lo cual coincide con el nombre de la llave foranea
    }

    public function city()
    {
      return $this->belongsTo(City::class, 'city_id');
    }

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }
}
