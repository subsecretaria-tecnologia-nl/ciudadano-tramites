<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortaltramitecategoriarelacionRepository;
use App\Entities\Portaltramitecategoriarelacion;
use App\Validators\PortaltramitecategoriarelacionValidator;

/**
 * Class PortaltramitecategoriarelacionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortaltramitecategoriarelacionRepositoryEloquent extends BaseRepository implements PortaltramitecategoriarelacionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portaltramitecategoriarelacion::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
