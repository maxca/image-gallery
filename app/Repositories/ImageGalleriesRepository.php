<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ImageGalleriesRepository.
 *
 * @package namespace App\Repositories;
 */
interface ImageGalleriesRepository extends RepositoryInterface
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function uploadImage(Request $request);


    /**
     * @return mixed
     */
    public function getUsageComposition();


    /**
     * @return mixed
     */
    public function getUsageOverview();
}
