@php $userRole = Auth::user()->role @endphp

<x-sidebar.sidebar-list href="index" label="Dashboard" icon="tabler-layout-dashboard" />

@if ($userRole == 'Admin')
    <x-dropdown-menu title="Products" icon="heroicon-o-document-duplicate" routeName="products.*">
        <x-sidebar.sidebar-menu-dropdown-item routeName="products.index" title="Product Management" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="categories.index" title="Product Category" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="attributes.index" title="Product Attributes" />
    </x-dropdown-menu>
    <x-dropdown-menu title="Stock" icon="heroicon-m-square-3-stack-3d" routeName="stock.transaction*">
        <x-sidebar.sidebar-menu-dropdown-item routeName="stock.index" title="History Transactions" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="stock.opname" title="Stock Opname" />
    </x-dropdown-menu>
    <x-sidebar.sidebar-list href="suppliers.index" label="Supplier" icon="heroicon-m-user-group" />
    <x-sidebar.sidebar-list href="users.index" label="User" icon="heroicon-s-user" />
    <x-dropdown-menu title="Settings" icon="tabler-settings" routeName="settings.*">
        <x-sidebar.sidebar-menu-dropdown-item routeName="" title="Common Settings" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="" title="Email Configuration" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="" title="API Management" />
    </x-dropdown-menu>
@endif
