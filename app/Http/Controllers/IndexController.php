<?php namespace App\Http\Controllers;


use App\Http\Requests\CalculateRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\LoanCalculator;

class IndexController extends Controller
{

    /**
     * Show the index page
     * @return \Illuminate\View\View
     */
    public function showIndex()
    {
        return view('index');
    }

    public function calculate(CalculateRequest $request)
    {

        $calculator = new LoanCalculator($request->all());

        $results = $calculator->calculate();

        return view('index',compact('results'));
    }

    /**
     * Show the About page
     * @return \Illuminate\View\View
     */
    public function showAbout()
    {
        return view('about');
    }

    /**
     * Show the bootstrap example page
     * @return \Illuminate\View\View
     */
    public function showBootstrapExamples()
    {
        return view('bootstrap-examples');
    }

}