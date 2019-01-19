<?php

namespace App\Repositories;

use App\Criteria\FilterUserOwnerImageCriteria;
use App\Criteria\GetUsageCompositionCriteria;
use App\Criteria\GetUsageOverviewCriteria;
use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ImageGalleriesRepository;
use App\Entities\ImageGalleries;
use App\Validators\ImageGalleriesValidator;
use App\Criteria\GetDiskSizeCriteria;

/**
 * Class ImageGalleriesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ImageGalleriesRepositoryEloquent extends BaseRepository implements ImageGalleriesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ImageGalleries::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function uploadImage(Request $request)
    {
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $extension         = $image->extension();
                $params['user_id'] = $request->user_id;
                $params['name']    = $image->getClientOriginalName();
                $params['size']    = $image->getClientSize();
                $params['type']    = strtolower($extension) === "jpg" || "jpeg" ? "image/jpeg" : "image/png";
                $params['path']    = $image->storeAs('images', $params['name']);

                parent::create($params);

            }
        }
        $this->applyCriteria(app(FilterUserOwnerImageCriteria::class));
        return $this->model->all();
    }


    /**
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getUsageComposition()
    {
        $this->pushCriteria(app(GetUsageCompositionCriteria::class));
        $this->applyCriteria();
        return $this->model->get();
    }


    /**
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getUsageOverview()
    {
        $this->pushCriteria(app(GetUsageOverviewCriteria::class));
        $this->applyCriteria();
        return $this->model->get();
    }

}
