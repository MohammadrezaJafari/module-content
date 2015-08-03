@extends('master')

@section('content')
    <a href="{{$url}}" class="btn btn-success">افزودن محتوای جدید</a>
    <br>    <br>    <br>    <br>
    {{HTML::script('http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js')}}
    {{HTML::style('http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css')}}
    {{ $table }}
@stop