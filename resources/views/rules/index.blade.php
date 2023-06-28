@extends('layouts.master')

@section('content')
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sidenav shadow-right sidenav-light">
            <div class="sidenav-menu">
                <div class="nav accordion" id="accordionSidenav">
                    <!-- Sidenav Menu Heading (Account)-->
                    <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                    <div class="sidenav-menu-heading d-sm-none">Account</div>
                    <!-- Sidenav Link (Alerts)-->
                    <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                    <a class="nav-link d-sm-none" href="#!">
                        <div class="nav-link-icon"><i data-feather="bell"></i></div>
                        Alerts
                        <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
                    </a>
                    <!-- Sidenav Link (Messages)-->
                    <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                    <a class="nav-link d-sm-none" href="#!">
                        <div class="nav-link-icon"><i data-feather="mail"></i></div>
                        Messages
                        <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
                    </a>
                    <!-- Sidenav Menu Heading (Core)-->
                    <div class="sidenav-menu-heading">Core</div>
                    <!-- Sidenav Accordion (Dashboard)-->
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                        <div class="nav-link-icon"><i data-feather="activity"></i></div>
                        Dashboards
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseDashboards" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                            <a class="nav-link" href="dashboard-1.html">
                                Default
                                <span class="badge bg-primary-soft text-primary ms-auto">Updated</span>
                            </a>
                            <a class="nav-link" href="dashboard-2.html">Multipurpose</a>
                            <a class="nav-link" href="dashboard-3.html">Affiliate</a>
                        </nav>
                    </div>
                    <!-- Sidenav Heading (App Views)-->
                    <div class="sidenav-menu-heading">App Views</div>
                    <!-- Sidenav Accordion (Pages)-->
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                        <div class="nav-link-icon"><i data-feather="grid"></i></div>
                        Pages
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                            <!-- Nested Sidenav Accordion (Pages -> Account)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAccount" aria-expanded="false" aria-controls="pagesCollapseAccount">
                                Account
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAccount" data-bs-parent="#accordionSidenavPagesMenu">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link" href="account-profile.html">Profile</a>
                                    <a class="nav-link" href="account-billing.html">Billing</a>
                                    <a class="nav-link" href="account-security.html">Security</a>
                                    <a class="nav-link" href="account-notifications.html">Notifications</a>
                                </nav>
                            </div>
                            <!-- Nested Sidenav Accordion (Pages -> Authentication)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                Authentication
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth" data-bs-parent="#accordionSidenavPagesMenu">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesAuth">
                                    <!-- Nested Sidenav Accordion (Pages -> Authentication -> Basic)-->
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuthBasic" aria-expanded="false" aria-controls="pagesCollapseAuthBasic">
                                        Basic
                                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuthBasic" data-bs-parent="#accordionSidenavPagesAuth">
                                        <nav class="sidenav-menu-nested nav">
                                            <a class="nav-link" href="auth-login-basic.html">Login</a>
                                            <a class="nav-link" href="auth-register-basic.html">Register</a>
                                            <a class="nav-link" href="auth-password-basic.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <!-- Nested Sidenav Accordion (Pages -> Authentication -> Social)-->
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuthSocial" aria-expanded="false" aria-controls="pagesCollapseAuthSocial">
                                        Social
                                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuthSocial" data-bs-parent="#accordionSidenavPagesAuth">
                                        <nav class="sidenav-menu-nested nav">
                                            <a class="nav-link" href="auth-login-social.html">Login</a>
                                            <a class="nav-link" href="auth-register-social.html">Register</a>
                                            <a class="nav-link" href="auth-password-social.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <!-- Nested Sidenav Accordion (Pages -> Error)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                Error
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseError" data-bs-parent="#accordionSidenavPagesMenu">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link" href="error-400.html">400 Error</a>
                                    <a class="nav-link" href="error-401.html">401 Error</a>
                                    <a class="nav-link" href="error-403.html">403 Error</a>
                                    <a class="nav-link" href="error-404-1.html">404 Error 1</a>
                                    <a class="nav-link" href="error-404-2.html">404 Error 2</a>
                                    <a class="nav-link" href="error-500.html">500 Error</a>
                                    <a class="nav-link" href="error-503.html">503 Error</a>
                                    <a class="nav-link" href="error-504.html">504 Error</a>
                                </nav>
                            </div>
                            <!-- Nested Sidenav Accordion (Pages -> Knowledge Base)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseKnowledgeBase" aria-expanded="false" aria-controls="pagesCollapseKnowledgeBase">
                                Knowledge Base
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseKnowledgeBase" data-bs-parent="#accordionSidenavPagesMenu">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link" href="knowledge-base-home-1.html">Home 1</a>
                                    <a class="nav-link" href="knowledge-base-home-2.html">Home 2</a>
                                    <a class="nav-link" href="knowledge-base-category.html">Category</a>
                                    <a class="nav-link" href="knowledge-base-article.html">Article</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="pricing.html">Pricing</a>
                            <a class="nav-link" href="invoice.html">Invoice</a>
                        </nav>
                    </div>
                    <!-- Sidenav Accordion (Flows)-->
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFlows" aria-expanded="false" aria-controls="collapseFlows">
                        <div class="nav-link-icon"><i data-feather="repeat"></i></div>
                        Flows
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseFlows" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="multi-tenant-select.html">Multi-Tenant Registration</a>
                            <a class="nav-link" href="wizard.html">Wizard</a>
                        </nav>
                    </div>
                    <!-- Sidenav Heading (UI Toolkit)-->
                    <div class="sidenav-menu-heading">UI Toolkit</div>
                    <!-- Sidenav Accordion (Layout)-->
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="nav-link-icon"><i data-feather="layout"></i></div>
                        Layout
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                            <!-- Nested Sidenav Accordion (Layout -> Navigation)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayoutSidenavVariations" aria-expanded="false" aria-controls="collapseLayoutSidenavVariations">
                                Navigation
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayoutSidenavVariations" data-bs-parent="#accordionSidenavLayout">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Sidenav</a>
                                    <a class="nav-link" href="layout-dark.html">Dark Sidenav</a>
                                    <a class="nav-link" href="layout-rtl.html">RTL Layout</a>
                                </nav>
                            </div>
                            <!-- Nested Sidenav Accordion (Layout -> Container Options)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayoutContainers" aria-expanded="false" aria-controls="collapseLayoutContainers">
                                Container Options
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayoutContainers" data-bs-parent="#accordionSidenavLayout">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-boxed.html">Boxed Layout</a>
                                    <a class="nav-link" href="layout-fluid.html">Fluid Layout</a>
                                </nav>
                            </div>
                            <!-- Nested Sidenav Accordion (Layout -> Page Headers)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsPageHeaders" aria-expanded="false" aria-controls="collapseLayoutsPageHeaders">
                                Page Headers
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayoutsPageHeaders" data-bs-parent="#accordionSidenavLayout">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link" href="header-simplified.html">Simplified</a>
                                    <a class="nav-link" href="header-compact.html">Compact</a>
                                    <a class="nav-link" href="header-overlap.html">Content Overlap</a>
                                    <a class="nav-link" href="header-breadcrumbs.html">Breadcrumbs</a>
                                    <a class="nav-link" href="header-light.html">Light</a>
                                </nav>
                            </div>
                            <!-- Nested Sidenav Accordion (Layout -> Starter Layouts)-->
                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsStarterTemplates" aria-expanded="false" aria-controls="collapseLayoutsStarterTemplates">
                                Starter Layouts
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayoutsStarterTemplates" data-bs-parent="#accordionSidenavLayout">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link" href="starter-default.html">Default</a>
                                    <a class="nav-link" href="starter-minimal.html">Minimal</a>
                                </nav>
                            </div>
                        </nav>
                    </div>
                    <!-- Sidenav Accordion (Components)-->
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseComponents" aria-expanded="false" aria-controls="collapseComponents">
                        <div class="nav-link-icon"><i data-feather="package"></i></div>
                        Components
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseComponents" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="alerts.html">Alerts</a>
                            <a class="nav-link" href="avatars.html">Avatars</a>
                            <a class="nav-link" href="badges.html">Badges</a>
                            <a class="nav-link" href="buttons.html">Buttons</a>
                            <a class="nav-link" href="cards.html">
                                Cards
                                <span class="badge bg-primary-soft text-primary ms-auto">Updated</span>
                            </a>
                            <a class="nav-link" href="dropdowns.html">Dropdowns</a>
                            <a class="nav-link" href="forms.html">
                                Forms
                                <span class="badge bg-primary-soft text-primary ms-auto">Updated</span>
                            </a>
                            <a class="nav-link" href="modals.html">Modals</a>
                            <a class="nav-link" href="navigation.html">Navigation</a>
                            <a class="nav-link" href="progress.html">Progress</a>
                            <a class="nav-link" href="step.html">Step</a>
                            <a class="nav-link" href="timeline.html">Timeline</a>
                            <a class="nav-link" href="toasts.html">Toasts</a>
                            <a class="nav-link" href="tooltips.html">Tooltips</a>
                        </nav>
                    </div>
                    <!-- Sidenav Accordion (Utilities)-->
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
                        <div class="nav-link-icon"><i data-feather="tool"></i></div>
                        Utilities
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseUtilities" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="animations.html">Animations</a>
                            <a class="nav-link" href="background.html">Background</a>
                            <a class="nav-link" href="borders.html">Borders</a>
                            <a class="nav-link" href="lift.html">Lift</a>
                            <a class="nav-link" href="shadows.html">Shadows</a>
                            <a class="nav-link" href="typography.html">Typography</a>
                        </nav>
                    </div>
                    <!-- Sidenav Heading (Addons)-->
                    <div class="sidenav-menu-heading">Plugins</div>
                    <!-- Sidenav Link (Charts)-->
                    <a class="nav-link" href="charts.html">
                        <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                        Charts
                    </a>
                    <!-- Sidenav Link (Tables)-->
                    <a class="nav-link" href="tables.html">
                        <div class="nav-link-icon"><i data-feather="filter"></i></div>
                        Tables
                    </a>
                </div>
            </div>
            <!-- Sidenav Footer-->
            <div class="sidenav-footer">
                <div class="sidenav-footer-content">
                    <div class="sidenav-footer-subtitle">Logged in as:</div>
                    <div class="sidenav-footer-title">Valerie Luna</div>
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <header class="py-10 mb-4 bg-gradient-primary-to-secondary">
                <div class="container-xl px-4">
                    <div class="text-center">
                        <h1 class="text-white">Welcome to SB Admin Pro</h1>
                        <p class="lead mb-0 text-white-50">A professionally designed admin panel template built with Bootstrap 5</p>
                    </div>
                </div>
            </header>
            <!-- Main page content-->
            <div class="container-xl px-4">
                <h2 class="mt-5 mb-0">Dashboards</h2>
                <p>Three dashboard examples to get you started!</p>
                <hr class="mt-0 mb-4" />
                <div class="row">
                    <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="dashboard-1.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/dashboards/default.png" alt="..." /></a>
                        <div class="text-center small">Default Dashboard</div>
                    </div>
                    <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="dashboard-3.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/dashboards/affiliate.png" alt="..." /></a>
                        <div class="text-center small">Affiliate Dashboard</div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="dashboard-2.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/dashboards/multipurpose.png" alt="..." /></a>
                        <div class="text-center small">Multipurpose Dashboard</div>
                    </div>
                </div>
                <h2 class="mt-5 mb-0">App Pages</h2>
                <p>App pages to cover common use pages to help build your app!</p>
                <hr class="mt-0 mb-4" />
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="account-billing.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/account-billing.png" alt="..." /></a>
                        <div class="text-center small">Account - Billing</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="account-notifications.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/account-notifications.png" alt="..." /></a>
                        <div class="text-center small">Account - Notifications</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="account-profile.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/account-profile.png" alt="..." /></a>
                        <div class="text-center small">Account - Profile</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="account-security.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/account-security.png" alt="..." /></a>
                        <div class="text-center small">Account - Security</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="auth-login-basic.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-login-basic.png" alt="..." /></a>
                        <div class="text-center small">Auth - Login</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="auth-login-social.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-login-social.png" alt="..." /></a>
                        <div class="text-center small">Auth - Login (Social)</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="multi-tenant-select.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-mutli-tenant.png" alt="..." /></a>
                        <div class="text-center small">Auth - Multi Tenant</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="auth-password-basic.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-password-basic.png" alt="..." /></a>
                        <div class="text-center small">Auth - Password</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="auth-password-social.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-password-social.png" alt="..." /></a>
                        <div class="text-center small">Auth - Password (Social)</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="auth-register-basic.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-register-basic.png" alt="..." /></a>
                        <div class="text-center small">Auth - Register</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="auth-register-social.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-register-social.png" alt="..." /></a>
                        <div class="text-center small">Auth - Register (Social)</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="invoice.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/invoice.png" alt="..." /></a>
                        <div class="text-center small">Invoice</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="knowledge-base-article.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/knowledgebase-article.png" alt="..." /></a>
                        <div class="text-center small">Knowledgebase - Article</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="knowledge-base-category.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/knowledgebase-category.png" alt="..." /></a>
                        <div class="text-center small">Knowledgebase - Category</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="knowledge-base-home-1.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/knowledgebase-home-1.png" alt="..." /></a>
                        <div class="text-center small">Knowledgebase - Home 1</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="knowledge-base-home-2.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/knowledgebase-home-2.png" alt="..." /></a>
                        <div class="text-center small">Knowledgebase - Home 2</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="pricing.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/pricing.png" alt="..." /></a>
                        <div class="text-center small">Pricing</div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a class="d-block lift rounded overflow-hidden mb-2" href="wizard.html"><img class="img-fluid" src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/wizard.png" alt="..." /></a>
                        <div class="text-center small">Wizard</div>
                    </div>
                </div>
                <h2 class="mt-5 mb-0">Starter Layouts</h2>
                <p>Layouts for creating new pages within your project!</p>
                <hr class="mt-0 mb-4" />
                <div class="row">
                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="small mb-1">Navigation</div>
                        <div class="list-group mb-4">
                            <a class="list-group-item list-group-item-action p-3" href="layout-static.html">
                                <div class="d-flex align-items-center justify-content-between">
                                    Static Sidenav
                                    <i class="text-muted" data-feather="arrow-right"></i>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action p-3" href="layout-dark.html">
                                <div class="d-flex align-items-center justify-content-between">
                                    Dark Sidenav
                                    <i class="text-muted" data-feather="arrow-right"></i>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action p-3" href="layout-rtl.html">
                                <div class="d-flex align-items-center justify-content-between">
                                    RTL Layout
                                    <i class="text-muted" data-feather="arrow-right"></i>
                                </div>
                            </a>
                        </div>
                        <div class="small mb-1">Container Options</div>
                        <div class="list-group">
                            <a class="list-group-item list-group-item-action p-3" href="layout-boxed.html">
                                <div class="d-flex align-items-center justify-content-between">
                                    Boxed Layouts
                                    <i class="text-muted" data-feather="arrow-right"></i>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action p-3" href="layout-fluid.html">
                                <div class="d-flex align-items-center justify-content-between">
                                    Fluid Layout
                                    <i class="text-muted" data-feather="arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="small mb-1">Page Headers</div>
                        <div class="list-group">
                            <a class="list-group-item list-group-item-action p-3" href="header-simplified.html">
                                <div class="d-flex align-items-center justify-content-between">
                                    Simplified
                                    <i class="text-muted" data-feather="arrow-right"></i>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action p-3" href="header-compact.html">
                                <div class="d-flex align-items-center justify-content-between">
                                    Compact
                                    <i class="text-muted" data-feather="arrow-right"></i>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action p-3" href="header-overlap.html">
                                <div class="d-flex align-items-center justify-content-between">
                                    Content Overlap
                                    <i class="text-muted" data-feather="arrow-right"></i>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action p-3" href="header-breadcrumbs.html">
                                <div class="d-flex align-items-center justify-content-between">
                                    Breadcrumbs
                                    <i class="text-muted" data-feather="arrow-right"></i>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action p-3" href="header-light.html">
                                <div class="d-flex align-items-center justify-content-between">
                                    Light
                                    <i class="text-muted" data-feather="arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="small mb-1">Starter Layouts</div>
                        <div class="list-group mb-4">
                            <a class="list-group-item list-group-item-action p-3" href="starter-default.html">
                                <div class="d-flex align-items-center justify-content-between">
                                    Default
                                    <i class="text-muted" data-feather="arrow-right"></i>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action p-3" href="starter-minimal.html">
                                <div class="d-flex align-items-center justify-content-between">
                                    Minimal
                                    <i class="text-muted" data-feather="arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="footer-admin mt-auto footer-light">
            <div class="container-xl px-4">
                <div class="row">
                    <div class="col-md-6 small">Copyright &copy; Your Website 2021</div>
                    <div class="col-md-6 text-md-end small">
                        <a href="#!">Privacy Policy</a>
                        &middot;
                        <a href="#!">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection