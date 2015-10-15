@extends('layouts.master')

@section('content')

	<div class="jumbotron">
		<div class="container-fluid">

			<h2>Loan Calculator</h2>


			<form name="calcForm" id="calcForm" action="{!! URL::route('home') !!}" method="post" novalidate>

				<fieldset>
					<legend>This is a simple loan calculator created with Laravel 5.1, Bootstrap 3, and jQuery.</legend>
					<div class="principal row">

						<div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">

							<div class="form-group  @if ($errors->has('principal')) has-error @endif">

								<div class="input-group" >

									<span class="input-group-addon">
										<label for="principal" class="control-label" style="padding:0;margin:1px 0 0 0;">Principal</label>
									</span>

									<div class="icon-addon addon-md"
									     data-toggle="tooltip"
									     data-trigger="hover"
									     data-viewport=".jumbotron"
									     data-placement="auto"
									     title="Enter the principal amount for the loan to the nearest penny.">
										<input id="principal" name="principal" type="text" class="form-control" aria-describedby="principal-dollar-sign" required="" value="{{ old('principal') }}" >
										<label for="principal" class="glyphicon flaticon-dollar185 " rel="tooltip" title="Principal" ></label>
									</div>

								</div>

							</div>


							<div class="form-group form-inline @if ($errors->has('termLength')) has-error @endif">

								<div class="row">

									<div class="col-xs-6 col-lg-7" style="margin-right:0;padding-right:0;">
										<div class="input-group"
										     data-toggle="tooltip"
										     data-trigger="hover"
										     data-placement="auto"
										     title="Enter the duration of the loan in years or months.">
											<span class="input-group-addon">
												<label for="term-length" class="control-label" style="padding:0;margin:1px 0 0 0;">Term Length</label>
											</span>
											<input id="term-length" name="termLength" type="text" class="form-control" style="min-width:4em;" value="{{ old('termLength') }}">
										</div>
									</div>

									<div class="col-xs-6 col-lg-5 pull-left" style="margin:0;">
										<div class="input-group pull-left col-xs-push-2 col-lg-push-0">
											<label></label>

											{!! Form::select('termLengthType',array('years'=>'Years','months'=>'Months'), old('termLengthType'),array('class' => 'form-control','style'=>'width:7em;padding-left:0;pull-left;')) !!}


										</div>
									</div>

								</div>

							</div>


							<div class="form-group @if ($errors->has('rate')) has-error @endif">


								<div class="input-group"
								     data-toggle="tooltip"
								     data-trigger="hover"
								     data-placement="auto"
								     title="Enter the annual percentage rate up to 4 decimal places.">

									<span class="input-group-addon">
										<label for="rate" class="control-label @if ($errors->has('rate')) has-error @endif" style="padding:0;margin:1px 0 0 0;">Interest Rate</label>
									</span>

									<div class="icon-addon addon-md addon-rt">
										<input id="rate" name="rate" type="text" class="form-control flaticon-percentage16 " aria-describedby="rate-percent-sign" value="{{ old('rate') }}">
										<label class="glyphicon addon-rt flaticon-percentage16" id="rate-percent-sign" title="percent" ></label>
									</div>
								</div>

							</div>

							<button type="submit" class="btn btn-lg btn-success">Calculate</button>


						</div>

					</div>
				</fieldset>

				{!! csrf_field() !!}
			</form>

		</div>

		@if(!empty($results))

			<div>
				<h3>Monthly Payment:
					<span>&dollar;{{ number_format($results['monthlyPayment'],2) }}</span>

				</h3>
			</div>

			<div>
				<h3>Total Interest Paid:
					<span>&dollar;{{ number_format($results['totalInterest'],2) }}</span>

				</h3>
			</div>

			<div>
				<h3>Total Amount Paid:
					<span>&dollar;{{ number_format($results['grandTotal'],2) }}</span>
				</h3>
			</div>

		@endif

	</div>






@stop
