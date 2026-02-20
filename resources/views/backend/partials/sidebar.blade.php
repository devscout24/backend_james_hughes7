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
                          <i data-feather="bar-chart-2" class="nav-icon me-2 icon-xxs"></i>
                          Dashboard
                      </a>
                  </li>
























                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('dynamic-pages.index') }}">
                          <i class="bi bi-file-earmark-text fs-4 me-2"></i>
                          Dynamic Pages
                      </a>
                  </li>




















                  {{-- Role Management --}}
                  <li class="nav-item {{ request()->routeIs('assettype.*') ? 'active' : '' }}">
                      <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#roleManagementCollapse"
                          aria-expanded="{{ request()->routeIs('assettype.*') ? 'true' : 'false' }}"
                          aria-controls="roleManagementCollapse">
                          <i data-feather="shield" class="nav-icon me-2 icon-xxs"></i>
                          Asset Mangement
                      </a>

                      <div id="roleManagementCollapse"
                          class="collapse {{ request()->routeIs('assettype.*') ? 'show' : '' }}"
                          data-bs-parent="#sidebarMenu">

                          <ul class="nav flex-column ms-3">
                              {{-- Users --}}
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('assettype*') ? 'active' : '' }}"
                                      href="{{ route('assettype.index') }}">
                                      Asset set
                                  </a>
                              </li>


                          </ul>
                      </div>
                  </li>




                   {{-- Role Management --}}
                  <li class="nav-item {{ request()->routeIs('condition.*') ? 'active' : '' }}">
                      <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#conditionMangement"
                          aria-expanded="{{ request()->routeIs('condition.*') ? 'true' : 'false' }}"
                          aria-controls="conditionMangement">
                          <i data-feather="shield" class="nav-icon me-2 icon-xxs"></i>
                          Condition Management
                      </a>

                      <div id="conditionMangement"
                          class="collapse {{ request()->routeIs('condition.*') ? 'show' : '' }}"
                          data-bs-parent="#sidebarMenu">

                          <ul class="nav flex-column ms-3">
                              {{-- Users --}}
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('condition*') ? 'active' : '' }}"
                                      href="{{ route('condition.index') }}">
                                      Condition Set
                                  </a>
                              </li>


                          </ul>
                      </div>
                    </li>


                   <li class="nav-item {{ request()->routeIs('title.*') ? 'active' : '' }}">
                      <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#titleMangement"
                          aria-expanded="{{ request()->routeIs('title.*') ? 'true' : 'false' }}"
                          aria-controls="titleMangement">
                          <i data-feather="shield" class="nav-icon me-2 icon-xxs"></i>
                         Situation Management
                      </a>

                      <div id="titleMangement"
                          class="collapse {{ request()->routeIs('title.*') ? 'show' : '' }}"
                          data-bs-parent="#sidebarMenu">

                          <ul class="nav flex-column ms-3">
                              {{-- Users --}}
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('title*') ? 'active' : '' }}"
                                      href="{{ route('title.index') }}">
                                      Title Situation Set
                                  </a>
                              </li>


                          </ul>
                      </div>
                    </li>





                  {{-- Settings --}}
                  <li
                      class="nav-item {{ request()->routeIs('profile.*', 'mail.*', 'system.*', 'admin.*') ? 'active' : '' }}">
                      <a class="nav-link has-arrow" href="" data-bs-toggle="collapse"
                          data-bs-target="#settingsCollapse"
                          aria-expanded="{{ request()->routeIs('profile.*', 'mail.*', 'system.*', 'admin.*') ? 'true' : 'false' }}"
                          aria-controls="settingsCollapse">
                          <i data-feather="settings" class="nav-icon me-2 icon-xxs"></i>Settings
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
                                  <a class="nav-link {{ request()->routeIs('system.index') ? 'active' : '' }}"
                                      href="{{ route('system.index') }}">
                                      Website Setting
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
