<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'firstName', 'lastName', 'email', 'phone', 'company','is_active'
  ];

    /**
     * @return BelongsTo
     */
    public function company()
  {
    return $this->belongsTo('App\Company', 'company');
  }
}
