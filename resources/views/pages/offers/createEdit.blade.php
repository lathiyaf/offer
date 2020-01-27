@extends('layouts.app')
@section("content")
    <offers-createedit-component
        props-url = "{{
                json_encode([
                        "index" => route("offers.index"),
                        "getProducts" => route("offers.getProducts"),
                        "create" => route("offers.create"),
                        "edit" => route("offers.edit",['__']),
                        "update" => route("offers.update",['__']),
                        "store" => route("offers.store"),
                        "check" => route("offers.check"),
                        "deleteProduct" => route("offers.deleteProduct"),
                ],JSON_HEX_APOS)
                }}"
        props-trans = "{{ json_encode([],JSON_HEX_APOS)}}"
        props-data = "{{ json_encode([
                        'currentRoute' => \Request::route()->uri,
                        'entity' => @$data['entity'],
                ],JSON_HEX_APOS)
        }}"
    ></offers-createedit-component>
@endsection
