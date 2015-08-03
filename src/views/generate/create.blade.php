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
            <form method="post" action="{{\Illuminate\Support\Facades\URL::to('/module/content/generate/node')}}" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="col-md-12">
                        <div class="row">
                            @include('ui::form.element.text' , $text = $contentNameText)
                            <hr>
                            @include('ui::form.element.text' , $text = $attributeNameText)
                            <hr>
                            @include('ui::form.element.select' , $select = $attributeTypeSelect)
                            <hr>
                            @include('ui::form.element.textarea',$textarea = $attributeValueTextarea)
                            <hr>
                            @include('ui::form.element.textarea',$textarea = $attributeRulesTextarea)
                            <hr>
{{--                            @include('ui::form.element.checkbox',$checkbox)--}}

                        </div>
                    </div>
                </div>
                @include('ui::form.element.submit')
            </form>
        </div>
    </div>
    <?php
    if(\Illuminate\Support\Facades\Session::get('attributes') != null){
     //   var_dump(\Illuminate\Support\Facades\Session::get('attributes'));
    }
    ?>

    {{HTML::script('http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js')}}
    {{HTML::style('http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css')}}
    {{ $table }}
@stop