<template>
    <div class="nav-item dropdown d-none d-md-flex mr-3">
        <a href="#" class="nav-link px-0" data-toggle="dropdown" tabindex="-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z"/>
                <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
            </svg>
            <span class="badge bg-red"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
            <a href="#" class="dropdown-item d-flex">
                <i class="far fa-bell"></i>
                <div>
                    <strong>Nathan</strong> pushed new commit: Fix page load performance issue.
                    <div class="small text-muted">10 minutes ago</div>
                </div>
            </a>
            <a href="#" class="dropdown-item d-flex">
                <div>
                    <strong>Alice</strong> started new task: Tabler UI design.
                    <div class="small text-muted">1 hour ago</div>
                </div>
            </a>
            <a href="#" class="dropdown-item d-flex">
                <div>
                    <strong>Rose</strong> deployed new version of NodeJS REST Api V3
                    <div class="small text-muted">2 hours ago</div>
                </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item text-center">Mark all as read</a>
        </div>
    </div>
</template>
