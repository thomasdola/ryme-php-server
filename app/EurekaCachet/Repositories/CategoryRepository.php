<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/9/2016
 * Time: 4:41 PM
 */

namespace Eureka\Repositories;


use App\Category;

class CategoryRepository
{

    /**
     * @var Category
     */
    private $category;

    /**
     * @param Category $category
     */
    public function __construct(Category $category){
        $this->category = $category;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->category
//            ->with('artists', 'followers', 'tracks')
            ->all();
    }

    /**
     * @param $id
     * @return static
     */
    public function getCategory($id)
    {
        return $this->category
            ->with('artists', 'tracks', 'followers')
            ->where('uuid', $id)->first();
    }

    /**
     * @param $data
     * @return static
     */
    public function addCategory($data)
    {
        return $this->category->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return CategoryRepository
     */
    public function updateCategory($id, $data)
    {
        $data = collect($data);
        $category = $this->getCategory($id);
        $category->name = $data->get('name');
        $category->save();
        return $category;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCategory($id)
    {
        $category = $this->getCategory($id);
        $category->delete();
        return $category;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTrendingArtistsByCategory($id)
    {
       return $this->category->with('artists')
           ->where('uuid', $id)->artists
           ->sortDescBy(function($artist){
               return $artist->followers->count();
           });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCategoryTrendingTracks($id)
    {
        $tracks = $this->category->with("tracks", "tracks.streams")
            ->find($id)->tracks->sortByDesc(function($track){
                $track->streams->count();
            })->take(50);
        return $tracks;
    }

    public function getCategoryIdByName($category_name)
    {
        return $this->category->where("name", $category_name)->first()->id;
    }

    /**
     * @param $id
     * @return static
     */
    public function getCategoryNewTracks($id)
    {
        $tracks = $this->category->find($id)->tracks->all();
        return collect($tracks)->sortByDesc("created_at");
    }
}