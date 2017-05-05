<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/19/2016
 * Time: 3:23 PM
 */

namespace Eureka\Repositories;


use App\Ad;

class AudioAdRepository
{
    /**
     * @var Ad
     */
    private $ad;

    public function __construct(Ad $ad){
        $this->ad = $ad;
    }

    public function getAds()
    {
        $ads = $this->ad->where('is_active', true)
            ->orderBy('updated_on', 'desc')
            ->get();
        return collect($ads);
    }

    public function deleteAd($id)
    {
        $ad = $this->getAd($id);
        $ad->delete();
        return $ad;
    }

    public function editAd($id, $data)
    {
        $ad = $this->getAd($id);
        $ad = $ad->fill($data);
        $ad->save();
        return $ad;
    }

    /**
     * @param $data
     * @return static
     */
    public function createAd($data)
    {
        return $this->ad->create($data);
    }

    public function getAd($id)
    {
        return $this->ad->where('uuid', $id)->first();
    }
}