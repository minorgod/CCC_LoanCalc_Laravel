

@extends('layouts.master')

@section('content')

    <div class="jumbotron">
        <div class="container">


            <h1>Welcome!</h1>
            <p></p>
            <p>This is a simple loan calculator created with Laravel 5.1, Bootstrap 3, and jQuery.</p>

        </div>
    </div>

    <h2>Loan Calculator</h2>

    <h1>Simple Fixed Interest Rate Calculator</h1>

<div class="container" ng-init="calculate()">


  <form  name="calcForm" class="form-horizontal css-form" novalidate>




    <div class="form-group row">



      <div class="input-group">
        <span class="input-group-addon">
          <label for="principal" class="control-label" style="padding:0;margin:1px 0 0 0;">Principal</label>
        </span>

        <div class="icon-addon addon-md">
        <input id="principal" type="text" ng-model="data.principal" value="{{data.principal}}" ng-change="calculate()" class="form-control" aria-describedby="principal-dollar-sign" required="" >
         <label for="principal" class="glyphicon flaticon-dollar185" rel="tooltip" title="Principal"></label>
      </div>

      </div>

      <div ng-show="calcForm.principal.$touched && calcForm.principal.$error.required">Please enter a principal amount.</div>
    </div>


    <div class="form-group row">

      <div class="input-group ">

        <span class="input-group-addon">
          <label for="term-length" class="control-label" style="padding:0;margin:1px 0 0 0;">Term Length</label>
        </span>

        <input id="term-length" type="text" ng-model="data.termLength" value="{{data.termLength | number:0}" class="form-control" ng-change="calculate()" >

        <span class="input-group-addon">
          <input id="term-length-years" name="termLengthType" type="radio" value="years" aria-label="Years" ng-model="data.termLengthType" ng-change="calculate()">
          <label for="term-length-years" >Years</label>
          <input id="term-length-months" name="termLengthType" type="radio" value="months" aria-label="Months" ng-model="data.termLengthType" ng-change="calculate()" style="padding:0;margin:0 0 -3px 0;">
          <label for="term-length-months" >Months</label>
        </span>
      </div>



    </div>

    <div class="form-group row">



      <div class="input-group">
        <span class="input-group-addon">
          <label for="rate" class="control-label" style="padding:0;">Interest Rate</label>
        </span>

        <div class="icon-addon addon-md addon-rt">
          <input id="rate" type="text" ng-model="data.rate" value="{{data.rate | number:4}}" class="form-control flaticon-percentage16" aria-describedby="rate-percent-sign" ng-change="calculate()">
          <label class="glyphicon addon-rt flaticon-percentage16" id="rate-percent-sign"  title="percent"></label>
        </div>
      </div>

    </div>



    <!--<button type="button" ng-click="calculate()">Calculate</button>-->

  </form>

  <div>
    <h3>Monthly Payment:
      <span ng-model="data.monthlyPayment">{{data.monthlyPayment | currency}}</span>
    </h3>
  </div>

  <div>
    <h3>Total Interest Paid:
      <span ng-model="data.totalInterest">{{data.totalInterest | currency}}</span>
    </h3>
  </div>

  <div>
    <h3>Total Amount Paid:
      <span ng-model="data.grandTotal">{{data.grandTotal | currency}}</span>
    </h3>
  </div>


</div>











@stop
