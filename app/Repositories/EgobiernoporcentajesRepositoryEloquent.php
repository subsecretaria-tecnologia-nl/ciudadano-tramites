<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernoporcentajesRepository;
use App\Entities\Egobiernoporcentajes;
use App\Validators\EgobiernoporcentajesValidator;

/**
 * Class EgobiernoporcentajesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernoporcentajesRepositoryEloquent extends BaseRepository implements EgobiernoporcentajesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernoporcentajes::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
