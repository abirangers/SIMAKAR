<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-blue-50/50">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex items-center shrink-0">
                                <Link :href="route('dashboard')" class="flex items-center text-xl font-black gap-x-1">
                                <img src="/assets/images/logo.png" alt="logo" class="w-6"> KasirOnlen
                                </Link>
                            </div>
                        </div>
                        <!-- Navigation Links -->
                        <div class="items-center hidden gap-x-3 sm:flex menu">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                <i class="pi pi-microsoft"></i>Dashboard
                            </NavLink>
                            <NavLink :href="route('menu.index')" :active="route().current('menu.index') || route().current('menu.create') || route().current('menu.edit')">
                                <i class="pi pi-list"></i>Menu
                            </NavLink>
                            <NavLink :href="route('pendapatan.index')" :active="route().current('pendapatan.index') || route().current('pendapatan.create') || route().current('pendapatan.edit')">
                                <i class="pi pi-money-bill"></i>Pendapatan
                            </NavLink>
                            <NavLink :href="route('cashier.index')" :active="route().current('cashier.index') || route().current('cashier.create') || route().current('cashier.edit')">
                                <i class="pi pi-user"></i>Kasir
                            </NavLink>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="btn btn-ghost hover:bg-primary btn-md text-slate-500 hover:text-white focus:outline-none">
                                                {{ $page.props.auth.user.name }}
                                                <i class="pi pi-chevron-down -me-0.5"></i>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="flex items-center -me-2 sm:hidden">
                            <button @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none">
                                <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('menu.index')" :active="route().current('menu.index') || route().current('menu.create') || route().current('menu.edit')">
                            Menu
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('pendapatan.index')" :active="route().current('pendapatan.index') || route().current('pendapatan.create') || route().current('pendapatan.edit')">
                            Pendapatan
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('cashier.index')" :active="route().current('cashier.index') || route().current('cashier.create') || route().current('cashier.edit')">
                            Kasir
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="mt-16" v-if="$slots.header">
                <div class="flex items-center justify-between px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="py-6">
                    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <slot />
                    </div>
                </div>
            </main>

        <footer class="mt-16">
            <div class="mx-auto max-w-7xl">
                <p class="text-sm text-center text-gray-500">
                    &copy; {{ new Date().getFullYear() }} Ahmad Abby Ayyasi. Hak cipta dilindungi undang-undang.
                </p>
            </div>
        </footer>
        </div>
    </div>
</template>
