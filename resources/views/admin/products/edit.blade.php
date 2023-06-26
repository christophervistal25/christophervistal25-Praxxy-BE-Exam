@extends('layouts.app')
@section('content')
    <product-wizard mode="Edit" :product-id="{{ $productId }}" />
@endsection