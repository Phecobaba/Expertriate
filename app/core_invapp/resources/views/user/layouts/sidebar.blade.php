@php
    $supportSlug = sys_settings('page_contact') ? get_page_slug(sys_settings('page_contact')) : null;
    $supportUrl = $supportSlug ? route('show.page', $supportSlug) : route('dashboard');
    $referralUrl = has_route('referrals')
        ? route('referrals')
        : (has_route('auth.invite') ? route('auth.invite') : route('dashboard'));
@endphp
<div class="nk-sidebar nk-sidebar-fat nk-sidebar-fixed is-dark" data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        {{ site_branding('sidebar', ['panel' => 'user', 'size' => 'md', 'class_link' => 'nk-sidebar-logo']) }}
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
        </div>
    </div>

    <div class="nk-sidebar-element">
        <div class="nk-sidebar-body">
            <div class="nk-sidebar-content">
                <div class="nk-sidebar-widget pt-2">
                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom border-transparent">
                        <div class="user-avatar sq md bg-primary mr-2"><span>{!! user_avatar(auth()->user()) !!}</span></div>
                        <div class="min-w-0">
                            <h6 class="mb-0 text-white">{{ auth()->user()->display_name ?: auth()->user()->name }}</h6>
                            <div class="text-soft small">{{ auth()->user()->email }}</div>
                            <div class="small {{ auth()->user()->is_verified ? 'text-success' : 'text-warning' }}">
                                {{ __('KYC Status') }}: {{ auth()->user()->is_verified ? __('verified') : __('pending') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nk-sidebar-menu">
                    <ul class="nk-menu">
                        <li class="nk-menu-heading"><h6 class="overline-title">{{ __('Menu') }}</h6></li>
                        <li class="nk-menu-item{{ is_route('dashboard') ? ' active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                                <span class="nk-menu-text">{{ __('Dashboard') }}</span>
                            </a>
                        </li>

                        <li class="nk-menu-item{{ is_route('transaction.list') ? ' active' : '' }}">
                            <a href="{{ route('transaction.list') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                                <span class="nk-menu-text">{{ __('Transaction') }}</span>
                            </a>
                        </li>

                        <li class="nk-menu-item{{ has_route('user.investment.dashboard') && is_route('user.investment.dashboard') ? ' active' : '' }}">
                            <a href="{{ has_route('user.investment.dashboard') ? route('user.investment.dashboard') : (has_route('user.investment.plans') ? route('user.investment.plans') : route('dashboard')) }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-invest"></em></span>
                                <span class="nk-menu-text">{{ __('Investment') }}</span>
                            </a>
                        </li>

                        @if(has_route('user.investment.plans'))
                        <li class="nk-menu-item{{ is_route('user.investment.plans') ? ' active' : '' }}">
                            <a href="{{ route('user.investment.plans') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-exchange"></em></span>
                                <span class="nk-menu-text">{{ __('Our Plans') }}</span>
                            </a>
                        </li>
                        @endif

                        <li class="nk-menu-item{{ is_route('account.profile') ? ' active' : '' }}">
                            <a href="{{ route('account.profile') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-user-alt"></em></span>
                                <span class="nk-menu-text">{{ __('My Profile') }}</span>
                            </a>
                        </li>
                        @if (has_route('referrals'))
                        <li class="nk-menu-item{{ is_route('referrals') ? ' active' : '' }}">
                            <a href="{{ $referralUrl }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-share"></em></span>
                                <span class="nk-menu-text">{{ __('Referrals') }}</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>

                <div class="nk-sidebar-widget mt-2 mb-2">
                    <div class="p-3 rounded neo-skin-callout">
                        <h6 class="text-primary mb-1">{{ __('Ready to Grow?') }}</h6>
                        <p class="text-soft small mb-2">{{ __('Start your trading journey today and watch your portfolio expand.') }}</p>
                        <a href="{{ has_route('user.investment.plans') ? route('user.investment.plans') : route('dashboard') }}" class="btn btn-sm btn-primary btn-block">{{ __('Start Trading') }}</a>
                    </div>
                </div>

                <div class="nk-sidebar-footer">
                    <ul class="nk-menu nk-menu-footer">
                        <li class="nk-menu-item">
                            <a href="{{ $supportUrl }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-help-alt"></em></span>
                                <span class="nk-menu-text">{{ __('Support') }}</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{ route('auth.logout') }}" class="nk-menu-link" onclick="event.preventDefault();document.getElementById('sidebar-logout-form').submit();">
                                <span class="nk-menu-icon"><em class="icon ni ni-signout"></em></span>
                                <span class="nk-menu-text">{{ __('Logout') }}</span>
                            </a>
                        </li>
                        {!! Panel::lang_switcher('sidebar', ['class' => 'ml-auto']) !!}
                    </ul>
                    <form id="sidebar-logout-form" action="{{ route('auth.logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
