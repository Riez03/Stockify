@php $userRole = Auth::user()->role @endphp

<x-sidebar.sidebar-list href="index" label="Dashboard" icon="tabler-layout-dashboard" />

@if ($userRole == 'Admin')
    <x-dropdown-menu title="Products" icon="heroicon-o-document-duplicate" routeName="products.*">
        <x-sidebar.sidebar-menu-dropdown-item routeName="products.index" title="Product Management" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="categories.index" title="Product Category" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="attributes.index" title="Product Attributes" />
    </x-dropdown-menu>
    <x-dropdown-menu title="Stock" icon="heroicon-m-square-3-stack-3d" routeName="stock.*">
        <x-sidebar.sidebar-menu-dropdown-item routeName="" title="History Transactions" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="" title="Stock Opname" />
    </x-dropdown-menu>
    <x-sidebar.sidebar-list href="suppliers.index" label="Supplier Management" icon="heroicon-m-user-group" />
    <x-dropdown-menu title="User" icon="heroicon-s-user" routeName="users.*">
        <x-sidebar.sidebar-menu-dropdown-item routeName="" title="User Management" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="" title="Role Management" />
    </x-dropdown-menu>
    <x-dropdown-menu title="Settings" icon="tabler-settings" routeName="settings.*">
        <x-sidebar.sidebar-menu-dropdown-item routeName="" title="Common Settings" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="" title="Email Configuration" />
        <x-sidebar.sidebar-menu-dropdown-item routeName="" title="API Management" />
    </x-dropdown-menu>
@endif
