<div class="modal-body">

 {!! Form::open(['route' => ['admin-order.status.update', $order->id], 'id' => 'form-modal', 'method' => 'PUT', 'class' => 'form-horizontal form-label-left']) !!}

  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="@lang('app.status')">@lang('app.status') <span class="required">*</span>
    </label>
    <div class="col-md-4 col-sm-4 col-xs-12">
      {!! Form::select('status', $status, $order->status, ['class' => 'form-control col-md-7 col-xs-12']) !!}
    </div>
  </div>

</div>

<div class="modal-footer">
  <button type="submit" class="btn btn-primary btn-submit col-sm-2 col-xs-6">@lang('app.update')</button>
  <button type="button" class="btn btn-default col-sm-2 col-xs-5" data-dismiss="modal">@lang('app.close')</button>
</div>
{!! Form::close() !!}
 