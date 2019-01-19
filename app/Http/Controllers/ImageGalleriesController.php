<?php

namespace App\Http\Controllers;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ImageGalleriesCreateRequest;
use App\Http\Requests\ImageGalleriesUpdateRequest;
use App\Repositories\ImageGalleriesRepository;
use App\Validators\ImageGalleriesValidator;

/**
 * Class ImageGalleriesController.
 *
 * @package namespace App\Http\Controllers;
 */
class ImageGalleriesController extends Controller
{
    /**
     * @var ImageGalleriesRepository
     */
    protected $repository;

    /**
     * @var ImageGalleriesValidator
     */
    protected $validator;

    /**
     * ImageGalleriesController constructor.
     *
     * @param ImageGalleriesRepository $repository
     * @param ImageGalleriesValidator $validator
     */
    public function __construct(ImageGalleriesRepository $repository, ImageGalleriesValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $imageGalleries = $this->repository->orderBy('id','desc')->all();

        return response()->json([
            'data' => $imageGalleries,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageGalleriesCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ImageGalleriesCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $imageGallery = $this->repository->uploadImage($request);

            $response = [
                'message' => 'ImageGalleries created.',
                'data'    => $imageGallery->toArray(),
            ];

            return response()->json($response);

        } catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $imageGallery = $this->repository->find($id);
        return response()->json([
            'data' => $imageGallery,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $imageGallery = $this->repository->find($id);

        return view('imageGalleries.edit', compact('imageGallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ImageGalleriesUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ImageGalleriesUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $imageGallery = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ImageGalleries updated.',
                'data'    => $imageGallery->toArray(),
            ];


            return response()->json($response);

        } catch (ValidatorException $e) {


            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        return response()->json([
            'message' => 'ImageGalleries deleted.',
            'deleted' => $deleted,
        ]);
    }


    /**
     * Get All usage compositions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsageComposition()
    {
        $usageCompositions = $this->repository->getUsageComposition();

        return response()->json([
            'data' => $usageCompositions,
        ]);

    }

    /**
     * Get All usage overview.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsageOverview()
    {
        $usageOverview = $this->repository->getUsageOverview();
        return response()->json($usageOverview->first());

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderWebGallery()
    {
        return view('gallery.galleries');
    }
}
