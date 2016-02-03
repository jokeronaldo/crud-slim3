<?php
namespace Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Usuario extends Eloquent
{
    /**
     * Define a chave primária da tabela
     *
     * @var string
     */
    protected $primaryKey = 'usu_id';

    /**
     * Define o nome da tabela
     *
     * @var string
     */
    protected $table = 'usuarios';
    
    /**
     * Define o padrão da coluna "created_at" para "usu_created_at"
     *
     * @var string
     */
    const CREATED_AT = 'usu_created_at';

    /**
     * Define o padrão da coluna "updated_at" para "usu_updated_at"
     *
     * @var string
     */
    const UPDATED_AT = 'usu_updated_at';

    /**
     * Pega o clube ao qual o usuário pertence
     *
     * @return object
     */
    public function relationClube()
    {
        return $this->belongsTo(Clube::class, 'usu_clube');
    }
    
    /**
     * Pega o plano ao qual o usuário pertence
     *
     * @return object
     */
    public function relationPlano()
    {
        return $this->belongsTo(Plano::class, 'usu_plano');
    }
    
    /**
     * Pega os dependentes do usuário
     *
     * @return object
     */
    public function relationDependentes()
    {
        return $this->hasMany(Usuario::class, 'usu_titular');
    }
}
