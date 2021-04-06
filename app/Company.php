<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'email', 'website','is_active','logo'
  ];

    /**
     * @return HasMany
     */
    public function employees()
  {
    return $this->hasMany('App\Employee','company');
  }
}
