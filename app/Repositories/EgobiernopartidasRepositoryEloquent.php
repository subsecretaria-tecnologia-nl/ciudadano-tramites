<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernopartidasRepository;
use App\Entities\Egobiernopartidas;
use App\Validators\EgobiernopartidasValidator;

/**
 * Class EgobiernopartidasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernopartidasRepositoryEloquent extends BaseRepository implements EgobiernopartidasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernopartidas::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
