@extends('layouts.app')

@section('page-title', trans('app.orders'))

@section('content')

<div class="right_col" role="main">
  <div class="">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="page-title no-print">
            <div class="title_left">
              <h3>@lang('app.orders')</h3>
            </div>
            @include('partials.status')
            @include('partials.search')
            <div class="clearfix"></div>
          </div>
        
          <div class="x_content">

            <div id="content-table">
              @include('orders.list')
            </div>
                
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

@endsection