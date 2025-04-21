@extends('errors::minimal')

@section('title', __('メンテナンス中'))
{{--  @section('code', '503')  --}}
@section('message', __($exception->getMessage() ?: 'ただいまメンテナンス中です'))
