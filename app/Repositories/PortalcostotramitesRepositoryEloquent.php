<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalcostotramitesRepository;
use App\Entities\Portalcostotramites;
use App\Validators\PortalcostotramitesValidator;
use Illuminate\Support\Facades\Log;

/**
 * Class PortalcostotramitesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalcostotramitesRepositoryEloquent extends BaseRepository implements PortalcostotramitesRepository
{
    // protected $db='db_egobierno';
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalcostotramites::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findCostotramites()
    {
        try{
            $data = Portalcostotramites::select('portal_costo_tramites.id',
            'portal_costo_tramites.tramite_id',
            $this->db  . '.tipo_servicios.Tipo_Descripcion as tramite',
            'portal_costo_tramites.tipo',
            //$this->bd  . '.tipo_servicios.Descripcion',
            'portal_costo_tramites.costo',
            'portal_costo_tramites.minimo',
            'portal_costo_tramites.maximo',
            'portal_costo_tramites.valor',
            'portal_sub_tramites.id as subsidio_id',
            'portal_sub_tramites.cuotas',
            'portal_sub_tramites.id_partida',
            'portal_sub_tramites.oficio',
            'portal_sub_tramites.limite_cuotas')
            ->leftjoin($this->db  . '.tipo_servicios',$this->db  . '.tipo_servicios.Tipo_Code','=','portal_costo_tramites.tramite_id')
            ->leftjoin('portal_sub_tramites','portal_sub_tramites.costo_id','=','portal_costo_tramites.id')
            ->where('portal_costo_tramites.status','=','1')
            ->groupBy('portal_costo_tramites.id')
            ->get();

            return $data;
        }catch( \Exception $e){
            Log::info('[PortalcamporelationshipRepositoryEloquent@searchTramite] Error ' . $e->getMessage());
        }
    }

}
