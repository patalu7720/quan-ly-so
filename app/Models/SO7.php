<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SO7 extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';

    protected $table = 'sap_so';

    protected $primaryKey = 'KeyID';

    protected $keyType = 'string';

    protected $fillable = [

        'VBELN'

    ];
}
