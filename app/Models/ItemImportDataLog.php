<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ItemImportDataLog extends Model
{
    protected $table = 'item_import_data_logs';

    protected $fillable = [
        'ImportLog_ID',
        'Item_Code',
        'Item_Name',
        'JanCD',
        'MakerName',
        'Memo',
        'ListPirce',
        'SalePrice',
        'Size_Name',
        'Color_Name',
        'Size_Code',
        'Color_Code',
        'JanCode',
        'Quantity',
    ];

    public $timestamps = false;
    public function log()
    {
        return $this->belongsTo(ItemImportLog::class, 'ImportLog_ID', 'ImportLog_ID');
    }
}

