@php $userRole = Auth::user()->role @endphp

<x-sidebar.sidebar-list href="index" label="Dashboard" icon="tabler-layout-dashboard" />

@if ($userRole == 'Admin')
    <x-dropdown-menu title="Products" icon="heroicon-o-document-duplicate" routeName="products.*">
        <x-sidebar.sidebar-menu-dropdown-item routeName="products.index" title="Product Management" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="categories.index" title="Product Category" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="attributes.index" title="Product Attributes" />
    </x-dropdown-menu>
    <x-dropdown-menu title="Stock" icon="heroicon-m-square-3-stack-3d" routeName="stock.*">
        <x-sidebar.sidebar-menu-dropdown-item routeName="stock.index" title="History Transactions" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="stock.opname" title="Stock Opname" />
    </x-dropdown-menu>
    <x-sidebar.sidebar-list href="suppliers.index" label="Supplier" icon="heroicon-m-user-group" />
    <x-sidebar.sidebar-list href="users.index" label="User" icon="heroicon-s-user" />
    <x-sidebar.sidebar-list href="setting.index" label="Settings" icon="tabler-settings" />
@endif

@if ($userRole == 'Manajer Gudang')
    <x-sidebar.sidebar-list href="products.manager-view" label="Products" icon="heroicon-o-document-duplicate" />
    <x-sidebar.sidebar-list href="suppliers.manager-view" label="Supplier" icon="heroicon-m-user-group" />
    <x-dropdown-menu title="Stock" icon="heroicon-m-square-3-stack-3d" routeName="stock.*">
        <x-sidebar.sidebar-menu-dropdown-item routeName="stock.transaction" title="Transactions" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="stock.manager-opname" title="Stock Opname" />
    </x-dropdown-menu>
@endif

@if ($userRole == 'Staff Gudang')
    <x-dropdown-menu title="Stock" icon="heroicon-m-square-3-stack-3d" routeName="stock.*">
        <x-sidebar.sidebar-menu-dropdown-item routeName="stock.observe" title="Confirmation Stock" />
    </x-dropdown-menu>
@endif
