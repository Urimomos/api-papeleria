<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    
    public $timestamps = false;
    protected $fillable = ['producto_id', 'cantidad', 'precio_unitario', 'subtotal'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
?>