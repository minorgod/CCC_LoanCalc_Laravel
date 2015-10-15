@extends('layouts.master')


@section('content')

 {{-- This is just some extra example ui stuff --}}   
    <div class="panel-group" id="accordion">
		<div class="panel panel-primary">

			<div class="panel-heading">
				<h4 class="panel-title">
					<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					Collapsible Group Item #1
					</a>
				</h4>
			</div>
    
    
            <div id="collapseOne" class="panel-collapse collapse">
            
	            <div class="page-header">
	                <h1>Buttons</h1>
	            </div>
          
	            <p>
	                <button type="button" class="btn btn-lg btn-default">Default</button>
	                <button type="button" class="btn btn-lg btn-primary">Primary</button>
	                <button type="button" class="btn btn-lg btn-success">Success</button>
	                <button type="button" class="btn btn-lg btn-info">Info</button>
	                <button type="button" class="btn btn-lg btn-warning">Warning</button>
	                <button type="button" class="btn btn-lg btn-danger">Danger</button>
	                <button type="button" class="btn btn-lg btn-link">Link</button>
	            </p>
	            <p>
	                <button type="button" class="btn btn-default">Default</button>
	                <button type="button" class="btn btn-primary">Primary</button>
	                <button type="button" class="btn btn-success">Success</button>
	                <button type="button" class="btn btn-info">Info</button>
	                <button type="button" class="btn btn-warning">Warning</button>
	                <button type="button" class="btn btn-danger">Danger</button>
	                <button type="button" class="btn btn-link">Link</button>
	            </p>
	            <p>
	                <button type="button" class="btn btn-sm btn-default">Default</button>
	                <button type="button" class="btn btn-sm btn-primary">Primary</button>
	                <button type="button" class="btn btn-sm btn-success">Success</button>
	                <button type="button" class="btn btn-sm btn-info">Info</button>
	                <button type="button" class="btn btn-sm btn-warning">Warning</button>
	                <button type="button" class="btn btn-sm btn-danger">Danger</button>
	                <button type="button" class="btn btn-sm btn-link">Link</button>
	            </p>
	            <p>
	                <button type="button" class="btn btn-xs btn-default">Default</button>
	                <button type="button" class="btn btn-xs btn-primary">Primary</button>
	                <button type="button" class="btn btn-xs btn-success">Success</button>
	                <button type="button" class="btn btn-xs btn-info">Info</button>
	                <button type="button" class="btn btn-xs btn-warning">Warning</button>
	                <button type="button" class="btn btn-xs btn-danger">Danger</button>
	                <button type="button" class="btn btn-xs btn-link">Link</button>
	            </p>

				<div class="well">
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Aenean lacinia bibendum nulla sed consectetur.</p>
				</div>

            </div>

		</div>
    </div>
    
    
    <div class="panel-group" id="accordion">
        <div class="panel panel-primary">
    
            <div class="panel-heading">
              <h4 class="panel-title">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseVideos">
                 Videos print_r output
                </a>
              </h4>
            </div>
            
            <div id="collapseVideos" class="panel-collapse collapse">
                    
                <div class="page-header">
                    <h1>Videos print_r output</h1>
                </div>
                
               
                   
            </div>
    
        </div>
    </div>
@stop