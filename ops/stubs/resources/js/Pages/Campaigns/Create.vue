<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
const form = useForm({ title:'', description:'', goal_amount:1000, starts_at:'', ends_at:'', status:'draft' })
function submit(){ form.post('/campaigns') }
</script>
<template>
  <Head title="Create Campaign" />
  <div class="max-w-2xl mx-auto p-6 space-y-4">
    <h1 class="text-2xl font-bold">Create a campaign</h1>
    <div class="space-y-2"><label class="block">Title</label><input v-model="form.title" class="border rounded px-3 py-2 w-full"/><div class="text-red-600 text-sm" v-if="form.errors.title">{{ form.errors.title }}</div></div>
    <div class="space-y-2"><label class="block">Description</label><textarea v-model="form.description" class="border rounded px-3 py-2 w-full" rows="5"></textarea><div class="text-red-600 text-sm" v-if="form.errors.description">{{ form.errors.description }}</div></div>
    <div class="grid grid-cols-2 gap-4">
      <div class="space-y-2"><label class="block">Goal amount (€)</label><input type="number" v-model="form.goal_amount" class="border rounded px-3 py-2 w-full"/><div class="text-red-600 text-sm" v-if="form.errors.goal_amount">{{ form.errors.goal_amount }}</div></div>
      <div class="space-y-2"><label class="block">Status</label><select v-model="form.status" class="border rounded px-3 py-2 w-full"><option value="draft">draft</option><option value="active">active</option><option value="closed">closed</option></select></div>
    </div>
    <div class="grid grid-cols-2 gap-4">
      <div class="space-y-2"><label class="block">Starts at</label><input type="datetime-local" v-model="form.starts_at" class="border rounded px-3 py-2 w-full"/></div>
      <div class="space-y-2"><label class="block">Ends at</label><input type="datetime-local" v-model="form.ends_at" class="border rounded px-3 py-2 w-full"/></div>
    </div>
    <div class="flex gap-3"><button @click.prevent="submit" class="px-4 py-2 rounded bg-blue-600 text-white">Create</button><Link href="/campaigns" class="px-4 py-2 rounded border">Cancel</Link></div>
  </div>
</template>
