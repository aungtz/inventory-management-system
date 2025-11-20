<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    protected $table = 'M_Sku';
     public $timestamps = false; 
  protected $fillable = [
        'Item_Code', 'Size_Name', 'Color_Name', 'Size_Code', 'Color_Code', 'JanCode', 'Quantity', 'CreatedBy', 'UpdatedBy'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'Item_Code', 'Item_Code');
    }
}
