<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/8/2016
 * Time: 8:17 PM
 */

namespace Eureka\Repositories;


use App\Ad;

class AdRepository
{

    /**
     * @var Ad
     */
    private $ad;

    /**
     * @param Ad $ad
     */
    public function __construct(Ad $ad){
        $this->ad = $ad;
    }

    /**
     * @return mixed
     */
    public function getAllActiveAdsCount()
    {
        return $this->ad->where('is_active', true)->count();
    }

    /**
     * @return mixed
     */
    public function getActiveAdsCount()
    {
       return $this->getActiveAds()->count();
    }

    /**
     * @return mixed
     */
    public function getActiveAds()
    {
        return $this->ad->where('is_active', true)
            ->get();
    }

    /**
     * @return mixed
     */
    public function getPausedAdsCount()
    {
        return $this->getPausedAds()->count();
    }

    /**
     * @return mixed
     */
    public function getPausedAds()
    {
       return $this->ad->where('is_active', false)
           ->get();
    }

    /**
     * @return mixed
     */
    public function getAllAdsCount()
    {
        return $this->getAllAds()->count();
    }

    /**
     * @return mixed
     */
    public function getAllAds()
    {
       return $this->ad->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteAd($id)
    {
        $ad = $this->ad->find($id);
        $ad->delete();
        return $ad;
    }

    public function editAd($id, $all)
    {
        $ad = $this->ad->find($id);
        $ad = $ad->fill($all);
        $ad->save();
        return $ad;
    }

    public function createAd($data)
    {
        return $this->ad->create($data);
    }
}