<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernodiasferiadosRepository;
use App\Entities\Egobiernodiasferiados;
use App\Validators\EgobiernodiasferiadosValidator;

/**
 * Class EgobiernodiasferiadosRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernodiasferiadosRepositoryEloquent extends BaseRepository implements EgobiernodiasferiadosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernodiasferiados::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
