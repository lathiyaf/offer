@extends('layouts.app')
@section("content")
    <div class="oa-main">
            <div class="oa-row">
                <div class="w-60 mb-xs-20">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <img src="/images/wel.png" />
                    </div>
                </div>
                <div class="w-40">
                    <h2 class="mb-3 text-center">Let's get you started. Your next steps are :</h2>
                    <div class="oa-box mb-20" style="min-height: auto;">
                        <div class="oa-box-body text-center">
                            <div class="cricle mb-1">1</div>
                            <p class="mb-0">Setup Quantity Break in your<br>
                                theme. </p>
                            <div class="d-flex justify-content-end"><a href="#" v-on:click="setupPopup" class="text-gray-700"><i class="ion ion-ios-arrow-round-forward h1"></i></a></div>
                        </div>
                    </div>
                    <div class="oa-box mb-20" style="min-height: auto;">
                        <div class="oa-box-body text-center">
                            <div class="cricle mb-1">2</div>
                            <p class="mb-0">Create your first ruleset for<br>
                                discount. </p>
                            <div class="d-flex justify-content-end"><a href="{{ route('offers.create') }}" class="text-gray-700"><i class="ion ion-ios-arrow-round-forward h1"></i></a></div>
                        </div>
                    </div>
                    <div class="oa-box mb-20" style="min-height: auto;">
                        <div class="oa-box-body text-center">
                            <div class="cricle mb-1">3</div>
                            <p class="mb-0">Visit an applicable product page, add the product
                                to cart then ensure the correct discount is
                                shown at checkout.</p>
                            <div class="d-flex justify-content-end"><a href="#" class="text-gray-700"><i class="ion ion-ios-arrow-round-forward h1"></i></a></div>
                        </div>
                    </div>
                </div>
                <div class="w-100">
                    <div class="oa-box mb-20" style="min-height: auto;">
                        <div class="oa-box-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="text-primary">Important Notes :</h2>
                            </div>
                        </div>
                        <div class="oa-box-body">
                            <ul class="mb-20" style="padding-left: 15px;">
                                <li class="font-size-lg">If your theme has an AJAX/popup cart and discounts aren't appearing, please contact support.</li>
                                <li class="font-size-lg">Quantity Breaks Now is not compatible with Checkout X app.</li>
                                <li class="font-size-lg">New Quantity Breaks Now now support certain type of discount codes.<a href="#" class="line-link">Learn more and enable discount codes</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="oa-footer">
        <div class="text-center">
            <need-help></need-help>
        </div>
    </div>
            <div id="app-popup" class="app-popup d-none" style="display:none" v-show="showPopup">
                <div class="overlay"></div>
                <div class="popup-container">
                    <div class="popup-head">
                        <h3 class="main-head">Choose the process that works for you</h3>
                        <p>Please pick one of the processes to update your Shopify theme with our app's unique code.</p>
                        <div class="close position-absolute">
                            <a href="#" class="close-icon" v-on:click="setupPopup"><i class="ion ion-ios-close"></i></a>
                        </div>
                    </div>
                    <div class="popup-body">

                            <div class="popup-row">

                                <div class="popup-row-item">
                                    <div class="install-option install-option-green">

                                        <div class="logo">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80">
                                                <g id="Group_102" data-name="Group 102" transform="translate(-752 -439)">
                                                    <g id="Ellipse_2" data-name="Ellipse 2" transform="translate(752 439)" fill="none" stroke="#00a9a2" stroke-width="1">
                                                        <circle cx="40" cy="40" r="40" stroke="none"></circle>
                                                        <circle cx="40" cy="40" r="39.5" fill="none"></circle>
                                                    </g>
                                                    <g id="support" transform="translate(748 459)">
                                                        <g id="Group_95" data-name="Group 95" transform="translate(51.781 30.938)">
                                                            <g id="Group_94" data-name="Group 94">
                                                                <path id="Path_9" data-name="Path 9" d="M356.781,396a.781.781,0,1,0,.781.781A.782.782,0,0,0,356.781,396Z" transform="translate(-356 -396)" fill="#00a9a2"></path>
                                                            </g>
                                                        </g>
                                                        <g id="Group_97" data-name="Group 97" transform="translate(26)">
                                                            <g id="Group_96" data-name="Group 96">
                                                                <path id="Path_10" data-name="Path 10" d="M54.486,28.411l-3.713-1.237L49.44,24.507a8.557,8.557,0,0,0,2.316-4.527l.166-1h1.422a2.346,2.346,0,0,0,2.344-2.344V11.719a11.719,11.719,0,0,0-23.437,0v4.922a2.348,2.348,0,0,0,1.563,2.209v.916a2.346,2.346,0,0,0,2.344,2.344h.686a8.476,8.476,0,0,0,1.31,2.029c.111.127.226.25.344.37l-1.332,2.665-3.713,1.238A11.515,11.515,0,0,0,26,39.219a.781.781,0,0,0,.781.781H61.156a.781.781,0,0,0,.781-.781A11.515,11.515,0,0,0,54.486,28.411Zm-.361-11.771a.782.782,0,0,1-.781.781H52.151c.2-1.538.331-3.175.384-4.788,0-.045,0-.09,0-.134h1.585Zm-19.531.781a.782.782,0,0,1-.781-.781V12.5H35.4q0,.122.008.246v.008h0c.055,1.568.185,3.163.379,4.667H34.594Zm1.563,3.125a.782.782,0,0,1-.781-.781v-.781h.64l.166,1c.032.189.071.378.116.566Zm-.78-9.609H33.842a10.157,10.157,0,0,1,20.253,0H52.561a7.913,7.913,0,0,0-7.893-7.812h-1.4A7.913,7.913,0,0,0,35.376,10.938Zm7.893-6.25h1.4A6.353,6.353,0,0,1,51,11.048c0,.246,0,.46-.006.655,0,0,0,.005,0,.008l-.977-.14a12.554,12.554,0,0,1-7.058-3.529.781.781,0,0,0-.552-.229,7.068,7.068,0,0,0-5.434,2.571A6.351,6.351,0,0,1,43.27,4.688ZM37.917,20.547a44.655,44.655,0,0,1-.937-7.582l1.051-1.4A5.5,5.5,0,0,1,42.1,9.384a14.131,14.131,0,0,0,7.7,3.733l1.15.164c-.077,1.632-.234,3.269-.459,4.775v0c-.072.484-.128.8-.272,1.666a6.636,6.636,0,0,1-4.71,5.337,6.147,6.147,0,0,1-6.9-2.951H40.2a2.347,2.347,0,0,0,2.209,1.563h1.563a2.344,2.344,0,0,0,0-4.687H42.406A2.345,2.345,0,0,0,40.2,20.547Zm4.423,6.095a7.836,7.836,0,0,0,2.906.065l-1.38,1.46Zm.451,2.661-2.478,2.62a29.766,29.766,0,0,1-1.749-4.056l.931-1.861Zm5.518-3.561,1.063,2.126a29.759,29.759,0,0,1-1.749,4.057l-2.652-2.652Zm-6.685-4.414a.781.781,0,0,1,.781-.781h1.563a.781.781,0,0,1,0,1.563H42.406A.782.782,0,0,1,41.625,21.328ZM27.594,38.438a9.873,9.873,0,0,1,6.352-8.544l3.289-1.1a31.318,31.318,0,0,0,2.224,4.823l0,.008h0A31.327,31.327,0,0,0,41.6,36.895l.961,1.543Zm16.375-.7-1.06-1.7q-.018-.029-.038-.056a29.788,29.788,0,0,1-1.76-2.63L43.9,30.408l2.936,2.936a29.755,29.755,0,0,1-1.766,2.64C45.028,36.035,45.082,35.955,43.969,37.741Zm1.407.7.961-1.543A31.315,31.315,0,0,0,48.49,33.6l.011-.021v0A31.292,31.292,0,0,0,50.7,28.8l3.289,1.1a9.873,9.873,0,0,1,6.352,8.544H45.376Z" transform="translate(-26)" fill="#00a9a2"></path>
                                                            </g>
                                                        </g>
                                                        <g id="Group_99" data-name="Group 99" transform="translate(54.527 32.429)">
                                                            <g id="Group_98" data-name="Group 98">
                                                                <path id="Path_11" data-name="Path 11" d="M394.608,417.936a7.811,7.811,0,0,0-2.212-2.685.781.781,0,0,0-.953,1.238,6.239,6.239,0,0,1,1.767,2.145.781.781,0,0,0,1.4-.7Z" transform="translate(-391.139 -415.088)" fill="#00a9a2"></path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="content">
                                            <h4>Expert Install</h4>
                                            <ul>
                                                <li>- Professional Setup Expert</li>
                                                <li>- Customize Installation</li>
                                                <li>- Premium Support</li>
                                            </ul>
                                        </div>
                                        <div class="first-step-btn">
                                            <button class="btn btn-block">Learn more</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="popup-row-item">
                                    <div class="install-option install-option-green">
                                        <div class="logo">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80">
                                                <g id="Group_100" data-name="Group 100" stroke="#00a9a2" transform="translate(-452 -439)">
                                                    <g id="Ellipse_1" data-name="Ellipse 1"  transform="translate(452 439)" fill="none" stroke="#00a9a2" stroke-width="1">
                                                        <circle cx="40" cy="40" r="40"></circle>
                                                        <circle cx="40" cy="40" r="39.5" fill="#"></circle>
                                                    </g>
                                                    <g id="robot" transform="translate(474.001 463)">
                                                        <path id="Path_12" data-name="Path 12" d="M33.925,14.2V7.52H23.958L27.372.976,25.5,0,21.579,7.52H14.42L10.5,0,8.627.976,12.041,7.52H2.073V14.2H0V25.45H2.073v6.68H33.925V25.45H36V14.2H33.925ZM31.816,30.02H4.183V9.629H31.816Zm0,0" fill="#00a9a2"></path>
                                                        <path id="Path_13" data-name="Path 13" d="M119.164,183.266A3.164,3.164,0,1,0,116,180.1,3.168,3.168,0,0,0,119.164,183.266Zm0-4.219a1.055,1.055,0,1,1-1.055,1.055A1.056,1.056,0,0,1,119.164,179.047Zm0,0" transform="translate(-107.844 -164.497)" fill="#00a9a2"></path>
                                                        <path id="Path_14" data-name="Path 14" d="M309.164,183.266A3.164,3.164,0,1,0,306,180.1,3.168,3.168,0,0,0,309.164,183.266Zm0-4.219a1.055,1.055,0,1,1-1.055,1.055A1.056,1.056,0,0,1,309.164,179.047Zm0,0" transform="translate(-284.485 -164.497)" fill="#00a9a2"></path>
                                                        <path id="Path_15" data-name="Path 15" d="M146,303.266h15.469v-6.328H146Zm2.109-4.219h11.25v2.109h-11.25Zm0,0" transform="translate(-135.735 -276.059)" fill="#00a9a2"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="content">
                                            <h4>Auto Install</h4>
                                            <div class="tooltip-width-text">
                                                Disclaimer
                                                <div class="custom-tooltip">
                                                    <i class="ion ion-md-help-circle"></i>
                                                    <div class="tooltip-text">Donec ornare felis sed nibh laoreet rhoncus.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="first-step-btn">
                                            <button v-on:click="show2Popup" class="btn btn-block">Start Now</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="popup-row-item">
                                    <div class="install-option">
                                        <div class="logo">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80">
                                                <g id="Group_104" data-name="Group 104" transform="translate(-1051 -439)">
                                                    <g id="Ellipse_3" data-name="Ellipse 3" transform="translate(1051 439)" fill="none" stroke="#00a9a2" stroke-width="1">
                                                        <circle cx="40" cy="40" r="40" stroke="none"></circle>
                                                        <circle cx="40" cy="40" r="39.5" fill="none"></circle>
                                                    </g>
                                                    <path id="book" d="M3.076,2.109H24V0H3.076A3.124,3.124,0,0,0,0,3.164V32.836A3.129,3.129,0,0,0,3.086,36H24V4.219H3.076A1.038,1.038,0,0,1,2.057,3.164,1.038,1.038,0,0,1,3.076,2.109ZM6.857,6.328h4.8v4.5l-2.4-1.477-2.4,1.477Zm-3.781,0H4.8v8.226l4.457-2.742,4.457,2.742V6.328h8.229V33.891H3.086a1.043,1.043,0,0,1-1.029-1.055V6.15a2.99,2.99,0,0,0,1.019.178Zm0,0" transform="translate(1079 461)" fill="#00a9a2"></path>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="content">
                                            <h4>Manual Install</h4>
                                            <div class="tooltip-width-text">
                                                Disclaimer
                                                <div class="custom-tooltip">
                                                    <i class="ion ion-md-help-circle"></i>
                                                    <div class="tooltip-text">Donec ornare felis sed nibh laoreet rhoncus.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="first-step-btn">
                                            <button class="btn btn-block">Installation Guide</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                    </div>
                    <div class="">
                        <div class="popup-head" > Copy the shortcode and add in the product page:
                            <div> Dropdown: <b> &lt;div class="crawlapps_offers crawlapps_offers_dropdown" &gt;&lt;/div&gt; </b> </div>
                            <div> Swatch: <b> &lt;div class="crawlapps_offers crawlapps_offers_swatch" &gt;&lt;/div&gt; </b>
                            </div>
                            <div> Grid: <b> &lt;div class="crawlapps_offers crawlapps_offers_gridview" &gt;&lt;/div&gt; </b>
                            </div>
                            <div> Example: <a href="https://prnt.sc/pso9pw" target="_blank">Open</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="automatic_install_section d-none" id="app-popup-install" style="display:none" v-show="showInstallPopup">
            <div class="overlay"></div>
                <div class="automatic_install_popup">
                <div class="close position-absolute">
                    <a href="#" id="close" v-on:click="show2Popup" class="cancel font-weight-bold d-block text-center text-body">×</a>
                </div>
                <div class="install_section-text">
                    <setup-index-component
                        props-url = "{{
                            json_encode([
                                    "index" => route("setup.index"),
                                    "store" => route("setup.store"),
                            ],JSON_HEX_APOS)
                            }}"
                        props-trans = "{{ json_encode([],JSON_HEX_APOS)}}"
                        props-data = "{{ json_encode(['theme'=> $data],JSON_HEX_APOS)}}"
                    ></setup-index-component>
                </div>
                </div>
            </div>
@endsection
