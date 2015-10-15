<?php namespace App\Http\Controllers;


use App\Http\Requests\CalculateRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\LoanCalculator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

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

        if(!empty($results['errors'])){
            Session::flash(
                'errors', Session::get('errors', new ViewErrorBag)->put('default', new MessageBag($results['errors']))
            );
        }

        //replace the request data with the cleaned up data used by the calculator
        $cleanData = $calculator->getData();
        $request->merge($cleanData);
        $request->flashOnly(array_keys($cleanData));

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