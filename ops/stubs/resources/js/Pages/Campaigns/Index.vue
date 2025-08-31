<script setup>
import { Head, Link } from '@inertiajs/vue3'
defineProps({ campaigns: Object, filters: Object })
</script>
<template>
  <Head title="Campaigns" />
  <div class="max-w-3xl mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
      <h1 class="text-2xl font-bold">Campaigns</h1>
      <Link class="px-3 py-2 rounded bg-blue-600 text-white" href="/campaigns/create">New campaign</Link>
    </div>
    <form method="GET" class="mb-4">
      <input name="q" :value="filters?.q ?? ''" class="border rounded px-3 py-2 w-full" placeholder="Search campaigns..." />
    </form>
    <div v-if="campaigns.data.length === 0" class="text-gray-600">No campaigns yet.</div>
    <ul v-else class="space-y-3">
      <li v-for="c in campaigns.data" :key="c.id" class="border rounded p-4">
        <div class="flex items-center justify-between">
          <div><h2 class="text-lg font-semibold">{{ c.title }}</h2><p class="text-sm text-gray-600 line-clamp-2">{{ c.description }}</p></div>
          <Link class="text-blue-600 underline" :href="`/campaigns/${c.id}`">Open</Link>
        </div>
      </li>
    </ul>
    <div class="mt-4 flex gap-2" v-if="campaigns.links">
      <Link v-for="l in campaigns.links" :key="l.url || l.label" :href="l.url || '#'" v-html="l.label"
        :class="['px-3 py-1 rounded border', l.active ? 'bg-blue-600 text-white' : 'bg-white']" />
    </div>
  </div>
</template>
