<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar with Additional Links</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .bg-white {
            background-color: #ffffff;
        }

        .dark\:bg-gray-800 {
            background-color: #2d3748;
        }

        .border-b {
            border-bottom: 1px solid;
        }

        .border-gray-100 {
            border-color: #edf2f7;
        }

        .dark\:border-gray-700 {
            border-color: #4a5568;
        }

        .max-w-7xl {
            max-width: 112rem;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .sm\:px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .lg\:px-8 {
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .flex {
            display: flex;
        }

        .justify-between {
            justify-content: space-between;
        }

        .h-16 {
            height: 4rem;
        }

        .shrink-0 {
            flex-shrink: 0;
        }

        .items-center {
            align-items: center;
        }

        .hidden {
            display: none;
        }

        .space-x-8 > :not([hidden]) ~ :not([hidden]) {
            margin-left: 2rem;
        }

        .sm\:-my-px {
            margin-top: -1px;
            margin-bottom: -1px;
        }

        .sm\:ms-10 {
            margin-left: 2.5rem;
        }

        .sm\:flex {
            display: flex;
        }

        .sm\:items-center {
            align-items: center;
        }

        .sm\:ms-6 {
            margin-left: 1.5rem;
        }

        .text-gray-500 {
            color: #6b7280;
        }

        .dark\:text-gray-400 {
            color: #9ca3af;
        }

        .bg-white {
            background-color: #ffffff;
        }

        .dark\:bg-gray-800 {
            background-color: #2d3748;
        }

        .hover\:text-gray-700:hover {
            color: #374151;
        }

        .dark\:hover\:text-gray-300:hover {
            color: #d1d5db;
        }

        .focus\:outline-none {
            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        .transition {
            transition: all 0.3s ease-in-out;
        }

        .duration-150 {
            transition-duration: 150ms;
        }

        .ease-in-out {
            transition-timing-function: ease-in-out;
        }

        .inline-flex {
            display: inline-flex;
        }

        .rounded-md {
            border-radius: 0.375rem;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .leading-4 {
            line-height: 1rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .border-transparent {
            border-color: transparent;
        }

        .hover\:bg-gray-100:hover {
            background-color: #f7fafc;
        }

        .dark\:hover\:bg-gray-900:hover {
            background-color: #1a202c;
        }

        .focus\:bg-gray-100:focus {
            background-color: #f7fafc;
        }

        .dark\:focus\:bg-gray-900:focus {
            background-color: #1a202c;
        }

        .focus\:text-gray-500:focus {
            color: #6b7280;
        }

        .dark\:focus\:text-gray-400:focus {
            color: #9ca3af;
        }

        .-me-2 {
            margin-right: -0.5rem;
        }

        .sm\:hidden {
            display: none;
        }

        .block {
            display: block;
        }

        .pt-2 {
            padding-top: 0.5rem;
        }

        .pb-3 {
            padding-bottom: 0.75rem;
        }

        .space-y-1 > :not([hidden]) ~ :not([hidden]) {
            margin-top: 0.25rem;
        }

        .border-t {
            border-top: 1px solid;
        }

        .border-gray-200 {
            border-color: #edf2f7;
        }

        .dark\:border-gray-600 {
            border-color: #4a5568;
        }

        .pt-4 {
            padding-top: 1rem;
        }

        .pb-1 {
            padding-bottom: 0.25rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .text-base {
            font-size: 1rem;
        }

        .text-gray-800 {
            color: #2d3748;
        }

        .text-gray-200 {
            color: #edf2f7;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .mt-3 {
            margin-top: 0.75rem;
        }

        .duration-150 {
            transition-duration: 150ms;
        }

        .ease-in-out {
            transition-timing-function: ease-in-out;
        }
    </style>
</head>
<body>
<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('users.create')" :active="request()->routeIs('users.create')">
                        {{ __('New User') }}
                    </x-nav-link>
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                        {{ __('User List') }}
                    </x-nav-link>
                    <x-nav-link :href="route('users.trashed')" :active="request()->routeIs('users.trashed')">
                        {{ __('Trashed User') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->username }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('users.create')" :active="request()->routeIs('users.create')">
                {{ __('New User') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                {{ __('User List') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('users.trashed')" :active="request()->routeIs('users.trashed')">
                {{ __('Trashed User') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->username }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
</body>
</html>
