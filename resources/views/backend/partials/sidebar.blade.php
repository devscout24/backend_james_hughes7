<!-- navbar vertical -->
<div class="app-menu">
    <div class="navbar-vertical navbar nav-dashboard">
        <div class="h-100" data-simplebar>
            <!-- Brand logo -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img
                    src="{{ isset($admin_setting->logo) ? asset($admin_setting->logo) : asset('uploads/default.png') }}" />
            </a>
            <!-- Navbar nav -->
            <ul class="navbar-nav flex-column" id="sideNavbar">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i data-feather="home" class="nav-icon me-2 icon-xxs"></i> <!-- Changed icon -->
                        Dashboard
                    </a>
                </li>

                {{-- Asset Management --}}
                <li class="nav-item {{ request()->routeIs('assettype.*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#roleManagementCollapse"
                        aria-expanded="{{ request()->routeIs('assettype.*') ? 'true' : 'false' }}"
                        aria-controls="roleManagementCollapse">
                        <i data-feather="cpu" class="nav-icon me-2 icon-xxs"></i> <!-- Changed icon -->
                        Asset Management
                    </a>

                    <div id="roleManagementCollapse"
                        class="collapse {{ request()->routeIs('assettype.*') ? 'show' : '' }}"
                        data-bs-parent="#sidebarMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('assettype*') ? 'active' : '' }}"
                                    href="{{ route('assettype.index') }}">
                                    Asset Set
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Condition Management --}}
                <li class="nav-item {{ request()->routeIs('condition.*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#conditionMangement"
                        aria-expanded="{{ request()->routeIs('condition.*') ? 'true' : 'false' }}"
                        aria-controls="conditionMangement">
                        <i data-feather="activity" class="nav-icon me-2 icon-xxs"></i> <!-- Changed icon -->
                        Condition Management
                    </a>

                    <div id="conditionMangement"
                        class="collapse {{ request()->routeIs('condition.*') ? 'show' : '' }}"
                        data-bs-parent="#sidebarMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('condition*') ? 'active' : '' }}"
                                    href="{{ route('condition.index') }}">
                                    Condition Set
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Situation Management --}}
                <li class="nav-item {{ request()->routeIs('title.*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#titleMangement"
                        aria-expanded="{{ request()->routeIs('title.*') ? 'true' : 'false' }}"
                        aria-controls="titleMangement">
                        <i data-feather="file-text" class="nav-icon me-2 icon-xxs"></i> <!-- Changed icon -->
                        Situation Management
                    </a>

                    <div id="titleMangement"
                        class="collapse {{ request()->routeIs('title.*') ? 'show' : '' }}"
                        data-bs-parent="#sidebarMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('title*') ? 'active' : '' }}"
                                    href="{{ route('title.index') }}">
                                    Title Situation Set
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Lead Management --}}
                <li class="nav-item {{ request()->routeIs('lead.manage*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#leadMangement"
                        aria-expanded="{{ request()->routeIs('lead.manage*') ? 'true' : 'false' }}"
                        aria-controls="leadMangement">
                        <i data-feather="users" class="nav-icon me-2 icon-xxs"></i> <!-- Changed icon -->
                        Lead Management
                    </a>

                    <div id="leadMangement"
                        class="collapse {{ request()->routeIs('lead.manage*') ? 'show' : '' }}"
                        data-bs-parent="#sidebarMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('lead.manage*') ? 'active' : '' }}"
                                    href="{{ route('lead.manage.index') }}">
                                    Lead Management
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Dynamic Pages --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dynamic-pages.index') }}">
                        <i class="bi bi-file-earmark-code fs-4 me-2"></i> <!-- Changed icon -->
                        Dynamic Pages
                    </a>
                </li>

                {{-- Settings --}}
                <li
                    class="nav-item {{ request()->routeIs('profile.*', 'mail.*', 'system.*', 'admin.*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" href="" data-bs-toggle="collapse"
                        data-bs-target="#settingsCollapse"
                        aria-expanded="{{ request()->routeIs('profile.*', 'mail.*', 'system.*', 'admin.*') ? 'true' : 'false' }}"
                        aria-controls="settingsCollapse">
                        <i data-feather="settings" class="nav-icon me-2 icon-xxs"></i> <!-- Keep icon -->
                        Settings
                    </a>

                    <div id="settingsCollapse"
                        class="collapse {{ request()->routeIs('profile.*', 'mail.*', 'system.*', 'admin.*') ? 'show' : '' }}"
                        data-bs-parent="#sidebarMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                                    href="{{ route('profile.index') }}">
                                    Profile Setting
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.setting.index') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.index') }}">
                                    Admin Setting
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('mail.index') ? 'active' : '' }}"
                                    href="{{ route('mail.index') }}">
                                    Mail Setting
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>

        </div>
    </div>
</div>
