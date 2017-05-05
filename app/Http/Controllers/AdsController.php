<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Eureka\Repositories\AdRepository;
use Eureka\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class AdsController extends Controller
{

    /**
     * @var AdRepository
     */
    private $adRepository;
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @param AdRepository $adRepository
     * @param CompanyRepository $companyRepository
     */
    public function __construct(AdRepository $adRepository, CompanyRepository $companyRepository){
        $this->adRepository = $adRepository;
        $this->companyRepository = $companyRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeAdsCount = $this->adRepository->getActiveAdsCount();
        $pausedAdsCount = $this->adRepository->getPausedAdsCount();
        $allAdsCount = $this->adRepository->getAllAdsCount();
        $allCompanyCount = $this->companyRepository->getAllCompaniesCount();
        return view('ads.index', [
            'activeOnes' => $activeAdsCount,
            'pausedOnes' => $pausedAdsCount,
            'all' => $allAdsCount,
            'allCompanies' => $allCompanyCount
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->adRepository->createAd($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->adRepository->editAd($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->adRepository->deleteAd($id);
    }
}
