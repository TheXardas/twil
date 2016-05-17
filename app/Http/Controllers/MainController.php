<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Controllers\Api\ApiController;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for rendering basic beckend-rendered application pages.
 */
class MainController extends Controller
{
    /**
     * @var CountryRepository
     */
    protected $countries;

    public function __construct(CountryRepository $countries)
    {
        $this->countries = $countries;
    }

    /**
     * Web-Application main entrance.
     * 
     * @return mixed
     */
    public function index()
    {
        $countries = $this->countries->active();
        return view('main', [
            'countries' => $countries->get()
        ]);
    }
}
