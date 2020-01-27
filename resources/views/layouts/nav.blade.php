<div class="oa-mobile-menu">
    <a href="#" class="menubar" id="rocket_app_menu"><i class="ion ion-md-menu"></i></a>
</div>
<div class="oa-menubar" id="oa-mobile-menu">
    <ul class="list-unstyled d-flex align-items-center">
        @foreach(adminNav() as $key => $val)
            <li class="{{ $val['active'] }} ul_oa-menubar_li">
                <a href="{{  $val['link'] }}">
                    {{ $val['title'] }}
                </a>
                @if(isset($val['child']))
                    <ul class="list-unstyled dropdwon" id="menu_child">
                        @foreach($val['child'] as $key_c => $val_c)
                            <li>
                                <a target="{{ $val_c['target']  }}" href="{{  $val_c['link'] }}">
                                    {{ $val_c['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </li>
        @endforeach
    </ul>
</div>
