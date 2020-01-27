@section('popup')
    <div id="app-popup" class="app-popup d-none" v-show="showPopup">
        <div class="overlay"></div>
        <div class="app-popup-box">
            <div class="app-popup-header">
                <h6>Setup</h6>
                <a href="#" class="close-icon" v-on:click="setupPopup"><i class="ion ion-ios-close"></i></a>
            </div>
            <div class="app-popup-body">
                <setup-index-component></setup-index-component>
            </div>
        </div>
    </div>
@endsection
