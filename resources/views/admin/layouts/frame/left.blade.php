<aside id="left-panel">
    <div class="login-info">
		<span>
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				<img src="{{ asset('smart/img/avatars/sunny.png') }}" alt="me" class="online" />
				<span>
					{{$adminUser->name}}
				</span>
				<i class="fa fa-angle-down"></i>
			</a>
			<span style="float: right;"><a href="{{route('logout')}}">登出</a></span>
		</span>

    </div>
    <nav>
		<ul>
		@foreach ($menu as $id => $m)
			<li>
				<a href="#">
					<i class="@if(isset($m["css_class"])){{$m["css_class"]}}@endif"></i>
					<span class="menu-item-parent">{{$m['title']}} </span>
					<b class="collapse-sign"></b>
				</a>
				@if (isset($m['child']) && count($m['child']) > 0)
					<ul style="display: none;">
						@foreach ($m['child'] as $index => $m_c)
							<li>
								<a target="mainFrame" href="{{route($m_c->route)}}">{{ $m_c->title }}</a>
							</li>
						@endforeach
					</ul>
				@endif
			</li>
		@endforeach
		</ul>
    </nav>
    <span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>
</aside>