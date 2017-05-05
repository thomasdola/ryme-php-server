<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/22/2016
 * Time: 10:52 AM
 */

namespace Eureka\Services\Internal;


use Eureka\Services\Interfaces\string;
use Eureka\Services\Interfaces\TrackTagServiceInterface;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class TrackTagService
 * @package Eureka\Services\Internal
 */
class TrackTagService implements TrackTagServiceInterface
{
    /**
     * @var
     */
    protected $title;

    /**
     * @var
     */
    protected $album;

    /**
     * @var
     */
    protected $author;

    /**
     * @var
     */
    protected $genre;

    /**
     * @var
     */
    protected $year;

    /**
     * @var
     */
    protected $cover;
    /**
     * @var UploadedFile
     */
    protected $trackFile;

    public function __construct(){}

    public function using(Collection $trackData)
    {
        $this->trackFile = $trackData;
        return $this->getTaggedTrack();
    }

    /**
     * @param mixed $author
     */
    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre(string $genre)
    {
        $this->genre = $genre;
    }

    /**
     * @param mixed $year
     */
    public function setYear(string $year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param mixed $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {

    }

    private function getTaggedTrack()
    {
        return collect([
            'track'=>'file',
            'cover'=>'photo',
            'length'=>'length'
        ]);
    }
}