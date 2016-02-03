<?php
namespace Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Plano extends Eloquent
{
    /**
     * Define a chave primária da tabela
     *
     * @var string
     */
    protected $primaryKey = 'pln_id';

    /**
     * Define o nome da tabela
     *
     * @var string
     */
    protected $table = 'planos';
    
    /**
     * Define o padrão da coluna "created_at" para "usu_created_at"
     *
     * @var string
     */
    const CREATED_AT = 'pln_created_at';

    /**
     * Define o padrão da coluna "updated_at" para "usu_updated_at"
     *
     * @var string
     */
    const UPDATED_AT = 'pln_updated_at';

    /**
     * Pega todos usuários do plano
     *
     * @return object
     */
    public function relationUsuarios()
    {
        return $this->hasMany(Usuario::class, 'usu_plano');
    }
}
