@extends('layouts.app')
@section("content")
    <dashboard-index-component
        props-url = "{{
                json_encode([
                        "index" => route("home"),
                        "index_offer" => route("offers.index"),
                ],JSON_HEX_APOS)
                }}"
        props-trans = "{{ json_encode([],JSON_HEX_APOS)}}"
        props-data = "{{ json_encode([
            'firstsaledate' => $firstSaleDate,
        ],JSON_HEX_APOS)}}"
    ></dashboard-index-component>
@endsection
