@php
    $is = fn (...$p) => request()->routeIs(...$p) ? 'active' : '';
    $open = fn (...$p) => request()->routeIs(...$p) ? 'active open' : '';
@endphp
<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('images/magic-pages-logo.png') }}" alt="Magic Pages" width="40" height="40"
                    style="border-radius: 50%;" />
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-3">Magic Pages</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
            <i class="icon-base ti tabler-x d-block d-xl-none"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ $is('admin.dashboard') }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-smart-home"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- ============ MANAGEMENT ============ -->
        <li class="menu-header small"><span class="menu-header-text">Management</span></li>
        <li class="menu-item {{ $open('admin.products.*', 'admin.product-categories.*', 'admin.orders.*') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-shopping-cart"></i>
                <div>Store</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $is('admin.products.*') }}">
                    <a href="{{ route('admin.products.index') }}" class="menu-link"><div>Products</div></a>
                </li>
                <li class="menu-item {{ $is('admin.product-categories.*') }}">
                    <a href="{{ route('admin.product-categories.index') }}" class="menu-link"><div>Product Categories</div></a>
                </li>
                <li class="menu-item {{ $is('admin.orders.*') }}">
                    <a href="{{ route('admin.orders.index') }}" class="menu-link"><div>Orders</div></a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ $open('admin.feed-posts.*', 'admin.ideas.*', 'admin.consultations.*', 'admin.reports.*') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-news"></i>
                <div>Content</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $is('admin.feed-posts.*') }}">
                    <a href="{{ route('admin.feed-posts.index') }}" class="menu-link"><div>Feed Posts</div></a>
                </li>
                <li class="menu-item {{ $is('admin.ideas.*') }}">
                    <a href="{{ route('admin.ideas.index') }}" class="menu-link"><div>Ideas</div></a>
                </li>
                <li class="menu-item {{ $is('admin.consultations.*') }}">
                    <a href="{{ route('admin.consultations.index') }}" class="menu-link"><div>Consultations</div></a>
                </li>
                <li class="menu-item {{ $is('admin.reports.*') }}">
                    <a href="{{ route('admin.reports.index') }}" class="menu-link"><div>User Reports</div></a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ $open('admin.coaching-sessions.*', 'admin.bookings.*') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-calendar-event"></i>
                <div>Coaching</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $is('admin.coaching-sessions.*') }}">
                    <a href="{{ route('admin.coaching-sessions.index') }}" class="menu-link"><div>Sessions</div></a>
                </li>
                <li class="menu-item {{ $is('admin.bookings.*') }}">
                    <a href="{{ route('admin.bookings.index') }}" class="menu-link"><div>Bookings</div></a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ $open('admin.academic-subjects.*', 'admin.academic-plannings.*', 'admin.badges.*') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-book"></i>
                <div>Academy</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $is('admin.academic-subjects.*') }}">
                    <a href="{{ route('admin.academic-subjects.index') }}" class="menu-link"><div>Subjects</div></a>
                </li>
                <li class="menu-item {{ $is('admin.academic-plannings.*') }}">
                    <a href="{{ route('admin.academic-plannings.index') }}" class="menu-link"><div>Academic Plannings</div></a>
                </li>
                <li class="menu-item {{ $is('admin.badges.*') }}">
                    <a href="{{ route('admin.badges.index') }}" class="menu-link"><div>Badges</div></a>
                </li>
            </ul>
        </li>

        <!-- ============ MEMBERS ============ -->
        <li class="menu-header small"><span class="menu-header-text">Members</span></li>
        <li class="menu-item {{ $is('admin.users.*') }}">
            <a href="{{ route('admin.users.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-users"></i>
                <div>Users</div>
            </a>
        </li>
        <li class="menu-item {{ $open('admin.skills.*', 'admin.goals.*') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-target-arrow"></i>
                <div>Growth</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $is('admin.skills.*') }}">
                    <a href="{{ route('admin.skills.index') }}" class="menu-link"><div>User Skills</div></a>
                </li>
                <li class="menu-item {{ $is('admin.goals.*') }}">
                    <a href="{{ route('admin.goals.index') }}" class="menu-link"><div>User Goals</div></a>
                </li>
            </ul>
        </li>

        <!-- ============ SYSTEM ============ -->
        <li class="menu-header small"><span class="menu-header-text">System</span></li>
        <li class="menu-item {{ $open('admin.skill-types.*', 'admin.consultation-categories.*') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-category"></i>
                <div>Catalog</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $is('admin.skill-types.*') }}">
                    <a href="{{ route('admin.skill-types.index') }}" class="menu-link"><div>Skill Types</div></a>
                </li>
                <li class="menu-item {{ $is('admin.consultation-categories.*') }}">
                    <a href="{{ route('admin.consultation-categories.index') }}" class="menu-link"><div>Consultation Categories</div></a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ $open('admin.countries.*', 'admin.qualifications.*', 'admin.work-styles.*', 'admin.employment-statuses.*', 'admin.categories.*', 'admin.sub-categories.*') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-database-cog"></i>
                <div>Reference Data</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $is('admin.countries.*') }}">
                    <a href="{{ route('admin.countries.index') }}" class="menu-link"><div>Countries</div></a>
                </li>
                <li class="menu-item {{ $is('admin.qualifications.*') }}">
                    <a href="{{ route('admin.qualifications.index') }}" class="menu-link"><div>Qualifications</div></a>
                </li>
                <li class="menu-item {{ $is('admin.work-styles.*') }}">
                    <a href="{{ route('admin.work-styles.index') }}" class="menu-link"><div>Work Styles</div></a>
                </li>
                <li class="menu-item {{ $is('admin.employment-statuses.*') }}">
                    <a href="{{ route('admin.employment-statuses.index') }}" class="menu-link"><div>Employment Statuses</div></a>
                </li>
                <li class="menu-item {{ $is('admin.categories.*') }}">
                    <a href="{{ route('admin.categories.index') }}" class="menu-link"><div>Categories</div></a>
                </li>
                <li class="menu-item {{ $is('admin.sub-categories.*') }}">
                    <a href="{{ route('admin.sub-categories.index') }}" class="menu-link"><div>Sub-Categories</div></a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
<!-- / Menu -->
