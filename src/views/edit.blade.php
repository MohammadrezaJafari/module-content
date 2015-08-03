@extends('master')
<style>
    .form-group{
        padding-bottom: 40px !important;
    }
</style>
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">Form</div>
        <div class="panel-body pan">
            <form method="post" action="{{\Illuminate\Support\Facades\URL::to("/module/content/product/$id")}}" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="col-md-12">
                        <div class="row">
                            <input name="_method" type="hidden" value="PUT">
                            @include('ui::form.element.text' , $text)
                            <hr>
                            @include('ui::form.element.select', $select = $typeSelect)
                            <hr>
                            @include('ui::form.element.textarea',$textarea)
                            <hr>
                            @include('ui::form.element.select',$select = $categorySelect)
                            <hr>
                            @include('ui::form.element.select2', $select2 = $tagSelect2)
                            <hr>
                            @include('ui::form.element.filechooser', $file = $file)
                            <hr>
                            @include('ui::form.element.checkbox',$checkbox)
                        </div>
                    </div>
                </div>
                @include('ui::form.element.submit')
            </form>
        </div>
    </div>
@stop
