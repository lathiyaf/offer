@extends('layouts.app')
@section("content")
    @if($counter)
    <offers-list-component
        props-url = "{{
                json_encode([
                        "index" => route("offers.index"),
                        "getProducts" => route("offers.getProducts"),
                        "create" => route("offers.create"),
                        "edit" => route("offers.edit",['__']),
                        "status" => route("offers.status",['__']),
                        "update" => route("offers.update",['__']),
                        "store" => route("offers.store"),
                        "delete" => route("offers.delete",['__']),
                ],JSON_HEX_APOS)
                }}"
        props-trans = "{{ json_encode([],JSON_HEX_APOS)}}"
        props-data = "{{ json_encode([],JSON_HEX_APOS)}}"
    ></offers-list-component>
    @else
        <div class="oa-main">
            <div class="d-flex align-items-start mb-4">
                <h1 class="mb-0">Ruleset</h1>
            </div>
            <div class="oa-row">
                <div class="w-50">
                    <div class="oa-box mb-20">
                        <div class="oa-box-body" style="padding-top: 2rem;">
                            <h1 class="mb-1">It seem's that you don't have
                                any Ruleset.</h1>
                            <p class="text-gray-700 mb-20">Click on the button below to create a new ruleset.</p>
                            <a href="{{ route('offers.create') }}" class="btn">Create Ruleset</a>
                        </div>
                    </div>

                </div>
                <div class="w-50">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <img src="/images/rulaset-img.png" />
                    </div>
                </div>
            </div>
        </div>
        <div class="oa-footer">
            <div class="text-center">
                <div class="offer-create-footer">
                    <i class="ion ion-ios-alert"></i>Need help? Visit <a href="#">our Support center</a>
                </div>
            </div>
        </div>
    @endif
@endsection
