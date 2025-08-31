<script setup>
import { Head, useForm } from '@inertiajs/vue3'
const props = defineProps({ campaign: Object })
const form = useForm({ campaign_id: props.campaign.id, amount: 20 })
function donate(){ form.post('/donations') }
</script>
<template>
  <Head :title="campaign.title" />
  <div class="max-w-3xl mx-auto p-6 space-y-6">
    <h1 class="text-3xl font-bold">{{ campaign.title }}</h1>
    <p class="text-gray-700 whitespace-pre-line">{{ campaign.description }}</p>
    <div class="grid grid-cols-3 gap-4">
      <div class="border rounded p-4"><div class="text-sm text-gray-600">Goal</div><div class="text-xl font-semibold">€{{ Number(campaign.goal_amount).toFixed(2) }}</div></div>
      <div class="border rounded p-4"><div class="text-sm text-gray-600">Raised</div><div class="text-xl font-semibold">€{{ Number(campaign.current_amount).toFixed(2) }}</div></div>
      <div class="border rounded p-4"><div class="text-sm text-gray-600">Donations</div><div class="text-xl font-semibold">{{ campaign.donations_count ?? 0 }}</div></div>
    </div>
    <form @submit.prevent="donate" class="border rounded p-4 space-y-3">
      <div class="text-lg font-medium">Donate</div>
      <div class="flex items-center gap-3"><span>€</span><input type="number" v-model="form.amount" class="border rounded px-3 py-2 w-40" min="1" step="1"/><button class="px-4 py-2 rounded bg-emerald-600 text-white">Donate</button></div>
      <div v-if="form.errors.amount" class="text-red-600 text-sm">{{ form.errors.amount }}</div>
      <div v-if="$page.props.flash?.success" class="text-emerald-700">{{ $page.props.flash.success }}</div>
      <div v-if="$page.props.flash?.error" class="text-red-700">{{ $page.props.flash.error }}</div>
    </form>
  </div>
</template>
