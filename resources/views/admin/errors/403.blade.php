@extends('admin.layouts.app')
@section('title')
    @lang('403')
@endsection


@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3"><i class="icon-check"></i> @lang("You don't have permission to access that link")</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
