<script setup>import { Head } from '@inertiajs/vue3'; defineProps({ stats:Object })</script>
<template>
  <Head title="Admin Dashboard" />
  <div class="max-w-4xl mx-auto p-6 space-y-6">
    <h1 class="text-3xl font-bold">Admin Dashboard</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="border rounded p-4"><div class="text-sm text-gray-600">Campaigns</div><div class="text-2xl font-semibold">{{ stats.campaigns }}</div></div>
      <div class="border rounded p-4"><div class="text-sm text-gray-600">Donations</div><div class="text-2xl font-semibold">{{ stats.donations }}</div></div>
      <div class="border rounded p-4"><div class="text-sm text-gray-600">Donated €</div><div class="text-2xl font-semibold">€{{ Number(stats.donated_sum).toFixed(2) }}</div></div>
      <div class="border rounded p-4"><div class="text-sm text-gray-600">Active campaigns</div><div class="text-2xl font-semibold">{{ stats.active_campaigns }}</div></div>
    </div>
    <p class="text-sm text-gray-600">Admin access is restricted. Seeded admin user: <code>admin@example.com</code> / <code>password</code></p>
  </div>
</template>
