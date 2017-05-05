<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 6:48 PM
 */

namespace App\Http\Controllers\AppApi;


use Dingo\Api\Http\Request;
use Eureka\Helpers\Transformers\Mobile\CommentCollectionTransformer;
use Eureka\Repositories\TrackRepository;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class CommentsController extends PublicApiController
{
    /**
     * @var TrackRepository
     */
    private $trackRepository;
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @param TrackRepository $trackRepository
     * @param Manager $fractal
     */
    public function __construct(TrackRepository $trackRepository, Manager $fractal){
        $this->trackRepository = $trackRepository;
        $this->fractal = $fractal;
    }

    /**
     * @param $uuid
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function comment($uuid, Request $request)
    {
        $track = $this->trackRepository->getTrack($uuid);
        $comment = $track->comments()->create([
            'body'=>$request->get('message'),
            'user_id'=>$this->auth->user()->id
        ]);
        $comment = $this->fractal->createData(new Item($comment, new CommentCollectionTransformer))->toArray();
        if(! $comment){
            return $this->respondForDataMerge("error", 400, "error");
        }
        return $this->respondForDataMerge("success", 200, "successfully commented on track.", $comment);
//        $job = new CommentTrack($track, $request->get('message'), $this->auth->user());
//        try{
//            $this->dispatch($job);
//        }catch (\Exception $e){
//            return $this->respondForAction("error", $e->getCode(), $e->getMessage());
//        }
    }

    public function comments($uuid)
    {
        $track = $this->trackRepository->getTrack($uuid);
        $comments = $track->comments;
        $comments = $this->fractal->createData(new Collection($comments, new CommentCollectionTransformer))
            ->toArray();
        return $this->response->array($comments)->setStatusCode(200);
    }
}