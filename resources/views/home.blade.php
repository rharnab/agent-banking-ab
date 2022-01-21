@extends('layouts.app')
@section('title')
    Home

@endsection


@push('css')
    
    <style type="text/css">
      
      .center{
      	margin-top: 10%;
      }	
      .center h1{
      	font-size: 100px;
      }
      .center h1, h4{
      	display: flex;
      	justify-content: center;
      	align-items: center;
      	text-align: center;

      }

    </style>

@endpush

@section('content')

<div class="container">
	<div class="center">
		<br>
		<h1><b>MyBank</b></h1>
		<h4>Venture Agent Banking Solution</h4>
	</div>
	
</div>

@endsection