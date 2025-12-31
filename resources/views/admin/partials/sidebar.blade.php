<div class="sidebar-wrapper group">
    <div id="bodyOverlay" class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden">
    </div>

    <div class="logo-segment">
        <a class="flex items-center" href="{{ route('home') }}">
            <!--<img src="{{ asset('assets/images/logo/logo-c.svg') }}" class="black_logo" alt="logo">
            <img src="{{ asset('assets/images/logo/logo-c-white.svg') }}" class="white_logo" alt="logo">-->
            <span class="ltr:ml-3 rtl:mr-3 text-xl font-Inter font-bold text-slate-900 dark:text-white">Binimoy
                Management System</span>
        </a>

        <!-- Sidebar Type Button -->
        <div id="sidebar_type" class="cursor-pointer text-slate-900 dark:text-white text-lg">
            <span class="sidebarDotIcon extend-icon cursor-pointer text-slate-900 dark:text-white text-2xl">
                <div
                    class="h-4 w-4 border-[1.5px] border-slate-900 dark:border-slate-700 rounded-full transition-all duration-150 ring-2 ring-inset ring-offset-4 ring-black-900 dark:ring-slate-400 bg-slate-900 dark:bg-slate-400 dark:ring-offset-slate-700">
                </div>
            </span>
            <span class="sidebarDotIcon collapsed-icon cursor-pointer text-slate-900 dark:text-white text-2xl">
                <div
                    class="h-4 w-4 border-[1.5px] border-slate-900 dark:border-slate-700 rounded-full transition-all duration-150">
                </div>
            </span>
        </div>

        <button class="sidebarCloseIcon text-2xl">
            <iconify-icon class="text-slate-900 dark:text-slate-200" icon="clarity:window-close-line"></iconify-icon>
        </button>
    </div>

    <div id="nav_shadow"
        class="nav_shadow h-[60px] absolute top-[80px] nav-shadow z-[1] w-full transition-all duration-200 pointer-events-none opacity-0">
    </div>

    <div class="sidebar-menus bg-white dark:bg-slate-800 py-2 px-4 h-[calc(100%-80px)] overflow-y-auto z-50"
        id="sidebar_menus">
        <ul class="sidebar-menu">
            <li class="sidebar-menu-title">MENU</li>

            <!-- Dashboard -->
            <li>
                <a href="{{ route('home') }}" class="navItem">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="heroicons-outline:home"></iconify-icon>
                        <span>Dashboard</span>
                    </span>
                </a>
            </li>

            <!-- Users -->
            @canany(['user-list', 'user-create', 'user-edit', 'user-delete'])
                <li>
                    <a href="#" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons:users"></iconify-icon>
                            <span>Users</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        @can('user-list')
                            <li>
                                <a href="{{ route('users.index') }}">User List</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            <!-- Roles -->
            @canany(['role-list', 'role-create', 'role-edit', 'role-delete'])
                <li>
                    <a href="#" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons:shield-check"></iconify-icon>
                            <span>Roles</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        @can('role-list')
                            <li>
                                <a href="{{ route('roles.index') }}">Role List</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            <!-- Members -->
            @canany(['member-list', 'member-create', 'member-edit', 'member-delete'])
                <li>
                    <a href="#" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons:user-group"></iconify-icon>
                            <span>Members</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        @can('member-list')
                            <li>
                                <a href="{{ route('members.index') }}">Members List</a>
                            </li>
                            <li>
                                <a href="{{ route('members.summary') }}">Profile Summary</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            <!-- Savings -->
            @canany(['saving-list', 'saving-create', 'saving-edit', 'saving-delete'])
                <li>
                    <a href="#" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons:banknotes"></iconify-icon>

                            <span>Savings</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        @can('saving-list')
                            <li>
                                <a href="{{ route('savings.index') }}">Savings Dashboard</a>
                            </li>
                            <li>
                                <a href="{{ route('savings.summary') }}"> Accounts Summary</a>
                            </li>
                            <li>
                                <a href="{{ route('savings.withdrawals') }}">Withdrawal Requests</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['loan-list', 'loan-create', 'loan-edit', 'loan-delete'])
                <li>
                    <a href="#" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons:currency-dollar"></iconify-icon>

                            <span>Loans</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        @can('loan-list')
                            <li>
                                <a href="{{ route('loans.index') }}">Loan List</a>
                            </li>
                        @endcan
                        @can('loan-proposal-list')
                            <li>
                                <a href="{{ route('loan_proposals.index') }}">Loan Proposals</a>
                            </li>
                        @endcan
                        @can('loan-installments')
                            <li>
                                <a href="{{ route('loan_installments.index') }}">Installments</a>
                            </li>
                        @endcan
                        @can('loan-collections')
                            <li>
                                <a href="{{ route('loan_collections.index') }}">Collections</a>
                            </li>
                        @endcan
                        @can('loan-guarantor-list')
                            <li>
                                <a href="{{ route('loan_guarantors.index') }}">Guarantors</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany


            <!-- Partners -->
            @canany(['partner-list', 'partner-create', 'partner-edit', 'partner-delete'])
                <li>
                    <a href="#" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons:users"></iconify-icon>

                            <span>Partners</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        @can('partner-list')
                            <li>
                                <a href="{{ route('partners.index') }}">Partners</a>
                            </li>
                        @endcan
                        @can('investment-list')
                            <li>
                                <a href="{{ route('investments.index') }}">Investments</a>
                            </li>
                        @endcan
                        @can('withdrawal-list')
                            <li>
                                <a href="{{ route('withdrawals.index') }}">Withdrawals</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            <!-- Cash Assets & Company Fund -->
            @canany(['cash-asset-list', 'companyfund-view'])
                <li>
                    <a href="#" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons-outline:cash"></iconify-icon>

                            <span>Cash & Fund</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        @can('cash-asset-list')
                            <li>
                                <a href="{{ route('cash_assets.index') }}">Cash Assets</a>
                            </li>
                        @endcan
                        @can('companyfund-view')
                            <li>
                                <a href="{{ route('companyfund.index') }}">Company Fund</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            <!-- Reports -->
            @can('report-view')
                <li>
                    <a href="#" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons-outline:document-report"></iconify-icon>

                            <span>Reports</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('reports.profit_loss') }}">Profit & Loss</a></li>
                        <li><a href="{{ route('reports.balance_sheet') }}">Balance Sheet</a></li>
                        <li><a href="{{ route('reports.cash_flow') }}">Cash Flow</a></li>
                        <li><a href="{{ route('reports.collections') }}">Collections</a></li>
                    </ul>
                </li>
            @endcan

            <!-- Notifications & Audit -->
            @can('notification-view')
                <li>
                    <a href="{{ route('notifications.index') }}" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons-outline:bell"></iconify-icon>
                            <span>Notifications</span>
                        </span>
                    </a>
                </li>
            @endcan

            @can('audit-view')
                <li>
                    <a href="{{ route('audit_logs.index') }}" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons-outline:shield-exclamation"></iconify-icon>
                            <span>Audit Logs</span>
                        </span>
                    </a>
                </li>
            @endcan

        </ul>
        <!-- Upgrade Your Business Plan Card Start -->
    </div>
</div>
