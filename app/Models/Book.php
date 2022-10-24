<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
  use HasFactory;
  protected $guarded = [];

  // bindibg relationships
  public function borrowers()
  {
    return $this->hasMany(Borrower::class);
  }
}
