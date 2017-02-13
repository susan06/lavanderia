@extends('layouts.app')

@section('page-title', trans('app.home'))

@section('content')
<div class="content-top">
	<div class="col-md-4 col-ms-4">
		<div class="content-top-1">
			<div class="col-md-6 top-content">
				<h5>@lang('app.order_delivered')</h5>
				<label>{{ $count['delivered'] }}</label>
			</div>
			<div class="col-md-6 top-content1">	   
				<div id="demo-pie-1" class="pie-title-center" data-percent="{!! $count['delivered-percent'] !!}"> <span class="pie-value"></span> </div>
			</div>
			<div class="clearfix"> </div>
		</div>
		<div class="content-top-1">
			<div class="col-md-6 top-content">
				<h5>@lang('app.order_inbranch')</h5>
				<label>{{ $count['inbranch'] }}</label>
			</div>
			<div class="col-md-6 top-content1">	   
				<div id="demo-pie-2" class="pie-title-center" data-percent="{!! $count['inbranch-percent'] !!}"> <span class="pie-value"></span> </div>
			</div>
			 <div class="clearfix"> </div>
		</div>
		<div class="content-top-1">
			<div class="col-md-6 top-content">
				<h5>@lang('app.order_search')</h5>
				<label>{{ $count['search'] }}</label>
			</div>
			<div class="col-md-6 top-content1">	   
				<div id="demo-pie-3" class="pie-title-center" data-percent="{!! $count['search-percent'] !!}"> <span class="pie-value"></span> </div>
			</div>
			 <div class="clearfix"> </div>
			</div>
	</div>
		
	<div class="col-md-8 content-top-2">
	</div>
	<div class="clearfix"> </div>
</div>
@endsection

@section('scripts')

{!! HTML::script('public/assets/js/pie-chart.js') !!}

<script type="text/javascript">
	$(document).ready(function () {
        $('#demo-pie-1').pieChart({
            barColor: '#3bb2d0',
            trackColor: '#eee',
            lineCap: 'round',
            lineWidth: 8,
            onStep: function (from, to, percent) {
                $(this.element).find('.pie-value').text(Math.round(percent) + '%');
            }
        });
        $('#demo-pie-2').pieChart({
            barColor: '#fbb03b',
            trackColor: '#eee',
            lineCap: 'butt',
            lineWidth: 8,
            onStep: function (from, to, percent) {
                $(this.element).find('.pie-value').text(Math.round(percent) + '%');
            }
        });
        $('#demo-pie-3').pieChart({
            barColor: '#ed6498',
            trackColor: '#eee',
            lineCap: 'square',
            lineWidth: 8,
            onStep: function (from, to, percent) {
                $(this.element).find('.pie-value').text(Math.round(percent) + '%');
            }
        });
    });
</script>
@endsection
