# Official Project Stack

## Backend
- Laravel 12
- PHP 8.3+

## Frontend
- Laravel Livewire v4
- Alpine.js
- Tailwind CSS

## Architecture
- Server-driven application
- No SPA
- No Inertia.js
- No internal REST APIs
- Livewire manages state and UI flow

## Technical Rules
- Controllers are only for routing and orchestration
- Business logic must live in Services or Actions
- UI must be implemented using Livewire components
- Alpine.js is limited to local UI interactions (toggle, modal, dropdown)

## Forbidden Technologies
- React
- Vue
- Angular
- Svelte
- Inertia.js
- Axios / Fetch API
